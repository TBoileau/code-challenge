<?php

namespace TBoileau\CodeChallenge\Domain\Security\Assert;

use Assert\Assertion as BaseAssertion;
use TBoileau\CodeChallenge\Domain\Security\Exception\NonUniqueEmailException;
use TBoileau\CodeChallenge\Domain\Security\Exception\NonValidAvatarException;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class Assertion
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Assert
 */
class Assertion extends BaseAssertion
{
    public const EXISTING_EMAIL = 500;
    public const EXISTING_PSEUDO = 501;
    public const EXISTING_AVATAR = 502;

    /**
     * @param string      $pseudo
     * @param ParticipantGateway $participantGateway
     */
    public static function nonUniquePseudo(string $pseudo, ParticipantGateway $participantGateway): void
    {
        if (!$participantGateway->isPseudoUnique($pseudo)) {
            throw new NonUniqueEmailException("This email should be unique !", self::EXISTING_PSEUDO);
        }
    }

    /**
     * @param string      $email
     * @param ParticipantGateway $participantGateway
     */
    public static function nonUniqueEmail(string $email, ParticipantGateway $participantGateway): void
    {
        if (!$participantGateway->isEmailUnique($email)) {
            throw new NonUniqueEmailException("This email should be unique !", self::EXISTING_EMAIL);
        }
    }

    /**
     * @param string $avatarPath
     */
    public static function nonValidAvatar(string $avatarPath): void
    {
        $extension = pathinfo($avatarPath, PATHINFO_EXTENSION);
        if (!in_array($extension, ['jpg', 'png', 'jpeg'])) {
            throw new NonValidAvatarException('This avatar extension is not valid.', self::EXISTING_AVATAR);
        }
    }
}
