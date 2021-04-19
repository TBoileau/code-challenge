<?php

namespace App\UserInterface\DataTransferObject;

use App\Infrastructure\Validator\NonValidExtension;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant as ParticipantDomain;

class Participant
{

    private ?UuidInterface $id = null;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @var string|null
     */
    private ?string $email = null;

    /**
     * @Assert\NotBlank
     * @var string|null
     */
    private ?string $pseudo = null;

    /**
     * @NonValidExtension()
     * @var string|null
     */
    private ?string $avatarPath = null;

    public static function fromDomainEntity(ParticipantDomain $participantDomain): self
    {
        $participant = new self();
        $participant->setId($participantDomain->getId());
        $participant->setEmail($participantDomain->getEmail());
        $participant->setPseudo($participantDomain->getPseudo());
        $participant->setAvatarPath($participantDomain->getAvatar());

        return $participant;
    }

    /**
     * @return UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param string|null $pseudo
     */
    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string|null
     */
    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

    /**
     * @param string|null $avatarPath
     */
    public function setAvatarPath(?string $avatarPath): void
    {
        $this->avatarPath = $avatarPath;
    }

    /**
     * @param UuidInterface|null $id
     */
    public function setId(?UuidInterface $id): void
    {
        $this->id = $id;
    }
}
