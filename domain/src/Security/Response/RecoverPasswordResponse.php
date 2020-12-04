<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class RecoverPasswordResponse
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class RecoverPasswordResponse
{
    /**
     * @var Participant
     */
    private Participant $participant;

    /**
     * RecoverPasswordResponse constructor.
     * @param Participant $participant
     */
    public function __construct(Participant $participant)
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
