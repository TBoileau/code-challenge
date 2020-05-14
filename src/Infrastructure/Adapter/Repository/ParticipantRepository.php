<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;
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
        parent::__construct($registry, DoctrineParticipant::class);
    }

    /**
     * @inheritDoc
     */
    public function getParticipantByEmail(string $email): ?Participant
    {
        /** @var DoctrineParticipant $DoctrineParticipant */
        $DoctrineParticipant = $this->findOneByEmail($email);

        if ($DoctrineParticipant === null) {
            return null;
        }

        return new Participant(
            $DoctrineParticipant->getId(),
            $DoctrineParticipant->getEmail(),
            $DoctrineParticipant->getPseudo(),
            $DoctrineParticipant->getPassword()
        );
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
        $DoctrineParticipant = new DoctrineParticipant();
        $DoctrineParticipant->setId($participant->getId());
        $DoctrineParticipant->setEmail($participant->getEmail());
        $DoctrineParticipant->setPassword($participant->getPassword());
        $DoctrineParticipant->setPseudo($participant->getPseudo());

        $this->_em->persist($DoctrineParticipant);
        $this->_em->flush();
    }

    public function update(Participant $participant): void
    {
        $doctrineParticipant = $this->find($participant->getId());
        $doctrineParticipant->setPassword($participant->getPassword());

        $this->_em->flush();
    }
}
