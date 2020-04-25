<?php

namespace App\UserInterface\Controller;

use App\Infrastructure\Security\Guard\WebAuthenticator;
use App\UserInterface\Form\RegistrationType;
use App\UserInterface\Presenter\RegistrationPresenter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use TBoileau\CodeChallenge\Domain\Security\Request\RegistrationRequest;
use TBoileau\CodeChallenge\Domain\Security\UseCase\Registration;
use Twig\Environment;

/**
 * Class RegistrationController
 * @package App\UserInterface\Controller
 */
class RegistrationController
{
    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var GuardAuthenticatorHandler
     */
    private GuardAuthenticatorHandler $guardHandler;

    /**
     * @var WebAuthenticator
     */
    private WebAuthenticator $authenticator;

    /**
     * RegistrationController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     * @param GuardAuthenticatorHandler $guardHandler
     * @param WebAuthenticator $authenticator
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator,
        GuardAuthenticatorHandler $guardHandler,
        WebAuthenticator $authenticator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->guardHandler = $guardHandler;
        $this->authenticator = $authenticator;
    }

    /**
     * @param Request $request
     * @param Registration $registration
     * @param RegistrationPresenter $presenter
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request, Registration $registration, RegistrationPresenter $presenter): Response
    {
        $form = $this->formFactory->create(RegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registrationRequest = RegistrationRequest::create(
                $form->getData()->getEmail(),
                $form->getData()->getPseudo(),
                $form->getData()->getPlainPassword()
            );
            $registration->execute($registrationRequest, $presenter);

            return $this->guardHandler->authenticateUserAndHandleSuccess(
                $presenter->getViewModel()->getUser(),
                $request,
                $this->authenticator,
                'main'
            );
        }

        return new Response($this->twig->render("registration.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
