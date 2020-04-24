<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use Ramsey\Uuid\Uuid;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RegistrationPresenterInterface;

/**
 * Class Registration
 *
 * @package TBoileau\CodeChallenge\Domain\Security\UseCase
 */
class Registration
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $participantGateway;

    /**
     * Registration constructor.
     *
     * @param ParticipantGateway $participantGateway
     */
    public function __construct(ParticipantGateway $participantGateway)
    {
        $this->userGateway = $participantGateway;
    }

    /**
     * @param RegistrationRequest            $request
     * @param RegistrationPresenterInterface $presenter
     */
    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter)
    {
        $request->validate($this->userGateway);
        $user = Participant::fromRegistration($request);
        $this->userGateway->register($user);
        $presenter->present(new RegistrationResponse($user));
    }
}
