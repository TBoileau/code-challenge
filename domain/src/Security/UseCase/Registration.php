<?php

namespace TBoileau\CodeChallenge\Domain\Security\UseCase;

use TBoileau\CodeChallenge\Domain\Security\Entity\User;
use TBoileau\CodeChallenge\Domain\Security\Gateway\UserGateway;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RegistrationPresenterInterface;

/**
 * Class Registration
 * @package TBoileau\CodeChallenge\Domain\Security\UseCase
 */
class Registration
{
    /**
     * @var UserGateway
     */
    private UserGateway $userGateway;

    /**
     * Registration constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @param RegistrationRequest $request
     * @param RegistrationPresenterInterface $presenter
     */
    public function execute(RegistrationRequest $request, RegistrationPresenterInterface $presenter)
    {
        $request->validate($this->userGateway);
        $user = User::fromRegistration($request);
        $presenter->present(new RegistrationResponse($user));
    }
}
