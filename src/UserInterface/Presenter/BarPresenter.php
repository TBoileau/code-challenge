<?php

namespace App\UserInterface\Presenter;

use App\UserInterface\ViewModel\ItemViewModel;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarPresenterInterface;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarResponse;

/**
 * Class BarPresenter
 * @package App\UserInterface\Presenter
 */
class BarPresenter implements BarPresenterInterface
{
    /**
     * @var ItemViewModel
     */
    private ItemViewModel $viewModel;

    /**
     * @inheritDoc
     */
    public function present(BarResponse $response): void
    {
        $this->viewModel = ItemViewModel::fromItem($response->getItem());
    }

    /**
     * @return ItemViewModel
     */
    public function getViewModel(): ItemViewModel
    {
        return $this->viewModel;
    }
}
