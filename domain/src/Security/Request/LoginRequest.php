<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;

/**
 * Class LoginRequest
 * @package TBoileau\CodeChallenge\Domain\Security\Request
 */
class LoginRequest
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @param string $email
     * @param string $password
     * @return static
     */
    public static function create(string $email, string $password): self
    {
        return new self($email, $password);
    }

    /**
     * LoginRequest constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    public function validate(): void
    {
        Assertion::notBlank($this->email, "Email should not be blank.");
        Assertion::notBlank($this->password, "Password should not be blank.");
    }
}
