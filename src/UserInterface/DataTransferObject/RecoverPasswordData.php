<?php

namespace App\UserInterface\DataTransferObject;

/**
 * Class ResetPasswordData
 * @package App\UserInterface\DataTransferObject
 */
class RecoverPasswordData
{
    /**
     * @var string
     */
    private string $newPlainPassword;

    /**
     * @return string
     */
    public function getNewPlainPassword(): string
    {
        return $this->newPlainPassword;
    }

    /**
     * @param string $newPlainPassword
     */
    public function setNewPlainPassword(string $newPlainPassword): void
    {
        $this->newPlainPassword = $newPlainPassword;
    }
}
