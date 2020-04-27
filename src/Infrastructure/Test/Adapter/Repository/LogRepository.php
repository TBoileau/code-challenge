<?php

namespace App\Infrastructure\Test\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineLog;
use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TBoileau\CodeChallenge\Domain\System\Entity\Log;
use TBoileau\CodeChallenge\Domain\System\Gateway\LogGateway;

/**
 * Class LogRepository
 * @package App\Infrastructure\Test\Adapter\Repository
 */
class LogRepository extends ServiceEntityRepository implements LogGateway
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineLog::class);
    }

    /**
     * @inheritDoc
     */
    public function insert(Log $log): void
    {
    }
}
