<?php

namespace App\Infrastructure\Adapter\Repository;

use App\Infrastructure\Doctrine\Entity\DoctrineAnswer;
use App\Infrastructure\Doctrine\Entity\DoctrineQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
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
     * @param DoctrineQuestion $doctrineQuestion
     * @param Question $question
     */
    private function hydrateQuestion(DoctrineQuestion $doctrineQuestion, Question $question): void
    {
        $doctrineQuestion->setTitle($question->getTitle());
        $doctrineQuestion->getAnswers()->clear();
        $doctrineQuestion->setAnswers(array_map(function (Answer $answer) use ($doctrineQuestion) {
            $doctrineAnswer = new DoctrineAnswer();
            $doctrineAnswer->setId($answer->getId());
            $doctrineAnswer->setTitle($answer->getTitle());
            $doctrineAnswer->setGood($answer->isGood());
            $doctrineAnswer->setQuestion($doctrineQuestion);

            return $doctrineAnswer;
        }, $question->getAnswers()));
    }

    /**
     * @inheritDoc
     */
    public function create(Question $question): void
    {
        $doctrineQuestion = new DoctrineQuestion();
        $doctrineQuestion->setId($question->getId());

        $this->hydrateQuestion($doctrineQuestion, $question);

        $this->_em->persist($doctrineQuestion);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function update(Question $question): void
    {
        $doctrineQuestion = $this->find($question->getId());

        $this->hydrateQuestion($doctrineQuestion, $question);

        $this->_em->persist($doctrineQuestion);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getQuestionById(UuidInterface $id): ?Question
    {
        /** @var DoctrineQuestion $doctrineQuestion */
        $doctrineQuestion = $this->find($id);

        if ($doctrineQuestion === null) {
            return null;
        }

        return new Question(
            $doctrineQuestion->getId(),
            $doctrineQuestion->getTitle(),
            $doctrineQuestion->getAnswers()->map(function (DoctrineAnswer $doctrineAnswer) use ($doctrineQuestion) {
                return new Answer(
                    $doctrineAnswer->getId(),
                    $doctrineAnswer->getTitle(),
                    $doctrineAnswer->isGood()
                );
            })->toArray()
        );
    }

    /**
     * @inheritDoc
     */
    public function getQuestions(int $page, int $limit, string $field, string $order): array
    {
        $fields = [
            "title" => "q.title",
            "answers" => "COUNT(a.id)"
        ];

        $questions = $this->createQueryBuilder("q")
            ->join("q.answers", "a")
            ->orderBy($fields[$field], $order)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->groupBy("q.id")
            ->addGroupBy("q.title")
            ->getQuery()
            ->getResult()
        ;

        return array_map(
            fn (DoctrineQuestion $question) => new Question(
                $question->getId(),
                $question->getTitle(),
                $question->getAnswers()->map(
                    fn (DoctrineAnswer $answer) => new Answer(
                        $answer->getId(),
                        $answer->getTitle(),
                        $answer->isGood()
                    )
                )->toArray()
            ),
            $questions
        );
    }

    /**
     * @inheritDoc
     */
    public function countQuestions(): int
    {
        return $this->count([]);
    }
}
