<?php

namespace App\UserInterface\ViewModel;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginViewModel
 * @package App\UserInterface\ViewModel
 */
class LoginViewModel
{
    /**
     * @var string
     */
    private string $lastUsername;

    /**
     * @var string|null
     */
    private ?string $errorMessage;

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return static
     */
    public static function fromAuthenticationUtils(AuthenticationUtils $authenticationUtils): self
    {
        return new self(
            $authenticationUtils->getLastUsername(),
            $authenticationUtils->getLastAuthenticationError()
        );
    }

    /**
     * LoginViewModel constructor.
     * @param string $lastUsername
     * @param AuthenticationException|null $exception
     */
    public function __construct(string $lastUsername, ?AuthenticationException $exception)
    {
        $this->lastUsername = $lastUsername;
        $this->errorMessage = $exception !== null ? $exception->getMessage() : null;
    }

    /**
     * @return string
     */
    public function getLastUsername(): string
    {
        return $this->lastUsername;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
