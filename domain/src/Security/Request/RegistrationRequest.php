<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use Assert\AssertionFailedException;
use Assert\InvalidArgumentException;
use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Exception\NonUniqueEmailException;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class RegistrationRequest
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Request
 */
class RegistrationRequest
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
    private string $plainPassword;

    /**
     * @param  string $email
     * @param  string $pseudo
     * @param  string $plainPassword
     * @return static
     */
    public static function create(string $email, string $pseudo, string $plainPassword): self
    {
        return new self($email, $pseudo, $plainPassword);
    }

    /**
     * RegistrationRequest constructor.
     *
     * @param string $email
     * @param string $pseudo
     * @param string $plainPassword
     */
    public function __construct(string $email, string $pseudo, string $plainPassword)
    {
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->plainPassword = $plainPassword;
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
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param  ParticipantGateway $participantGateway
     * @throws AssertionFailedException
     */
    public function validate(ParticipantGateway $participantGateway): void
    {
        Assertion::notBlank($this->email);
        Assertion::email($this->email);
        Assertion::nonUniqueEmail($this->email, $participantGateway);
        Assertion::notBlank($this->pseudo);
        Assertion::nonUniquePseudo($this->pseudo, $participantGateway);
        Assertion::notBlank($this->plainPassword);
        Assertion::minLength($this->plainPassword, 8);
    }
}
