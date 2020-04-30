<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\UseCase;

use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;
use TBoileau\CodeChallenge\Domain\Quiz\Request\ListingRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Response\ListingResponse;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\ListingPresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Assert\Assertion;

/**
 * Class Listing
 * @package TBoileau\CodeChallenge\Domain\Quiz\UseCase
 */
class Listing
{
    /**
     * @var QuestionGateway
     */
    private QuestionGateway $questionGateway;

    /**
     * Listing constructor.
     * @param QuestionGateway $questionGateway
     */
    public function __construct(QuestionGateway $questionGateway)
    {
        $this->questionGateway = $questionGateway;
    }

    /**
     * @param ListingRequest $request
     * @param ListingPresenterInterface $presenter
     */
    public function execute(ListingRequest $request, ListingPresenterInterface $presenter)
    {
        $request->validate();

        $countQuestion = $this->questionGateway->countQuestions();

        $pages = ceil($countQuestion / $request->getLimit());

        Assertion::range($request->getPage(), 1, $pages);

        $presenter->present(
            new ListingResponse(
                $this->questionGateway->getQuestions(
                    $request->getPage(),
                    $request->getLimit(),
                    $request->getField(),
                    $request->getOrder()
                ),
                $request->getPage(),
                $pages,
                $request->getLimit(),
                $request->getField(),
                $request->getOrder()
            )
        );
    }
}
