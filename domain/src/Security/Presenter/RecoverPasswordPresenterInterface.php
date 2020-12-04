<?php

namespace TBoileau\CodeChallenge\Domain\Security\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Response\RecoverPasswordResponse;

/**
 * Interface RecoverPasswordPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Security\Presenter
 */
interface RecoverPasswordPresenterInterface
{
    /**
     * @param RecoverPasswordResponse $response
     */
    public function present(RecoverPasswordResponse $response): void;
}
