<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RecoverPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\RecoverPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\RecoverPasswordResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\RecoverPassword;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

/**
 * Class RecoverPasswordTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Security
 */
class RecoverPasswordTest extends TestCase
{
    /**
     * @var RecoverPassword
     */
    private RecoverPassword $useCase;

    /**
     * @var RecoverPasswordPresenterInterface
     */
    private RecoverPasswordPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class () implements RecoverPasswordPresenterInterface {
            public RecoverPasswordResponse $response;

            public function present(RecoverPasswordResponse $response): void
            {
                $this->response = $response;
            }
        };

        $gateway = new ParticipantRepository();

        $this->useCase = new RecoverPassword($gateway);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testSuccessful(): void
    {
        $request = new RecoverPasswordRequest('used@email.com', 'new_password');

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(RecoverPasswordResponse::class, $this->presenter->response);

        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());

        $this->assertTrue(password_verify('new_password', $this->presenter->response->getParticipant()->getPassword()));
    }

    /**
     * @dataProvider provideInvalidEmailAndPassword
     * @param string $email
     * @param string $newPlainPassword
     */
    public function testFailed(string $email, string $newPlainPassword): void
    {
        $request = new RecoverPasswordRequest($email, $newPlainPassword);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideInvalidEmailAndPassword(): Generator
    {
        yield ['', 'new_password'];
        yield ['used_email.com', 'new_password'];
        yield ['fail@email.com', 'new_password'];
        yield ['used@email.com', ''];
        yield ['used@email.com', 'fail'];
    }
}
