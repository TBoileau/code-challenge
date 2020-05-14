<?php

namespace App\UserInterface\Presenter\Dashboard;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Presenter\EditPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;

class EditPasswordPresenter implements EditPasswordPresenterInterface
{
    private FlashBagInterface $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function present(EditPasswordResponse $response): void
    {
        $this->flashBag->add(
            "success",
            "Votre mot de passe a bien été modifié !"
        );
    }
}