<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter;

use Ramsey\Uuid\Uuid;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class ParticipantRepository
 * @package TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter
 */
class ParticipantRepository implements ParticipantGateway
{
    /**
     * @inheritDoc
     */
    public function getParticipantByEmail(string $email): ?Participant
    {
        if ($email !== "used@email.com") {
            return null;
        }

        return new Participant(
            Uuid::uuid4(),
            "used@email.com",
            "pseudo",
            password_hash("password", PASSWORD_ARGON2I)
        );
    }

    /**
     * @param string|null $email
     * @return bool
     */
    public function isEmailUnique(?string $email): bool
    {
        return !in_array($email, ["used@email.com"]);
    }

    /**
     * @param string|null $pseudo
     * @return bool
     */
    public function isPseudoUnique(?string $pseudo): bool
    {
        return !in_array($pseudo, ["used_pseudo"]);
    }

    /**
     * @param Participant $participant
     */
    public function register(Participant $participant): void
    {
    }
}
