<?php

namespace TBoileau\CodeChallenge\Domain\System\Response;

use TBoileau\CodeChallenge\Domain\System\Entity\Log;

/**
 * Class TrackResponse
 * @package TBoileau\CodeChallenge\Domain\System\Response
 */
class TrackResponse
{
    /**
     * @var Log
     */
    private Log $log;

    /**
     * TrackResponse constructor.
     * @param Log $log
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @return Log
     */
    public function getLog(): Log
    {
        return $this->log;
    }
}
