<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

class UpdateProfileRequest
{

    private int $id;

    private string $email;

    private string $pseudo;

    private ?string $avatarPath = null;

    public function __construct(int $id, string $email, string $pseudo, ?string $avatarPath = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->avatarPath = $avatarPath;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function validate(ParticipantGateway $participantGateway, Participant $participant)
    {
        Assertion::notBlank($this->email);
        Assertion::email($this->email);

        if ($participant->getEmail() !== $this->getEmail()) {
            Assertion::nonUniqueEmail($this->email, $participantGateway);
        }

        if ($participant->getPseudo() !== $this->getPseudo()) {
            Assertion::nonUniquePseudo($this->pseudo, $participantGateway);
        }

        if (null !== $this->avatarPath) {
            Assertion::file($this->avatarPath);
            Assertion::nonValidAvatar($this->avatarPath);
        }

        Assertion::notBlank($this->pseudo);
    }
}
