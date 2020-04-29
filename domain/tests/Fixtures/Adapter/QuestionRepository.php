<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;

/**
 * Class QuestionRepository
 * @package TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter
 */
class QuestionRepository implements QuestionGateway
{
    /**
     * @inheritDoc
     */
    public function create(Question $question): void
    {


    }

    /**
     * @inheritDoc
     */
    public function update(Question $question): void
    {

    }

    /**
     * @inheritDoc
     */
    public function getQuestionById(UuidInterface $id): ?Question
    {
        return new Question($id, "title", [
            new Answer(Uuid::uuid4(), "answer 1", true),
            new Answer(Uuid::uuid4(), "answer 2", false),
            new Answer(Uuid::uuid4(), "answer 3", true)
        ]);
    }
}
