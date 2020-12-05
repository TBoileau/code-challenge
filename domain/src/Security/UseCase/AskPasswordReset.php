<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use Assert\AssertionFailedException;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\AskPasswordResetRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\AskPasswordResetResponse;
use TBoileau\CodeChallenge\Domain\Security\Presenter\AskPasswordResetPresenterInterface;

/**
 * Class AskPasswordReset
 * @package TBoileau\CodeChallenge\Domain\Security\UseCase
 */
class AskPasswordReset
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $gateway;

    /**
     * @var MailProviderInterface
     */
    private MailProviderInterface $mailer;

    /**
     * @var RouterInterface
     */
    private RouterInterface $urlGenerator;

    /**
     * AskPasswordReset constructor.
     * @param ParticipantGateway $gateway
     * @param MailProviderInterface $mailer
     * @param RouterInterface $urlGenerator
     */
    public function __construct(
        ParticipantGateway $gateway,
        MailProviderInterface $mailer,
        RouterInterface $urlGenerator
    ) {
        $this->gateway = $gateway;
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param AskPasswordResetRequest $request
     * @param AskPasswordResetPresenterInterface $presenter
     * @throws AssertionFailedException
     * @throws Exception
     */
    public function execute(AskPasswordResetRequest $request, AskPasswordResetPresenterInterface $presenter)
    {
        $request->validate();

        /** @var Participant $participant */
        $participant = $this->gateway->getParticipantByEmail($request->getEmail());

        if ($participant) {
            Participant::requestPasswordReset($participant, Uuid::uuid4());

            $this->gateway->update($participant);

            $link = $this->urlGenerator->generate(
                'recover_password',
                [
                    'email' => $participant->getEmail(),
                    'token' => $participant->getPasswordResetToken(),
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $this->mailer->sendPasswordResetLink($participant->getEmail(), $participant->getPseudo(), $link);
        }

        $presenter->present(new AskPasswordResetResponse($participant));
    }
}
