<?php

namespace App\UserInterface\Presenter\Question;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\UpdatePresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Response\UpdateResponse;

/**
 * Class UpdatePresenter
 * @package App\UserInterface\Presenter\Question
 */
class UpdatePresenter implements UpdatePresenterInterface
{
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * UpdatePresenter constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function present(UpdateResponse $response): void
    {
        $this->flashBag->add(
            "success",
            sprintf("Votre question '%s' a été modifiée avec succès !", $response->getQuestion()->getTitle())
        );
    }
}
