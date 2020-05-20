<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\DoctrineAnswer;
use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use App\Infrastructure\Doctrine\Entity\DoctrineQuestion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class QuestionFixtures
 * @package App\Infrastructure\Doctrine\DataFixtures
 */
class QuestionFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($j = 1; $j <= 25; $j++) {
            $question = new DoctrineQuestion();
            $question->setId(Uuid::uuid4());
            $question->setTitle("title " . $j);
            $answers = [];
            for ($i = 1; $i <= 4; $i++) {
                $answer = new DoctrineAnswer();
                $answer->setId(Uuid::uuid4());
                $answer->setTitle("title");
                $answer->setGood($i % 2);
                $answer->setQuestion($question);
                $answers[] = $answer;
            }
            $question->setAnswers($answers);
            $manager->persist($question);
        }
        $manager->flush();
    }
}
