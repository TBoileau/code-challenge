<?php

namespace TBoileau\CodeChallenge\Domain\System\Gateway;

use TBoileau\CodeChallenge\Domain\System\Entity\Log;

/**
 * Interface LogGateway
 * @package TBoileau\CodeChallenge\Domain\System\Gateway
 */
interface LogGateway
{
    /**
     * @param Log $log
     */
    public function insert(Log $log): void;
}
