<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Response;

use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;

/**
 * Class CreateResponse
 * @package TBoileau\CodeChallenge\Domain\Quiz\Response
 */
class CreateResponse
{
    /**
     * @var Question
     */
    private Question $question;

    /**
     * CreateResponse constructor.
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
