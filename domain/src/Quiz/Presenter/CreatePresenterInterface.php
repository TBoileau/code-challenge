<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Presenter;

use TBoileau\CodeChallenge\Domain\Quiz\Response\CreateResponse;

/**
 * Interface CreatePresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Quiz\Presenter
 */
interface CreatePresenterInterface
{
    /**
     * @param CreateResponse $response
     */
    public function present(CreateResponse $response): void;
}
