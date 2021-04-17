<?php

namespace TBoileau\CodeChallenge\Domain\Security\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\RecoverPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;

/**
 * Class Participant
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Entity
 */
class Participant
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $id;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $pseudo;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string|null
     */
    private ?string $avatar = null;

    /**
     * @var string|null
     */
    private ?string $passwordResetToken = null;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $passwordResetRequestedAt = null;

    /**
     * Participant constructor.
     * @param UuidInterface $id
     * @param string $email
     * @param string $pseudo
     * @param string $password
     * @param string|null $passwordResetToken
     * @param DateTimeInterface|null $passwordResetRequestedAt
     */
    public function __construct(
        UuidInterface $id,
        string $email,
        string $pseudo,
        string $password,
        ?string $passwordResetToken = null,
        ?DateTimeInterface $passwordResetRequestedAt = null,
        ?string $avatar = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->passwordResetToken = $passwordResetToken;
        $this->passwordResetRequestedAt = $passwordResetRequestedAt;
        $this->avatar = $avatar;
    }

    /**
     * @param RegistrationRequest $request
     * @return static
     * @throws Exception
     */
    public static function fromRegistration(RegistrationRequest $request): self
    {
        return new self(
            Uuid::uuid4(),
            $request->getEmail(),
            $request->getPseudo(),
            password_hash($request->getPlainPassword(), PASSWORD_ARGON2I)
        );
    }

    /**
     * @param Participant $participant
     * @param RecoverPasswordRequest $request
     */
    public static function resetPassword(self $participant, RecoverPasswordRequest $request): void
    {
        $password = password_hash($request->getNewPlainPassword(), PASSWORD_ARGON2I);

        if ($password) {
            $participant->password = $password;
        }

        $participant->passwordResetToken = null;
        $participant->passwordResetRequestedAt = null;
    }

    /**
     * @param Participant $participant
     * @param string $token
     */
    public static function requestPasswordReset(self $participant, string $token): void
    {
        $participant->passwordResetToken = $token;
        $participant->passwordResetRequestedAt = new DateTimeImmutable();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPasswordResetRequestedAt(): ?DateTimeInterface
    {
        return $this->passwordResetRequestedAt;
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
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
