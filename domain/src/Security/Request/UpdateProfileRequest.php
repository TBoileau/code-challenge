<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use Assert\AssertionFailedException;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Uploader\Uploader;
use TBoileau\CodeChallenge\Domain\Security\Uploader\UploaderInterface;

class UpdateProfileRequest
{
    private UuidInterface $id;

    private string $email;

    private string $pseudo;

    private ?UploaderInterface $avatarPath = null;

    public function __construct(UuidInterface $id, string $email, string $pseudo, ?UploaderInterface $avatarPath = null)
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
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return UploaderInterface|null
     */
    public function getAvatarPath(): ?UploaderInterface
    {
        return $this->avatarPath;
    }

    /**
     * @throws AssertionFailedException
     */
    public function validate(ParticipantGateway $participantGateway, Participant $participant)
    {
        Assertion::notBlank($this->email, null, 'email');
        Assertion::email($this->email, null, 'email');

        if ($participant->getEmail() !== $this->getEmail()) {
            Assertion::nonUniqueEmail($this->email, $participantGateway);
        }

        if ($participant->getPseudo() !== $this->getPseudo()) {
            Assertion::nonUniquePseudo($this->pseudo, $participantGateway);
        }

        if (null !== $this->avatarPath) {
            Assertion::image($this->avatarPath->getPath());
        }

        Assertion::notBlank($this->pseudo, null, 'pseudo');
    }
}
