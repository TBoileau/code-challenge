<?php

namespace App\UserInterface\Presenter;

use App\UserInterface\ViewModel\RegistrationViewModel;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Presenter\RegistrationPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;

/**
 * Class RegistrationPresenter
 * @package App\UserInterface\Presenter
 */
class RegistrationPresenter implements RegistrationPresenterInterface
{
    /**
     * @var RegistrationViewModel
     */
    private RegistrationViewModel $viewModel;

    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * @var UserProviderInterface
     */
    private UserProviderInterface $userProvider;

    /**
     * RegistrationPresenter constructor.
     * @param FlashBagInterface $flashBag
     * @param UserProviderInterface $userProvider
     */
    public function __construct(FlashBagInterface $flashBag, UserProviderInterface $userProvider)
    {
        $this->flashBag = $flashBag;
        $this->userProvider = $userProvider;
    }

    /**
     * @inheritDoc
     */
    public function present(RegistrationResponse $response): void
    {
        $this->viewModel = new RegistrationViewModel($this->userProvider->loadUserByUsername($response->getEmail()));

        $this->flashBag->add(
            "success",
            "Bienvenue sur Code Challenge ! Votre inscription a été effectuée avec succès !"
        );
    }

    /**
     * @return RegistrationViewModel
     */
    public function getViewModel(): RegistrationViewModel
    {
        return $this->viewModel;
    }
}
