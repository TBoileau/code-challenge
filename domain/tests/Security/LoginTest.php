<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Presenter\LoginPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\LoginRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\LoginResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\Login;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

/**
 * Class LoginTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Security
 */
class LoginTest extends TestCase
{
    /**
     * @var Login
     */
    private Login $useCase;

    /**
     * @var LoginPresenterInterface
     */
    private LoginPresenterInterface $presenter;

    protected function setUp(): void
    {
        $participantGateway = new ParticipantRepository();

        $this->presenter = new class () implements LoginPresenterInterface {
            public LoginResponse $response;

            public function present(LoginResponse $response): void
            {
                $this->response = $response;
            }
        };

        $this->useCase = new Login($participantGateway);
    }


    public function testSuccessful(): void
    {
        $request = LoginRequest::create("used@email.com", "password");

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(LoginResponse::class, $this->presenter->response);

        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());

        $this->assertTrue($this->presenter->response->isPasswordValid());
    }

    public function testIfEmailNotFound()
    {
        $request = LoginRequest::create("email@email.com", "password");

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(LoginResponse::class, $this->presenter->response);

        $this->assertNull($this->presenter->response->getParticipant());
    }

    public function testIfPasswordInvalid()
    {
        $request = LoginRequest::create("used@email.com", "fail");

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(LoginResponse::class, $this->presenter->response);

        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());

        $this->assertFalse($this->presenter->response->isPasswordValid());
    }

    /**
     * @dataProvider provideFailedRequestData
     * @param string $email
     * @param string $password
     */
    public function testFailedRequest(string $email, string $password)
    {
        $request = LoginRequest::create($email, $password);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideFailedRequestData(): Generator
    {
        yield ["", "password"];
        yield ["email@email.com", ""];
    }
}
