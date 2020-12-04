<?php


namespace App\UserInterface\Controller\Security;


use App\UserInterface\Form\ResetPasswordType;
use App\UserInterface\Presenter\Security\AskPasswordResetPresenter;
use Assert\AssertionFailedException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * AskPasswordResetController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     */
    public function __construct(FormFactoryInterface $formFactory, Environment $twig)
    {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param AskPasswordReset $useCase
     * @param AskPasswordResetPresenter $presenter
     * @return Response
     * @throws AssertionFailedException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, AskPasswordReset $useCase, AskPasswordResetPresenter $presenter): Response
    {
        $form = $this->formFactory->create(ResetPasswordType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $askPasswordResetRequest = AskPasswordResetRequest::create($form->getData()->getEmail());

            $useCase->execute($askPasswordResetRequest, $presenter);

            return new Response($this->twig->render("reset_password.html.twig", [
                "status" => $presenter->getViewModel()->isPasswordResetLinkSent()
            ]));
        }
        return new Response($this->twig->render("reset_password.html.twig", [
            "form" => $form->createView()
        ]));
    }


}
