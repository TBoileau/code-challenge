<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\UseCase;

use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;
use TBoileau\CodeChallenge\Domain\Dashboard\Presenter\EditPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Request\EditPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

class EditPassword
{
    private ParticipantGateway $userGateway;

    public function __construct(ParticipantGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function execute(EditPasswordRequest $request, EditPasswordPresenterInterface $presenter)
    {
        $request->validate();
        $participant = $request->getParticipant();
        $password = password_hash($request->getPlainPassword(), PASSWORD_ARGON2I);
        $this->userGateway->updatePassword($participant, $password);
        $presenter->present(new EditPasswordResponse());
    }
}
