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

    public function __construct(int $id, string $email, string $pseudo)
    {
        $this->id = $id;
        $this->email = $email;
        $this->pseudo = $pseudo;
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
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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

        Assertion::notBlank($this->pseudo);
    }
}
