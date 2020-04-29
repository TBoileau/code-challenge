<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Gateway;

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
}
