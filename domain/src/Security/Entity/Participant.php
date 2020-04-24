<?php

namespace TBoileau\CodeChallenge\Domain\Security\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
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
     * @param  RegistrationRequest $request
     * @return static
     */
    public static function fromRegistration(RegistrationRequest $request): self
    {
        return new self($request->getEmail(), $request->getPseudo(), $request->getPlainPassword());
    }

    /**
     * User constructor.
     *
     * @param string $email
     * @param string $pseudo
     * @param string $plainPassword
     */
    public function __construct(string $email, string $pseudo, string $plainPassword)
    {
        $this->id = Uuid::uuid4();
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = password_hash($plainPassword, PASSWORD_ARGON2I);
    }

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
}
