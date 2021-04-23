<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NonValidExtensionValidator extends ConstraintValidator
{

    private const VALID_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * @param mixed $value
     * @param NonValidExtension|Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            if (!in_array($extension, self::VALID_EXTENSIONS)) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}
