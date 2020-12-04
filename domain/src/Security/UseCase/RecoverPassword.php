<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use Assert\AssertionFailedException;
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
     */
    public function execute(RecoverPasswordRequest $request, RecoverPasswordPresenterInterface $presenter)
    {
        $request->validate($this->gateway);

        $participant = $this->gateway->updatePassword($request->getEmail(), $request->getNewPlainPassword());

        $presenter->present(new RecoverPasswordResponse($participant));
    }
}
