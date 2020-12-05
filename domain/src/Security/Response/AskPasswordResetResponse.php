<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class AskPasswordResetResponse
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class AskPasswordResetResponse
{
    /**
     * @var Participant|null
     */
    private ?Participant $participant;

    /**
     * AskPasswordResetResponse constructor.
     * @param Participant|null $participant
     */
    public function __construct(?Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * @return Participant
     */
    public function getParticipant(): Participant
    {
        return $this->participant;
    }
}
