<?php

namespace TBoileau\CodeChallenge\Domain\Security\Request;

use Assert\AssertionFailedException;
use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class AskPasswordResetRequest
 * @package TBoileau\CodeChallenge\Domain\Security\Request
 */
class AskPasswordResetRequest
{
    /**
     * @var string
     */
    private string $email;

    /**
     * AskPasswordResetRequest constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function create(string $email): self
    {
        return new self($email);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
    }
}
