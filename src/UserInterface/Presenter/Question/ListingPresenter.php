<?php

namespace App\UserInterface\Presenter\Question;

use App\UserInterface\ViewModel\Question\ListingViewModel;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\ListingPresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Response\ListingResponse;

/**
 * Class ListingPresenter
 * @package App\UserInterface\Presenter\Question
 */
class ListingPresenter implements ListingPresenterInterface
{
    /**
     * @var ListingViewModel
     */
    private ListingViewModel $viewModel;

    /**
     * @inheritDoc
     */
    public function present(ListingResponse $response): void
    {
        $this->viewModel = ListingViewModel::fromResponse($response);
    }

    /**
     * @return ListingViewModel
     */
    public function getViewModel(): ListingViewModel
    {
        return $this->viewModel;
    }
}
