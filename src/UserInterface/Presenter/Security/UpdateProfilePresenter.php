<?php

namespace App\UserInterface\Presenter\Security;

use App\UserInterface\ViewModel\Security\UpdateProfileViewModel;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Security\Presenter\UpdateProfilePresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;

class UpdateProfilePresenter implements UpdateProfilePresenterInterface
{

    private ?UpdateProfileViewModel $viewModel = null;

    private FlashBagInterface $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function present(UpdateProfileResponse $response): void
    {
        $this->viewModel = new UpdateProfileViewModel();
        $this->viewModel->setAvatar($response->getParticipant()->getAvatar());
        if ($response->hasErrors()) {
            foreach ($response->getErrors() as $errorMessage) {
                $this->viewModel->addErrorMessage($errorMessage);
                $this->flashBag->add('error', $errorMessage);
            }
        } else {
            $this->flashBag->add('success', 'Le profil a bien été mis à jour');
        }
    }

    /**
     * @return UpdateProfileViewModel
     */
    public function getViewModel(): ?UpdateProfileViewModel
    {
        return $this->viewModel;
    }
}
