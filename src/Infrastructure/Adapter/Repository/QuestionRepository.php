<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineAnswer;
use App\Infrastructure\Doctrine\Entity\DoctrineQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;

/**
 * Class QuestionRepository
 * @package App\Infrastructure\Adapter\Repository
 */
class QuestionRepository extends ServiceEntityRepository implements QuestionGateway
{
    /**
     * @inheritDoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineQuestion::class);
    }

    /**
     * @inheritDoc
     */
    public function create(Question $question): void
    {
        $doctrineQuestion = new DoctrineQuestion();
        $doctrineQuestion->setId($question->getId());
        $doctrineQuestion->setTitle($question->getTitle());
        $doctrineQuestion->setAnswers(array_map(function (Answer $answer) use ($doctrineQuestion) {
            $doctrineAnswer = new DoctrineAnswer();
            $doctrineAnswer->setId($answer->getId());
            $doctrineAnswer->setTitle($answer->getTitle());
            $doctrineAnswer->setGood($answer->isGood());
            $doctrineAnswer->setQuestion($doctrineQuestion);

            return $doctrineAnswer;
        }, $question->getAnswers()));

        $this->_em->persist($doctrineQuestion);
        $this->_em->flush();
    }
}
