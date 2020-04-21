<?php

namespace TBoileau\CodeChallenge\Domain\Foo\Request;

/**
 * Class BarRequest
 * @package TBoileau\CodeChallenge\Domain\Foo\Request
 */
class BarRequest
{
    /**
     * @var int
     */
    private int $id;

    /**
     * BarRequest constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
