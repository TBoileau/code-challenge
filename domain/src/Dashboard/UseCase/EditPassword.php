<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\UseCase;

use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;
use TBoileau\CodeChallenge\Domain\Dashboard\Presenter\EditPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Request\EditPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class EditPassword
 * @package TBoileau\CodeChallenge\Domain\Dashboard\UseCase
 */
class EditPassword
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $userGateway;

    /**
     * @param ParticipantGateway $userGateway
     */
    public function __construct(ParticipantGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @param EditPasswordRequest $request
     * @param EditPasswordPresenterInterface $presenter
     * @return void
     */
    public function execute(EditPasswordRequest $request, EditPasswordPresenterInterface $presenter)
    {
        $request->validate();
        $participant = $request->getParticipant();
        $password = password_hash($request->getPlainPassword(), PASSWORD_ARGON2I);
        $this->userGateway->updatePassword($participant, $password);
        $presenter->present(new EditPasswordResponse());
    }
}
