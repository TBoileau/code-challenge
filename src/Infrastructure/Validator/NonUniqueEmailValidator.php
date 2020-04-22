<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use TBoileau\CodeChallenge\Domain\Security\Gateway\UserGateway;

/**
 * Class NonUniqueEmailValidator
 * @package App\Infrastructure\Validator
 */
class NonUniqueEmailValidator extends ConstraintValidator
{
    /**
     * @var UserGateway
     */
    private UserGateway $userGateway;

    /**
     * NonUniqueEmailValidator constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->userGateway->isEmailUnique($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
