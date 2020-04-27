<?php

namespace App\UserInterface\Presenter;

use TBoileau\CodeChallenge\Domain\System\Presenter\TrackPresenterInterface;
use TBoileau\CodeChallenge\Domain\System\Response\TrackResponse;

/**
 * Class TrackPresenter
 * @package App\UserInterface\Presenter
 */
class TrackPresenter implements TrackPresenterInterface
{
    /**
     * @inheritDoc
     */
    public function present(TrackResponse $response): void
    {
    }
}
