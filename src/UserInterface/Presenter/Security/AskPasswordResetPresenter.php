<?php

namespace App\UserInterface\Presenter\Security;

use App\UserInterface\ViewModel\Security\AskPasswordResetViewModel;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Security\Presenter\AskPasswordResetPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Response\AskPasswordResetResponse;

class AskPasswordResetPresenter implements AskPasswordResetPresenterInterface
{
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * AskPasswordResetPresenter constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function present(AskPasswordResetResponse $response): void
    {
        $this->flashBag->add(
            "success",
            "Un lien de réinitialisation de votre mot de passe a été envoyé à l'adresse email fournie !"
        );
    }
}
