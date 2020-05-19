<?php

namespace App\UserInterface\Presenter\Dashboard;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Presenter\EditPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;

/**
 * Class EditPasswordPresenter
 * @package App\UserInterface\Presenter\Dashboard
 */
class EditPasswordPresenter implements EditPasswordPresenterInterface
{
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function present(EditPasswordResponse $response): void
    {
        $this->flashBag->add(
            "success",
            "Votre mot de passe a bien été modifié !"
        );
    }
}
