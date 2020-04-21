<?php

namespace TBoileau\CodeChallenge\Domain\Foo\Gateway;

use TBoileau\CodeChallenge\Domain\Foo\Entity\Item;

/**
 * Interface ItemGateway
 * @package TBoileau\CodeChallenge\Domain\Foo\Gateway
 */
interface ItemGateway
{
    /**
     * @param int $id
     * @return Item
     */
    public function find(int $id): Item;
}
