<?php

namespace TBoileau\CodeChallenge\Domain\Foo\UseCase;

use TBoileau\CodeChallenge\Domain\Foo\Gateway\ItemGateway;
use TBoileau\CodeChallenge\Domain\Foo\Presenter\BarPresenterInterface;
use TBoileau\CodeChallenge\Domain\Foo\Request\BarRequest;
use TBoileau\CodeChallenge\Domain\Foo\Response\BarResponse;

/**
 * Class Bar
 * @package TBoileau\CodeChallenge\Domain\Foo\UseCase
 */
class Bar
{
    /**
     * @var ItemGateway
     */
    private ItemGateway $itemGateway;

    /**
     * Bar constructor.
     * @param ItemGateway $itemGateway
     */
    public function __construct(ItemGateway $itemGateway)
    {
        $this->itemGateway = $itemGateway;
    }

    /**
     * @param BarRequest $request
     * @param BarPresenterInterface $presenter
     */
    public function execute(BarRequest $request, BarPresenterInterface $presenter)
    {
        $item = $this->itemGateway->find($request->getId());

        $presenter->present(new BarResponse($item));
    }
}
