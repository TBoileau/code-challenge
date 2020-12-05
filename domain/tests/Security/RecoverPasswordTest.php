<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Exception\ParticipantNotFoundException;
use TBoileau\CodeChallenge\Domain\Security\Exception\PasswordRecoveryInvalidTokenException;
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
        $request = new RecoverPasswordRequest('used@email.com', 'new_password', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a');

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(RecoverPasswordResponse::class, $this->presenter->response);

        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());

        $this->assertTrue(password_verify('new_password', $this->presenter->response->getParticipant()->getPassword()));
    }

    /**
     * @dataProvider provideInvalidEmailAndPassword
     * @param string $email
     * @param string $newPlainPassword
     * @param string $token
     * @throws AssertionFailedException
     */
    public function testFailed(string $email, string $newPlainPassword, string $token): void
    {
        $request = new RecoverPasswordRequest($email, $newPlainPassword, $token);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testParticipantNotFound(): void
    {
        $request = new RecoverPasswordRequest('fail@email.com', 'new_password', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a');

        $this->expectException(PasswordRecoveryInvalidTokenException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testInvalidToken(): void
    {
        $request = new RecoverPasswordRequest('used@email.com', 'new_password', 'aa4b5730-6057-4fa1-a27b-692b9ba8c14a');

        $this->expectException(PasswordRecoveryInvalidTokenException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideInvalidEmailAndPassword(): Generator
    {
        yield ['', 'new_password', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a'];
        yield ['used_email.com', 'new_password', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a'];
        yield ['used@email.com', '', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a'];
        yield ['used@email.com', 'fail', 'bb4b5730-6057-4fa1-a27b-692b9ba8c14a'];
        yield ['used@email.com', 'fail', ''];
    }
}
