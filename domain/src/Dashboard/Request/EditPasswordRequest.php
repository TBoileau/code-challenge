<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\Request;

use Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class EditPasswordRequest
 * @package TBoileau\CodeChallenge\Domain\Dashboard\Request
 */
class EditPasswordRequest
{
    /**
     * @var Participant
     */
    private Participant $participant;
    
    /**
     * @var string
     */
    private string $plainPassword;

    /**
     * @param Participant $participant
     * @param string $plainPassword
     * @return self
     */
    public static function create(Participant $participant, string $plainPassword): self
    {
        return new self($participant, $plainPassword);
    }

    /**
     * @param Participant $participant
     * @param string $plainPassword
     */
    public function __construct(Participant $participant, string $plainPassword)
    {
        $this->participant = $participant;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return Participant
     */
    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return  $this->plainPassword;
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        Assertion::notBlank($this->plainPassword);
        Assertion::minLength($this->plainPassword, 8);
    }
}
