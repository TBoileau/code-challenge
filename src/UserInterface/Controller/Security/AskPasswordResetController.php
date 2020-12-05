<?php

namespace App\UserInterface\Controller\Security;

use App\UserInterface\DataTransferObject\ResetPasswordData;
use App\UserInterface\Form\ResetPasswordType;
use App\UserInterface\Presenter\Security\AskPasswordResetPresenter;
use Assert\AssertionFailedException;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\AskPasswordResetRequest;
use TBoileau\CodeChallenge\Domain\Security\UseCase\AskPasswordReset;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AskPasswordResetController
 * @package App\UserInterface\Controller\Security
 */
class AskPasswordResetController
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
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * AskPasswordResetController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        FlashBagInterface $flashBag,
        RouterInterface $router
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param AskPasswordReset $useCase
     * @param AskPasswordResetPresenter $presenter
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(
        Request $request,
        AskPasswordReset $useCase,
        AskPasswordResetPresenter $presenter
    ): Response {
        $form = $this->formFactory
            ->create(ResetPasswordType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $askPasswordResetRequest = AskPasswordResetRequest::create($form->getData()->getEmail());

            try {
                $useCase->execute($askPasswordResetRequest, $presenter);
            } catch (AssertionFailedException $e) {
                $this->flashBag->add(
                    "danger",
                    "Veuillez renseigner une adresse mail valide svp !"
                );
            } catch (Exception $e) {
                $this->flashBag->add(
                    "danger",
                    "Ooupps ! Une erreur s'est produite ! Veuillez réessayer plus tard !"
                );
            }

            return new RedirectResponse($this->router->generate('login'));
        }
        return new Response($this->twig->render("security/reset_password.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
