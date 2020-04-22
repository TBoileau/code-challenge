<?php

namespace TBoileau\CodeChallenge\Domain\Security\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;

/**
 *
 * Interface RegistrationPresenterInterface
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Presenter
 */
interface RegistrationPresenterInterface
{
    /**
     * @param RegistrationResponse $response
     */
    public function present(RegistrationResponse $response): void;
}
