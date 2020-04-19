<?php

namespace TBoileau\CodeChallenge\Domain\Foo\UseCase;

/**
 * Interface BarPresenterInterface
 * @package TBoileau\CodeChallenge\Domain\Foo\UseCase
 */
interface BarPresenterInterface
{
    /**
     * @param BarResponse $response
     */
    public function present(BarResponse $response): void;
}
