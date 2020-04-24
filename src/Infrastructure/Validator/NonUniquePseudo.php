<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NonUniquePseudo
 * @package App\Infrastructure\Validator
 */
class NonUniquePseudo extends Constraint
{
    public string $message = "This pseudo already exists.";
}
