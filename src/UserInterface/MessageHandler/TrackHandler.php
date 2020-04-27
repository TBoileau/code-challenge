<?php

namespace App\UserInterface\MessageHandler;

use App\UserInterface\Presenter\TrackPresenter;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TBoileau\CodeChallenge\Domain\System\Request\TrackRequest;
use TBoileau\CodeChallenge\Domain\System\UseCase\Track;

/**
 * Class TrackHandler
 * @package App\UserInterface\MessageHandler
 */
class TrackHandler implements MessageHandlerInterface
{
    /**
     * @var Track
     */
    private Track $track;

    /**
     * TrackHandler constructor.
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * @param TrackRequest $trackRequest
     */
    public function __invoke(TrackRequest $trackRequest)
    {
        $this->track->execute($trackRequest, new TrackPresenter());
    }
}
