<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
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
        /** @var DoctrineParticipant $doctrineParticipant */
        $doctrineParticipant = $this->findOneBy(['email' => $email]);//dd($doctrineParticipant);

        if ($doctrineParticipant === null) {
            return null;
        }

        return new Participant(
            $doctrineParticipant->getId(),
            $doctrineParticipant->getEmail(),
            $doctrineParticipant->getPseudo(),
            $doctrineParticipant->getPassword(),
            $doctrineParticipant->getPasswordResetToken(),
            $doctrineParticipant->getPasswordResetRequestedAt(),
            $doctrineParticipant->getAvatar()
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
     * @throws ORMException
     */
    public function register(Participant $participant): void
    {
        $doctrineParticipant = new DoctrineParticipant();
        $doctrineParticipant->setId($participant->getId());
        $doctrineParticipant->setEmail($participant->getEmail());
        $doctrineParticipant->setPassword($participant->getPassword());
        $doctrineParticipant->setPseudo($participant->getPseudo());

        $this->_em->persist($doctrineParticipant);
        $this->_em->flush();
    }

    /**
     * @param Participant $participant
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Participant $participant): void
    {
        /** @var DoctrineParticipant $doctrineParticipant */
        $doctrineParticipant = $this->find($participant->getId());

        if ($doctrineParticipant === null) {
            return;
        }

        $this->hydrateParticipant($doctrineParticipant, $participant);

        $this->_em->flush();
    }

    /**
     * @param DoctrineParticipant $doctrineParticipant
     * @param Participant $participant
     */
    private function hydrateParticipant(DoctrineParticipant $doctrineParticipant, Participant $participant): void
    {
        $doctrineParticipant->setEmail($participant->getEmail());
        $doctrineParticipant->setPassword($participant->getPassword());
        $doctrineParticipant->setPseudo($participant->getPseudo());
        $doctrineParticipant->setPasswordResetToken($participant->getPasswordResetToken());
        $doctrineParticipant->setPasswordResetRequestedAt($participant->getPasswordResetRequestedAt());
        if ($participant->getAvatar() !== null) {
            $doctrineParticipant->setAvatar($participant->getAvatar());
        }
    }

    public function getParticipantById(string $id): ?Participant
    {
        $doctrineParticipant = $this->find($id);
        if ($doctrineParticipant === null) {
            return null;
        }

        return new Participant(
            $doctrineParticipant->getId(),
            $doctrineParticipant->getEmail(),
            $doctrineParticipant->getPseudo(),
            $doctrineParticipant->getPassword(),
            $doctrineParticipant->getPasswordResetToken(),
            $doctrineParticipant->getPasswordResetRequestedAt()
        );
    }
}
