<?php

namespace App\UserInterface\Controller;

use App\UserInterface\Form\EditPasswordType;
use App\UserInterface\Presenter\Dashboard\EditPasswordPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\CodeChallenge\Domain\Dashboard\Request\EditPasswordRequest;
use TBoileau\CodeChallenge\Domain\Dashboard\UseCase\EditPassword;

class DashboardController extends AbstractController
{
    public function __invoke(FormFactoryInterface $formFactory, Request $request, EditPassword $editPassword, EditPasswordPresenter $presenter): Response
    {
        $form = $formFactory->create(EditPasswordType::class)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $request = EditPasswordRequest::create($this->getUser()->getParticipant(), $form->getData()->getPlainPassword());
            $editPassword->execute($request, $presenter);
        }

        return $this->render('dashboard.html.twig', [
            'editPasswordForm' => $form->createView()
        ]);
    }
}