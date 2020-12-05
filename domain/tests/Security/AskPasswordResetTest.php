<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;
use TBoileau\CodeChallenge\Domain\Security\Presenter\AskPasswordResetPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface;
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
        $this->presenter = new class () implements AskPasswordResetPresenterInterface {
            public AskPasswordResetResponse $response;

            public function present(AskPasswordResetResponse $response): void
            {
                $this->response = $response;
            }
        };

        $mailer = new  class () implements MailProviderInterface {
            public function sendPasswordResetLink(string $email, string $pseudo, string $link): void
            {
            }
        };

        $generator = new class () implements RouterInterface {
            public function setContext(RequestContext $context)
            {
            }

            public function getContext()
            {
            }

            public function getRouteCollection()
            {
            }

            public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH)
            {
                return
                    'https://127.0.0.1:8000/handle-reset-password/used@email.com/bb4b5730-6057-4fa1-a27b-692b9ba8c14a';
            }

            public function match(string $pathinfo)
            {
                return true;
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

        $this->assertNotNull($this->presenter->response->getParticipant()->getPasswordResetToken());

        $this->assertNotNull($this->presenter->response->getParticipant()->getPasswordResetRequestedAt());
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
    }
}
