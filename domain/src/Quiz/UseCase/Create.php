<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\UseCase;

use Assert\AssertionFailedException;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;
use TBoileau\CodeChallenge\Domain\Quiz\Request\CreateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Response\CreateResponse;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\CreatePresenterInterface;

/**
 * Class Create
 * @package TBoileau\CodeChallenge\Domain\Quiz\UseCase
 */
class Create
{
    /**
     * @var QuestionGateway
     */
    private QuestionGateway $questionGateway;

    /**
     * Create constructor.
     * @param QuestionGateway $questionGateway
     */
    public function __construct(QuestionGateway $questionGateway)
    {
        $this->questionGateway = $questionGateway;
    }

    /**
     * @param CreateRequest $request
     * @param CreatePresenterInterface $presenter
     * @throws AssertionFailedException
     */
    public function execute(CreateRequest $request, CreatePresenterInterface $presenter)
    {
        $request->validate();

        $question = Question::fromCreate($request);

        $this->questionGateway->create($question);

        $presenter->present(new CreateResponse($question));
    }
}
