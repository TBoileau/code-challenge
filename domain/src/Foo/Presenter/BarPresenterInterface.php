<?php

namespace TBoileau\CodeChallenge\Domain\Foo\Presenter;

use TBoileau\CodeChallenge\Domain\Foo\Response\BarResponse;

/**
 * Interface BarPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Foo\Presenter
 */
interface BarPresenterInterface
{
    /**
     * @param BarResponse $response
     */
    public function present(BarResponse $response): void;
}
