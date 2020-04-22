<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NonUniqueEmail
 * @package App\Infrastructure\Validator
 */
class NonUniqueEmail extends Constraint
{
    public string $message = "This email address already exists.";
}
