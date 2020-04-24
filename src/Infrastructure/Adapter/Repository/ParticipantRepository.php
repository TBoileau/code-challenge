<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class UserRepository
 * @package App\Infrastructure\Adapter\Repository
 */
class ParticipantRepository extends ServiceEntityRepository implements ParticipantGateway
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    /**
     * @inheritDoc
     */
    public function isEmailUnique(?string $email): bool
    {
        return $this->count(["email" => $email]) === 0;
    }

    /**
     * @inheritDoc
     */
    public function isPseudoUnique(?string $pseudo): bool
    {
        return $this->count(["pseudo" => $pseudo]) === 0;
    }

    /**
     * @inheritDoc
     */
    public function register(Participant $participant): void
    {
        $doctrineUser = new DoctrineUser();
        $doctrineUser->setId($participant->getId());
        $doctrineUser->setEmail($participant->getEmail());
        $doctrineUser->setPassword($participant->getPassword());
        $doctrineUser->setPseudo($participant->getPseudo());

        $this->_em->persist($doctrineUser);
        $this->_em->flush();
    }
}
