<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RegistrationPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\Registration;
use PHPUnit\Framework\TestCase;

/**
 * Class RegistrationTest
 *
 * @package TBoileau\CodeChallenge\Domain\Tests\Security
 */
class RegistrationTest extends TestCase
{
    /**
     * @var Registration
     */
    private Registration $useCase;

    /**
     * @var RegistrationPresenterInterface
     */
    private RegistrationPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class () implements RegistrationPresenterInterface {
            public RegistrationResponse $response;

            public function present(RegistrationResponse $response): void
            {
                $this->response = $response;
            }
        };

        $participantGateway = new class () implements ParticipantGateway {
            public function isEmailUnique(?string $email): bool
            {
                return !in_array($email, ["used@email.com"]);
            }

            public function isPseudoUnique(?string $pseudo): bool
            {
                return !in_array($pseudo, ["used_pseudo"]);
            }

            public function register(Participant $participant): void
            {
            }
        };

        $this->useCase = new Registration($participantGateway);
    }

    public function testSuccessful(): void
    {
        $request = RegistrationRequest::create("email@email.com", "pseudo", "password");

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(RegistrationResponse::class, $this->presenter->response);
        $this->assertInstanceOf(UuidInterface::class, $this->presenter->response->getParticipant()->getId());
        $this->assertEquals("email@email.com", $this->presenter->response->getParticipant()->getEmail());
        $this->assertEquals("pseudo", $this->presenter->response->getParticipant()->getPseudo());
        $this->assertTrue(password_verify("password", $this->presenter->response->getParticipant()->getPassword()));
    }

    /**
     * @dataProvider provideFailedRequestData
     * @param        string $email
     * @param        string $pseudo
     * @param        string $plainPassword
     */
    public function testFailedRequest(string $email, string $pseudo, string $plainPassword): void
    {
        $request = RegistrationRequest::create($email, $pseudo, $plainPassword);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideFailedRequestData(): Generator
    {
        yield ["", "pseudo", "password"];
        yield ["email", "pseudo", "password"];
        yield ["email@email.com", "", "password"];
        yield ["email@email.com", "pseudo", ""];
        yield ["email@email.com", "pseudo", "fail"];
        yield ["used@email.com", "pseudo", "password"];
        yield ["email@email.com", "used_pseudo", "password"];
    }
}
