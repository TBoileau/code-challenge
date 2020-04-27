<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineLog;
use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TBoileau\CodeChallenge\Domain\System\Entity\Log;
use TBoileau\CodeChallenge\Domain\System\Gateway\LogGateway;

/**
 * Class LogRepository
 * @package App\Infrastructure\Adapter\Repository
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
        $doctrineLog = new DoctrineLog();
        $doctrineLog->setIp($log->getIp());
        $doctrineLog->setMethod($log->getMethod());
        if ($log->getParticipant() !== null) {
            $doctrineLog->setParticipant(
                $this->_em->getRepository(DoctrineParticipant::class)->find($log->getParticipant()->getId())
            );
        }
        $doctrineLog->setQueryData($log->getQueryData());
        $doctrineLog->setRequestData($log->getRequestData());
        $doctrineLog->setRoute($log->getRoute());
        $doctrineLog->setRouteParams($log->getRouteParams());
        $doctrineLog->setLoggedAt($log->getLoggedAt());
        $this->_em->persist($doctrineLog);
        $this->_em->flush();
    }
}
