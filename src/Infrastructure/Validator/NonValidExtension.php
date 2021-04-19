<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NonValidExtension extends Constraint
{
    public string $message = 'This avatar extension is not valid.';
}
