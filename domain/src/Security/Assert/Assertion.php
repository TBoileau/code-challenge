<?php

namespace TBoileau\CodeChallenge\Domain\Security\Assert;

use Assert\Assertion as BaseAssertion;
use TBoileau\CodeChallenge\Domain\Security\Exception\NonUniqueEmailException;
use TBoileau\CodeChallenge\Domain\Security\Gateway\UserGateway;

/**
 * Class Assertion
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Assert
 */
class Assertion extends BaseAssertion
{
    public const EXISTING_EMAIL = 500;
    public const EXISTING_PSEUDO = 501;

    /**
     * @param string      $pseudo
     * @param UserGateway $userGateway
     */
    public static function nonUniquePseudo(string $pseudo, UserGateway $userGateway): void
    {
        if (!$userGateway->isPseudoUnique($pseudo)) {
            throw new NonUniqueEmailException("This email should be unique !", self::EXISTING_PSEUDO);
        }
    }

    /**
     * @param string      $email
     * @param UserGateway $userGateway
     */
    public static function nonUniqueEmail(string $email, UserGateway $userGateway): void
    {
        if (!$userGateway->isEmailUnique($email)) {
            throw new NonUniqueEmailException("This email should be unique !", self::EXISTING_EMAIL);
        }
    }
}
