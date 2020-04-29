<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Response;

use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;

/**
 * Class UpdateResponse
 * @package TBoileau\CodeChallenge\Domain\Quiz\Response
 */
class UpdateResponse
{
    /**
     * @var Question
     */
    private Question $question;

    /**
     * UpdateResponse constructor.
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }
}
