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
        return new self(
            Uuid::uuid4(),
            $request->getEmail(),
            $request->getPseudo(),
            password_hash($request->getPlainPassword(), PASSWORD_ARGON2I)
        );
    }

    /**
     * User constructor.
     *
     * @param UuidInterface $id
     * @param string $email
     * @param string $pseudo
     * @param string $password
     */
    public function __construct(UuidInterface $id, string $email, string $pseudo, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = $password;
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
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
