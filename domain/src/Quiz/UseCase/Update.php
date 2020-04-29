<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\UseCase;

use Assert\AssertionFailedException;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;
use TBoileau\CodeChallenge\Domain\Quiz\Request\UpdateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Response\UpdateResponse;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\UpdatePresenterInterface;

/**
 * Class Update
 * @package TBoileau\CodeChallenge\Domain\Quiz\UseCase
 */
class Update
{
    /**
     * @var QuestionGateway
     */
    private QuestionGateway $questionGateway;

    /**
     * Update constructor.
     * @param QuestionGateway $questionGateway
     */
    public function __construct(QuestionGateway $questionGateway)
    {
        $this->questionGateway = $questionGateway;
    }

    /**
     * @param UpdateRequest $request
     * @param UpdatePresenterInterface $presenter
     * @throws AssertionFailedException
     */
    public function execute(UpdateRequest $request, UpdatePresenterInterface $presenter)
    {
        $request->validate();

        $question = $this->questionGateway->getQuestionById($request->getId());
        $question->setTitle($request->getTitle());
        $question->setAnswers(
            array_map(fn (array $answer) => Answer::fromArray($answer),$request->getAnswers())
        );

        $this->questionGateway->update($question);

        $presenter->present(new UpdateResponse($question));
    }
}
