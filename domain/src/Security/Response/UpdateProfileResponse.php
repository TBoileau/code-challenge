<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

class UpdateProfileResponse
{

    private Participant $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function getParticipant(): Participant
    {
        return $this->participant;
    }
}
