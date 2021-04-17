<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Presenter\UpdateProfilePresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\UploaderProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\UpdateProfileRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;

class UpdateProfile
{

    private ParticipantGateway $participantGateway;

    private UploaderProviderInterface $uploaderProvider;

    public function __construct(ParticipantGateway $participantGateway, UploaderProviderInterface $uploaderProvider)
    {
        $this->participantGateway = $participantGateway;
        $this->uploaderProvider = $uploaderProvider;
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

        if ($request->getAvatarPath() !== null) {
            $avatar = $this->uploaderProvider->upload($request->getAvatarPath());
            $participant->setAvatar($avatar);
        }

        $this->participantGateway->update($participant);

        $response = new UpdateProfileResponse($participant);

        $presenter->present($response);
    }
}
