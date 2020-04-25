<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class RegistrationResponse
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class RegistrationResponse
{
    /**
     * @var string
     */
    private string $email;

    /**
     * RegistrationResponse constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
