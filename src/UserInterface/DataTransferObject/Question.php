<?php

namespace App\UserInterface\DataTransferObject;

use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer as DomainAnswer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question as DomainQuestion;

/**
 * Class Question
 * @package App\UserInterface\DataTransferObject
 */
class Question
{
    /**
     * @var UuidInterface|null
     */
    private ?UuidInterface $id = null;

    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var array
     */
    private array $answers = [];

    /**
     * @param DomainQuestion $question
     * @return static
     */
    public static function fromDomainQuestion(DomainQuestion $question): self
    {
        $newQuestion = new self();
        $newQuestion->id = $question->getId();
        $newQuestion->title = $question->getTitle();
        $newQuestion->answers = array_map(
            fn (DomainAnswer $answer) => Answer::fromDomainAnswer($answer),
            $question->getAnswers()
        );

        return $newQuestion;
    }

    /**
     * @return UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param array $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }
}
