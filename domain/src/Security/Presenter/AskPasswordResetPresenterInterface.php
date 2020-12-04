<?php

namespace TBoileau\CodeChallenge\Domain\Security\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Response\AskPasswordResetResponse;

/**
 * Interface AskPasswordResetPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Security\Presenter
 */
interface AskPasswordResetPresenterInterface
{
    /**
     * @param AskPasswordResetResponse $response
     */
    public function present(AskPasswordResetResponse $response): void;
}
