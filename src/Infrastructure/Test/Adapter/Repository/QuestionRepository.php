<?php

namespace App\Infrastructure\Test\Adapter\Repository;

use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;

/**
 * Class QuestionRepository
 * @package App\Infrastructure\Test\Adapter\Repository
 */
class QuestionRepository implements QuestionGateway
{
    /**
     * @inheritDoc
     */
    public function create(Question $question): void
    {
    }
}
