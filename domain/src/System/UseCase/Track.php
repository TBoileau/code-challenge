<?php

namespace TBoileau\CodeChallenge\Domain\System\UseCase;

use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\System\Entity\Log;
use TBoileau\CodeChallenge\Domain\System\Gateway\LogGateway;
use TBoileau\CodeChallenge\Domain\System\Request\TrackRequest;
use TBoileau\CodeChallenge\Domain\System\Response\TrackResponse;
use TBoileau\CodeChallenge\Domain\System\Presenter\TrackPresenterInterface;

/**
 * Class Track
 * @package TBoileau\CodeChallenge\Domain\System\UseCase
 */
class Track
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $participantGateway;

    /**
     * @var LogGateway
     */
    private LogGateway $logGateway;

    /**
     * Track constructor.
     * @param ParticipantGateway $participantGateway
     * @param LogGateway $logGateway
     */
    public function __construct(ParticipantGateway $participantGateway, LogGateway $logGateway)
    {
        $this->participantGateway = $participantGateway;
        $this->logGateway = $logGateway;
    }

    /**
     * @param TrackRequest $request
     * @param TrackPresenterInterface $presenter
     */
    public function execute(TrackRequest $request, TrackPresenterInterface $presenter)
    {
        $participant = $request->getEmail() === null
            ? null
            : $this->participantGateway->getParticipantByEmail($request->getEmail())
        ;

        $log = Log::fromTrack($request, $participant);

        $this->logGateway->insert($log);

        $presenter->present(new TrackResponse($log));
    }
}
