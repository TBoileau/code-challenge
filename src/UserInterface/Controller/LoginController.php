<?php

namespace App\UserInterface\Controller;

use App\UserInterface\ViewModel\LoginViewModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

/**
 * Class LoginController
 * @package App\UserInterface\Controller
 */
class LoginController
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * LoginController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        return new Response($this->twig->render("login.html.twig", [
            "vm" => LoginViewModel::fromAuthenticationUtils($authenticationUtils)
        ]));
    }
}
