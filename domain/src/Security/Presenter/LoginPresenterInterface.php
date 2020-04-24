<?php

namespace TBoileau\CodeChallenge\Domain\Security\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Response\LoginResponse;

/**
 * Interface LoginPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Security\Presenter
 */
interface LoginPresenterInterface
{

    /**
     * @param LoginResponse $response
     */
    public function present(LoginResponse $response): void;
}
