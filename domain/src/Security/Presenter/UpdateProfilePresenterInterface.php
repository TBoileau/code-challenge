<?php

namespace TBoileau\CodeChallenge\Domain\Security\Presenter;

use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;

interface UpdateProfilePresenterInterface
{
    public function present(UpdateProfileResponse $response): void;
}
