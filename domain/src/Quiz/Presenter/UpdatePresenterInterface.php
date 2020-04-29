<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Presenter;

use TBoileau\CodeChallenge\Domain\Quiz\Response\UpdateResponse;

/**
 * Interface UpdatePresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Quiz\Presenter
 */
interface UpdatePresenterInterface
{
    /**
     * @param UpdateResponse $response
     */
    public function present(UpdateResponse $response): void;
}
