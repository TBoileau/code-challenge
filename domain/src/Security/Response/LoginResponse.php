<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class LoginResponse
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class LoginResponse
{
    /**
     * @var null|Participant
     */
    private ?Participant $participant;

    /**
     * @var bool
     */
    private bool $passwordValid;

    /**
     * LoginResponse constructor.
     * @param null|Participant $participant
     * @param bool $passwordValid
     */
    public function __construct(?Participant $participant, bool $passwordValid)
    {
        $this->participant = $participant;
        $this->passwordValid = $passwordValid;
    }

    /**
     * @return Participant|null
     */
    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    /**
     * @return bool
     */
    public function isPasswordValid(): bool
    {
        return $this->passwordValid;
    }
}
