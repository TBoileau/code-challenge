<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Presenter\AskPasswordResetPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\PasswordResetLinkGeneratorInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\AskPasswordResetRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\AskPasswordResetResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\AskPasswordReset;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

/**
 * Class AskPasswordResetTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Security
 */
class AskPasswordResetTest extends TestCase
{
    /**
     * @var AskPasswordReset
     */
    private AskPasswordReset $useCase;

    /**
     * @var AskPasswordResetPresenterInterface
     */
    private AskPasswordResetPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements AskPasswordResetPresenterInterface {
            public AskPasswordResetResponse $response;

            public function present(AskPasswordResetResponse $response): void
            {
                $this->response = $response;
            }
        };

        $mailer = new  class() implements MailProviderInterface {
            public function send(string $from, string $to, string $subject, string $message): bool
            {
                return true;
            }

        };

        $generator = new class() implements PasswordResetLinkGeneratorInterface {
            public function generateLink(Participant $participant): string
            {
                return 'link';
            }

        };

        $gateway = new ParticipantRepository();

        $this->useCase = new AskPasswordReset($gateway, $mailer, $generator);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testSuccess(): void
    {
        $request = new AskPasswordResetRequest('used@email.com');

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(AskPasswordResetResponse::class, $this->presenter->response);

        $this->assertTrue($this->presenter->response->isPasswordResetLinkSent());

        $this->assertEquals('link', $this->presenter->response->getLink());
    }

    /**
     * @dataProvider provideInvalidEmail
     * @param string $email
     */
    public function testFailed(string $email): void
    {
        $request = new AskPasswordResetRequest($email);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideInvalidEmail(): Generator
    {
        yield [''];
        yield ['used_email.com'];
        yield ['fail@email.com'];
    }
}
