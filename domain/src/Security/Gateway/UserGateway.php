<?php

namespace TBoileau\CodeChallenge\Domain\Security\Gateway;

/**
 * Interface UserGateway
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Gateway
 */
interface UserGateway
{
    /**
     * @param  string|null $email
     * @return bool
     */
    public function isEmailUnique(?string $email): bool;

    /**
     * @param  string|null $pseudo
     * @return bool
     */
    public function isPseudoUnique(?string $pseudo): bool;
}
