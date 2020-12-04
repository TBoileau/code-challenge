<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use Assert\AssertionFailedException;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\PasswordResetLinkGeneratorInterface;
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
     * @var PasswordResetLinkGeneratorInterface
     */
    private PasswordResetLinkGeneratorInterface $generator;

    /**
     * AskPasswordReset constructor.
     * @param ParticipantGateway $gateway
     * @param MailProviderInterface $mailer
     * @param PasswordResetLinkGeneratorInterface $generator
     */
    public function __construct(ParticipantGateway $gateway, MailProviderInterface $mailer, PasswordResetLinkGeneratorInterface $generator)
    {
        $this->gateway = $gateway;
        $this->mailer = $mailer;
        $this->generator = $generator;
    }

    /**
     * @param AskPasswordResetRequest $request
     * @param AskPasswordResetPresenterInterface $presenter
     * @throws AssertionFailedException
     */
    public function execute(AskPasswordResetRequest $request, AskPasswordResetPresenterInterface $presenter)
    {
        $request->validate($this->gateway);

        /** @var Participant $participant */
        $participant = $this->gateway->getParticipantByEmail($request->getEmail());

        $link = $this->generator->generateLink($participant);

        $presenter->present(
            new AskPasswordResetResponse(
                $this->mailer->send(
                    'from@email.com',
                    $request->getEmail(),
                    'Password reset request',
                    $link
                ),
                $link
            )
        );
    }
}
