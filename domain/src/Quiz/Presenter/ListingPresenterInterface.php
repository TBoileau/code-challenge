<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Presenter;

use TBoileau\CodeChallenge\Domain\Quiz\Response\ListingResponse;

/**
 * Interface ListingPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Quiz\Presenter
 */
interface ListingPresenterInterface
{
    /**
     * @param ListingResponse $response
     */
    public function present(ListingResponse $response): void;
}
