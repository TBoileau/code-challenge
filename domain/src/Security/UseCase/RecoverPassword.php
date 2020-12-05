<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use Assert\AssertionFailedException;
use Assert\InvalidArgumentException;
use DateTimeImmutable;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Exception\ParticipantNotFoundException;
use TBoileau\CodeChallenge\Domain\Security\Exception\PasswordRecoveryInvalidTokenException;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Request\RecoverPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\RecoverPasswordResponse;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RecoverPasswordPresenterInterface;

/**
 * Class RecoverPassword
 * @package TBoileau\CodeChallenge\Domain\Security\UseCase
 */
class RecoverPassword
{
    public const TOKEN_TIMEOUT = 600;

    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $gateway;

    /**
     * RecoverPassword constructor.
     * @param ParticipantGateway $gateway
     */
    public function __construct(ParticipantGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param RecoverPasswordRequest $request
     * @param RecoverPasswordPresenterInterface $presenter
     * @throws AssertionFailedException
     * @throws ParticipantNotFoundException
     * @throws PasswordRecoveryInvalidTokenException
     */
    public function execute(RecoverPasswordRequest $request, RecoverPasswordPresenterInterface $presenter)
    {
        $request->validate();

        /** @var Participant $participant */
        $participant = $this->gateway->getParticipantByEmail($request->getEmail());//dd($participant);

        if (null === $participant) {
            throw new PasswordRecoveryInvalidTokenException(
                "Participant with {$request->getEmail()} doesn't exist.",
                400
            );
        }

        if (!$this->isTokenValid($request, $participant)) {
            throw new PasswordRecoveryInvalidTokenException("Invalid token.", 400);
        }

        Participant::resetPassword($participant, $request);

        $this->gateway->update($participant);

        $presenter->present(new RecoverPasswordResponse($participant));
    }

    private function isTokenValid(RecoverPasswordRequest $request, Participant $participant): bool
    {
        if (!$participant->getPasswordResetRequestedAt()) {
            return false;
        }
        $interval =
            (new DateTimeImmutable())->getTimestamp() - $participant->getPasswordResetRequestedAt()->getTimestamp();

        return $request->getToken() === $participant->getPasswordResetToken() && self::TOKEN_TIMEOUT >= $interval;
    }
}
