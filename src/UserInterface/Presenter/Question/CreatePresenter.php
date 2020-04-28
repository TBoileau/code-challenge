<?php

namespace App\UserInterface\Presenter\Question;

use TBoileau\CodeChallenge\Domain\Quiz\Presenter\CreatePresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Response\CreateResponse;

/**
 * Class CreatePresenter
 * @package App\UserInterface\Presenter\Question
 */
class CreatePresenter implements CreatePresenterInterface
{
    /**
     * @inheritDoc
     */
    public function present(CreateResponse $response): void
    {

    }
}
