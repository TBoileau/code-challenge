<?php

namespace App\Infrastructure\Doctrine\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class DoctrineParticipant
 * @package App\Infrastructure\Doctrine\Entity
 * @ORM\Entity(repositoryClass="App\Infrastructure\Adapter\Repository\ParticipantRepository")
 */
class DoctrineParticipant
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    private string $email;

    /**
     * @var string
     * @ORM\Column
     */
    private string $password;

    /**
     * @var string
     * @ORM\Column(unique=true)
     */
    private string $pseudo;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $passwordResetToken = null;

    /**
     * @var DateTimeInterface|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $passwordResetRequestedAt = null;

    /**
     * @var string|null
     * @ORM\Column
     */
    private ?string $avatar = null;

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface $id
     */
    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
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
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * @param string|null $passwordResetToken
     */
    public function setPasswordResetToken(?string $passwordResetToken): void
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPasswordResetRequestedAt(): ?DateTimeInterface
    {
        return $this->passwordResetRequestedAt;
    }

    /**
     * @param DateTimeInterface|null $passwordResetRequestedAt
     */
    public function setPasswordResetRequestedAt(?DateTimeInterface $passwordResetRequestedAt): void
    {
        $this->passwordResetRequestedAt = $passwordResetRequestedAt;
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
