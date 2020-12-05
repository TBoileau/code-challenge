<?php

namespace App\Infrastructure\Test\Adapter\Repository;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class UserRepository
 * @package App\Infrastructure\Test\Adapter\Repository
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
            password_hash("password", PASSWORD_ARGON2I),
            'bb4b5730-6057-4fa1-a27b-692b9ba8c14a',
            new DateTimeImmutable()
        );
    }

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

    /**
     * @inheritDoc
     */
    public function register(Participant $participant): void
    {
    }

    public function update(Participant $participant): void
    {
    }
}
