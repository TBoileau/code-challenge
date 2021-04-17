<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Presenter\UpdateProfilePresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\UpdateProfileRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;

class UpdateProfile
{

    private ParticipantGateway $participantGateway;

    public function __construct(ParticipantGateway $participantGateway)
    {
        $this->participantGateway = $participantGateway;
    }

    /**
     * @param UpdateProfileRequest $request
     * @param UpdateProfilePresenterInterface $presenter
     * @throws \Assert\AssertionFailedException
     */
    public function execute(UpdateProfileRequest $request, UpdateProfilePresenterInterface $presenter): void
    {
        $participant = $this->participantGateway->getParticipantById($request->getId());

        $request->validate($this->participantGateway, $participant);

        $participant->setPseudo($request->getPseudo());
        $participant->setEmail($request->getEmail());

        $this->participantGateway->update($participant);

        $response = new UpdateProfileResponse($participant);

        $presenter->present($response);
    }
}
