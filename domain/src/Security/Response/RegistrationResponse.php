<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

use TBoileau\CodeChallenge\Domain\Security\Entity\User;

/**
 * Class RegistrationResponse
 *
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class RegistrationResponse
{
    /**
     * @var User
     */
    private User $user;

    /**
     * RegistrationResponse constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
