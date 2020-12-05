<?php

namespace App\UserInterface\Controller\Security;

use App\UserInterface\Form\RecoverPasswordType;
use App\UserInterface\Presenter\Security\RecoverPasswordPresenter;
use Assert\AssertionFailedException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use TBoileau\CodeChallenge\Domain\Security\Exception\PasswordRecoveryInvalidTokenException;
use TBoileau\CodeChallenge\Domain\Security\Request\RecoverPasswordRequest;
use TBoileau\CodeChallenge\Domain\Security\UseCase\RecoverPassword;
use Twig\Environment;

class RecoverPasswordController
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
     * RecoverPasswordController constructor.
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

    public function __invoke(Request $request, RecoverPassword $useCase, RecoverPasswordPresenter $presenter): Response
    {
        $form = $this->formFactory
            ->create(RecoverPasswordType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $request->attributes->get('token');
            $email = $request->attributes->get('email');
            $newPlainPassword = $form->getData()->getNewPlainPassword();
            $recoverPasswordRequest = new RecoverPasswordRequest($email, $newPlainPassword, $token);

            try {
                $useCase->execute($recoverPasswordRequest, $presenter);

                return new RedirectResponse($this->router->generate('login'));
            } catch (PasswordRecoveryInvalidTokenException $e) {
                $this->flashBag->add(
                    "danger",
                    $e->getMessage()
                );
            }
        }

        return new Response($this->twig->render("security/change_password.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
