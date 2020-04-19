<?php

namespace TBoileau\CodeChallenge\Domain\Foo\Entity;

/**
 * Class Item
 * @package TBoileau\CodeChallenge\Domain\Foo\Entity
 */
class Item
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * Item constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
