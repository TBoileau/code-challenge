<?php

namespace App\UserInterface\Controller\Dashboard;

use App\UserInterface\Form\EditPasswordType;
use App\UserInterface\Presenter\Dashboard\EditPasswordPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\CodeChallenge\Domain\Dashboard\Request\EditPasswordRequest;
use TBoileau\CodeChallenge\Domain\Dashboard\UseCase\EditPassword;

/**
 * Class EditPasswordController
 * @package App\UserInterface\Controller\Dashboard
 */
class EditPasswordController extends AbstractController
{
    /**
     * @param FormFactoryInterface $formFactory
     * @param Request $request
     * @param EditPassword $editPassword
     * @param EditPasswordPresenter $presenter
     * @return Response
     */
    public function __invoke(
        FormFactoryInterface $formFactory,
        Request $request,
        EditPassword $editPassword,
        EditPasswordPresenter $presenter
    ): Response {
        $form = $formFactory->create(EditPasswordType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request = EditPasswordRequest::create(
                $this->getUser()->getParticipant(),
                $form->getData()->getPlainPassword()
            );

            $editPassword->execute($request, $presenter);
        }

        return $this->render('dashboard/edit-password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
