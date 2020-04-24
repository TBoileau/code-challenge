<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class RegistrationResponse
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class RegistrationResponse
{
    /**
     * @var Participant
     */
    private Participant $participant;

    /**
     * RegistrationResponse constructor.
     *
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
