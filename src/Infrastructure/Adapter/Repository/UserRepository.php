<?php

namespace App\Infrastructure\Adapter\Repository;

use TBoileau\CodeChallenge\Domain\Security\Gateway\UserGateway;

/**
 * Class UserRepository
 * @package App\Infrastructure\Adapter\Repository
 */
class UserRepository implements UserGateway
{
    /**
     * @inheritDoc
     */
    public function isEmailUnique(?string $email): bool
    {
        return !in_array($email, ["used@email.com"]);
    }

    /**
     * @inheritDoc
     */
    public function isPseudoUnique(?string $pseudo): bool
    {
        return !in_array($pseudo, ["used_pseudo"]);
    }
}
