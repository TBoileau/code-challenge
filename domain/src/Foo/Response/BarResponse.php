<?php

namespace TBoileau\CodeChallenge\Domain\Foo\Response;

use TBoileau\CodeChallenge\Domain\Foo\Entity\Item;

/**
 * Class BarResponse
 * @package TBoileau\CodeChallenge\Domain\Foo\Response
 */
class BarResponse
{
    /**
     * @var Item
     */
    private Item $item;

    /**
     * BarResponse constructor.
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }
}
