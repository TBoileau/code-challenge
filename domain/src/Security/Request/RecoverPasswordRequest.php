<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use Assert\AssertionFailedException;
use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class RecoverPasswordRequest
 * @package TBoileau\CodeChallenge\Domain\Security\Request
 */
class RecoverPasswordRequest
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $newPlainPassword;

    /**
     * RecoverPasswordRequest constructor.
     * @param string $email
     * @param string $newPlainPassword
     */
    public function __construct(string $email, string $newPlainPassword)
    {
        $this->email = $email;
        $this->newPlainPassword = $newPlainPassword;
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
    public function getNewPlainPassword(): string
    {
        return $this->newPlainPassword;
    }

    /**
     * @param  ParticipantGateway $gateway
     * @throws AssertionFailedException
     */
    public function validate(ParticipantGateway $gateway): void
    {
        Assertion::notBlank($this->email);
        Assertion::email($this->email);
        Assertion::notNull($gateway->getParticipantByEmail($this->email));
        Assertion::notBlank($this->newPlainPassword);
        Assertion::minLength($this->newPlainPassword, 8);
    }
}
