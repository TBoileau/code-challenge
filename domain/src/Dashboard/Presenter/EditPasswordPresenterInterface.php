<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\Presenter;

use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;

/**
 * Interface EditPasswordPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Dashboard\Presenter
 */
interface EditPasswordPresenterInterface
{
    /**
     * @param EditPasswordResponse $response
     * @return void
     */
    public function present(EditPasswordResponse $response): void;
}
