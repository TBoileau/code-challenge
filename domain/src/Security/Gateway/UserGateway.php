<?php

namespace TBoileau\CodeChallenge\Domain\Security\Gateway;

/**
 * Interface UserGateway
 * @package TBoileau\CodeChallenge\Domain\Security\Gateway
 */
interface UserGateway
{
    /**
     * @param string $email
     * @return bool
     */
    public function isEmailUnique(string $email): bool;

    /**
     * @param string $pseudo
     * @return bool
     */
    public function isPseudoUnique(string $pseudo): bool;
}
