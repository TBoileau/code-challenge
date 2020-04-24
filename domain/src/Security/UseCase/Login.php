<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Request\LoginRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\LoginResponse;
use TBoileau\CodeChallenge\Domain\Security\Presenter\LoginPresenterInterface;

/**
 * Class Login
 * @package TBoileau\CodeChallenge\Domain\Security\UseCase
 */
class Login
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $participant;

    /**
     * Login constructor.
     * @param ParticipantGateway $participant
     */
    public function __construct(ParticipantGateway $participant)
    {
        $this->participant = $participant;
    }

    /**
     * @param LoginRequest $request
     * @param LoginPresenterInterface $presenter
     */
    public function execute(LoginRequest $request, LoginPresenterInterface $presenter)
    {
        $request->validate();

        $participant = $this->participant->getParticipantByEmail($request->getEmail());

        if ($participant) {
            $passwordValid = password_verify($request->getPassword(), $participant->getPassword());
        }

        $presenter->present(new LoginResponse($participant, $passwordValid ?? false));
    }
}
