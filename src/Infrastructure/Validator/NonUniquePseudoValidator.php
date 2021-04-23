<?php

namespace App\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class NonUniquePseudoValidator
 * @package App\Infrastructure\Validator
 */
class NonUniquePseudoValidator extends ConstraintValidator
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $userGateway;

    /**
     * NonUniquePseudoValidator constructor.
     * @param ParticipantGateway $participantGateway
     */
    public function __construct(ParticipantGateway $participantGateway)
    {
        $this->userGateway = $participantGateway;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->userGateway->isPseudoUnique($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
