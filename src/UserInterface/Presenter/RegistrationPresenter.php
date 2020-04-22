<?php

namespace App\UserInterface\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Presenter\RegistrationPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Response\RegistrationResponse;

/**
 * Class RegistrationPresenter
 * @package App\UserInterface\Presenter
 */
class RegistrationPresenter implements RegistrationPresenterInterface
{
    /**
     * @inheritDoc
     */
    public function present(RegistrationResponse $response): void
    {
        // TODO: Implement present() method.
    }
}
