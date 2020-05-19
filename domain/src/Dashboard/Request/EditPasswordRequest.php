<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\Request;

use Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

class EditPasswordRequest
{
    private Participant $participant;
    
    private string $plainPassword;

    public static function create(Participant $participant, string $plainPassword): self
    {
        return new self($participant, $plainPassword);
    }

    public function __construct(Participant $participant, string $plainPassword)
    {
        $this->participant = $participant;
        $this->plainPassword = $plainPassword;
    }

    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    public function getPlainPassword(): string
    {
        return  $this->plainPassword;
    }

    public function validate(): void
    {
        Assertion::notBlank($this->plainPassword);
        Assertion::minLength($this->plainPassword, 8);
    }
}
