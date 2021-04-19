<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

class UpdateProfileResponse
{

    private Participant $participant;

    private array $errors = [];

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    public function addError(string $message, string $propertyName = null)
    {
        $this->errors[$propertyName] = $message;
    }

    public function hasErrors(): bool
    {
        return \count($this->errors) > 0;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
