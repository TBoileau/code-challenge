<?php

namespace App\UserInterface\ViewModel;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class RegistrationViewModel
 * @package App\UserInterface\ViewModel
 */
class RegistrationViewModel
{
    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * RegistrationViewModel constructor.
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
