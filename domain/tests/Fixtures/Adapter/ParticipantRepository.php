<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter;

use DateTimeImmutable;
use Exception;
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

        $participant = new Participant(
            Uuid::uuid4(),
            "used@email.com",
            "pseudo",
            password_hash("password", PASSWORD_ARGON2I),
            'bb4b5730-6057-4fa1-a27b-692b9ba8c14a',
            new DateTimeImmutable()
        );

        return $participant;
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

    /**
     * @param Participant $participant
     */
    public function update(Participant $participant): void
    {
    }
}
