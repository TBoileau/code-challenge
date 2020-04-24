<?php

namespace App\UserInterface\Controller;

use App\UserInterface\Form\RegistrationType;
use App\UserInterface\Presenter\RegistrationPresenter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
     * RegistrationController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
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
            $request = RegistrationRequest::create(
                $form->getData()->getEmail(),
                $form->getData()->getPseudo(),
                $form->getData()->getPlainPassword()
            );
            $registration->execute($request, $presenter);

            return new RedirectResponse($this->urlGenerator->generate("home"));
        }

        return new Response($this->twig->render("registration.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
