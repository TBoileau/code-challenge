<?php

namespace App\UserInterface\Presenter\Question;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\CreatePresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Response\CreateResponse;

/**
 * Class CreatePresenter
 * @package App\UserInterface\Presenter\Question
 */
class CreatePresenter implements CreatePresenterInterface
{
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * CreatePresenter constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @inheritDoc
     */
    public function present(CreateResponse $response): void
    {
        $this->flashBag->add(
            "success",
            sprintf("Votre question '%s' a été ajoutée avec succès !", $response->getQuestion()->getTitle())
        );
    }
}
