<?php

namespace App\UserInterface\ViewModel;

use TBoileau\CodeChallenge\Domain\Foo\Entity\Item;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarResponse;

/**
 * Class ItemViewModel
 * @package App\UserInterface\ViewModel
 */
class ItemViewModel
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
     * @param Item $item
     * @return static
     */
    public static function fromItem(Item $item): self
    {
        return new self($item->getId(), $item->getName());
    }

    /**
     * ItemViewModel constructor.
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
