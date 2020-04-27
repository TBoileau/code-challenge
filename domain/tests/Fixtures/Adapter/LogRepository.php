<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter;

use TBoileau\CodeChallenge\Domain\System\Entity\Log;
use TBoileau\CodeChallenge\Domain\System\Gateway\LogGateway;

/**
 * Class LogRepository
 * @package TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter
 */
class LogRepository implements LogGateway
{
    /**
     * @inheritDoc
     */
    public function insert(Log $log): void
    {
    }
}
