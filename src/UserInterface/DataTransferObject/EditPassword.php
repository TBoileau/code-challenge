<?php

namespace App\UserInterface\DataTransferObject;

/**
 * Class EditPassword
 * @package App\UserInterface\DataTransferObject
 */
class EditPassword
{
    /**
     * @var string|null
     */
    private ?string $plainPassword = null;

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return self
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
