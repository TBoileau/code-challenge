<?php

namespace TBoileau\CodeChallenge\Domain\System\Presenter;

use TBoileau\CodeChallenge\Domain\System\Response\TrackResponse;

/**
 * Interface TrackPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\System\Presenter
 */
interface TrackPresenterInterface
{
    /**
     * @param TrackResponse $response
     */
    public function present(TrackResponse $response): void;
}
