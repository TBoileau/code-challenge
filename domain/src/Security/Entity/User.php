<?php

namespace TBoileau\CodeChallenge\Domain\Security\Entity;

use Assert\Assert;
use Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;

/**
 * Class User
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Entity
 */
class User
{
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
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = password_hash($plainPassword, PASSWORD_ARGON2I);
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
