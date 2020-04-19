<?php

namespace App\Infrastructure\Test\Adapter\Repository;

use TBoileau\CodeChallenge\Domain\Foo\Entity\Item;
use TBoileau\CodeChallenge\Domain\Foo\Gateway\ItemGateway;

/**
 * Class ItemRepository
 * @package App\Infrastructure\Test\Adapter\Repository
 */
class ItemRepository implements ItemGateway
{
    /**
     * @inheritDoc
     */
    public function find(int $id): Item
    {
        return new Item($id, "name");
    }
}
