<?php

namespace TBoileau\CodeChallenge\Domain\Security\Gateway;

use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Interface UserGateway
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Gateway
 */
interface ParticipantGateway
{
    /**
     * @param string $email
     * @return Participant|null
     */
    public function getParticipantByEmail(string $email): ?Participant;

    /**
     * @param string $id
     * @return Participant|null
     */
    public function getParticipantById(string $id): ?Participant;

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

    /**
     * @param Participant $participant
     */
    public function register(Participant $participant): void;

    /**
     * @param Participant $participant
     */
    public function update(Participant $participant): void;
}
