<?php

namespace App\UserInterface\ViewModel;

use App\Infrastructure\Security\User;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class RegistrationViewModel
 * @package App\UserInterface\ViewModel
 */
class RegistrationViewModel
{
    /**
     * @var Participant
     */
    private Participant $participant;

    /**
     * RegistrationViewModel constructor.
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
