<?php

namespace App\UserInterface\Controller;

use App\UserInterface\Form\RegistrationType;
use App\UserInterface\Presenter\RegistrationPresenter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * RegistrationController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param FlashBagInterface $flashBag
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        FlashBagInterface $flashBag,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param Registration $registration
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request, Registration $registration): Response
    {
        $form = $this->formFactory->create(RegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request = RegistrationRequest::create(
                $form->getData()->getEmail(),
                $form->getData()->getPseudo(),
                $form->getData()->getPlainPassword()
            );
            $presenter = new RegistrationPresenter();
            $registration->execute($request, $presenter);

            $this->flashBag->add(
                "success",
                "Bienvenue sur Code Challenge ! Votre inscription a été effectuée avec succès !"
            );

            return new RedirectResponse($this->urlGenerator->generate("home"));
        }

        return new Response($this->twig->render("registration.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
