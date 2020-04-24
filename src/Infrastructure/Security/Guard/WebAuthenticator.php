<?php

namespace App\Infrastructure\Security\Guard;

use App\Infrastructure\Security\User;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use TBoileau\CodeChallenge\Domain\Security\Presenter\LoginPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\LoginRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\LoginResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\Login;

/**
 * Class WebAuthenticator
 * @package App\Infrastructure\Security\Guard
 */
class WebAuthenticator extends AbstractFormLoginAuthenticator implements LoginPresenterInterface
{
    /**
     * @var Login
     */
    private Login $login;

    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * @var LoginResponse
     */
    private LoginResponse $response;

    /**
     * WebAuthenticator constructor.
     * @param Login $login
     * @param FlashBagInterface $flashBag
     */
    public function __construct(Login $login, FlashBagInterface $flashBag)
    {
        $this->login = $login;
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl()
    {
        return "/login";
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        return $this->getLoginUrl() === $request->getPathInfo() && $request->isMethod(Request::METHOD_POST);
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        return new LoginRequest(
            $request->get("username", ""),
            $request->get("password", "")
        );
    }

    /**
     * @param LoginRequest $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|void|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $this->login->execute($credentials, $this);
        } catch (AssertionFailedException $exception) {
            throw new AuthenticationException($exception->getMessage());
        }

        if ($this->response->getParticipant() === null) {
            throw new UsernameNotFoundException('User not found !');
        }

        return new User($this->response->getParticipant());
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$this->response->isPasswordValid()) {
            throw new AuthenticationException('Wrong credentials !');
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $this->flashBag->add("success", 'Bon retour sur Code Challenge !');
        return new RedirectResponse("/");
    }

    /**
     * @inheritDoc
     */
    public function present(LoginResponse $response): void
    {
        $this->response = $response;
    }
}
