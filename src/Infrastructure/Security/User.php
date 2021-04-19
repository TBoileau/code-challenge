<?php

namespace App\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class User
 * @package App\Infrastructure\Security
 */
class User implements UserInterface
{
    /**
     * @var Participant
     */
    private Participant $participant;

    /**
     * User constructor.
     * @param Participant $participant
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->participant->getPassword();
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->participant->getEmail();
    }

    public function getAvatar(): ?string
    {
        return $this->participant->getAvatar();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return Participant
     */
    public function getParticipant(): Participant
    {
        return $this->participant;
    }
}
