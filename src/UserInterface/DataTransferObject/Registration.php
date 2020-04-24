<?php

namespace App\UserInterface\DataTransferObject;

/**
 * Class Registration
 * @package App\UserInterface\DataTransferObject
 */
class Registration
{
    /**
     * @var string|null
     */
    private ?string $email = null;

    /**
     * @var string|null
     */
    private ?string $pseudo = null;

    /**
     * @var string|null
     */
    private ?string $plainPassword = null;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param string|null $pseudo
     */
    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
