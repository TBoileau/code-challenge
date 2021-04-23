<?php

declare(strict_types=1);

namespace App\UserInterface\ViewModel\Security;

class UpdateProfileViewModel
{

    private array $errorMessages = [];

    private ?string $avatar = null;

    public function addErrorMessage(string $errorMessage)
    {
        $this->errorMessages[] = $errorMessage;
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
