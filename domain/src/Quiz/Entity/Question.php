<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Request\CreateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Request\UpdateRequest;

/**
 * Class Question
 * @package TBoileau\CodeChallenge\Domain\Quiz\Entity
 */
class Question
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var Answer[]
     */
    private array $answers;

    /**
     * @param CreateRequest $createRequest
     * @return static
     */
    public static function fromCreate(CreateRequest $createRequest): self
    {
        return new self(
            Uuid::uuid4(),
            $createRequest->getTitle(),
            array_map(fn (array $answer) => Answer::fromArray($answer), $createRequest->getAnswers())
        );
    }

    /**
     * Question constructor.
     * @param UuidInterface $id
     * @param string $title
     * @param Answer[] $answers
     */
    public function __construct(UuidInterface $id, string $title, array $answers)
    {
        $this->id = $id;
        $this->title = $title;
        $this->answers = $answers;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param Answer[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }
}
