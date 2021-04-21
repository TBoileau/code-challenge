<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Gateway;

use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;

/**
 * Interface QuestionGateway
 * @package TBoileau\CodeChallenge\Domain\Quiz\Gateway
 */
interface QuestionGateway
{
    /**
     * @param Question $question
     */
    public function create(Question $question): void;

    /**
     * @param Question $question
     */
    public function update(Question $question): void;

    /**
     * @param UuidInterface $id
     * @return Question|null
     */
    public function getQuestionById(UuidInterface $id): ?Question;

    /**
     * @param int $page
     * @param int $limit
     * @param string $field
     * @param string $order
     * @return array
     */
    public function getQuestions(int $page, int $limit, string $field, string $order): array;

    /**
     * @return int
     */
    public function countQuestions(): int;
}
