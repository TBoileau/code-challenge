<?php

namespace App\UserInterface\DataTransferObject;

/**
 * Class ResetPasswordData
 * @package App\UserInterface\DataTransferObject
 */
class ResetPasswordData
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
