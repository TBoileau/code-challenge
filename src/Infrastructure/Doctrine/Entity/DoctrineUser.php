<?php

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class DoctrineUser
 * @package App\Infrastructure\Doctrine\Entity
 * @ORM\Entity(repositoryClass="App\Infrastructure\Adapter\Repository\UserRepository")
 */
class DoctrineUser
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column
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
}
