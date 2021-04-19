<?php

namespace App\UserInterface\Controller\Security;

use App\Infrastructure\Security\User;
use App\UserInterface\DataTransferObject\Participant;
use App\UserInterface\Form\ParticipantType;
use App\UserInterface\Presenter\Security\UpdateProfilePresenter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use TBoileau\CodeChallenge\Domain\Security\Request\UpdateProfileRequest;
use TBoileau\CodeChallenge\Domain\Security\Uploader\Uploader;
use TBoileau\CodeChallenge\Domain\Security\UseCase\UpdateProfile;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UpdateProfileController
{

    private Environment $twig;

    private UrlGeneratorInterface $urlGenerator;

    private FormFactoryInterface $formFactory;

    private Security $security;

    private UpdateProfile $updateProfile;

    private UpdateProfilePresenter $presenter;

    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $urlGenerator,
        FormFactoryInterface $formFactory,
        Security $security,
        UpdateProfile $updateProfile,
        UpdateProfilePresenter $presenter
    ) {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->formFactory = $formFactory;
        $this->security = $security;
        $this->updateProfile = $updateProfile;
        $this->presenter = $presenter;
    }

    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory
          ->create(ParticipantType::class, $this->getCurrentParticipant())
          ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $participant Participant */
            $participant = $form->getData();

            /** @var $file UploadedFile */
            $file = $form->get('avatarPath')->getData();
            if ($file) {
                $avatarName = $file->getClientOriginalName();
                $uploader = new Uploader($file, $avatarName);
            }
            $updateRequest = new UpdateProfileRequest(
                $participant->getId(),
                $participant->getEmail(),
                $participant->getPseudo(),
                $uploader ?? null
            );
            $this->updateProfile->execute($updateRequest, $this->presenter);
            return new RedirectResponse(
                $this->urlGenerator->generate('profile_edit')
            );
        }
        return new Response(
            $this->twig->render('participant/profile_edit.html.twig', [
              'form' => $form->createView(),
            ])
        );
    }

    private function getCurrentParticipant(): Participant
    {
        /** @var $user User */
        $user = $this->security->getUser();
        if ($user === null) {
            throw new AuthenticationException();
        }
        $currentParticipant = $user->getParticipant();

        return Participant::fromDomainEntity($currentParticipant);
    }
}
