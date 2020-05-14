<?php

namespace TBoileau\CodeChallenge\Domain\Dashboard\Presenter;

use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;

interface EditPasswordPresenterInterface
{
    public function present(EditPasswordResponse $response): void;
}