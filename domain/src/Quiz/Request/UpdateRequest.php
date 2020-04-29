<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Request;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UpdateRequest
 * @package TBoileau\CodeChallenge\Domain\Quiz\Request
 */
class UpdateRequest
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
     * @var array
     */
    private array $answers;

    /**
     * @param UuidInterface $id
     * @param string $title
     * @param array $answers
     * @return static
     */
    public static function create(UuidInterface $id, string $title, array $answers): self
    {
        return new self($id, $title, $answers);
    }

    /**
     * UpdateRequest constructor.
     * @param UuidInterface $id
     * @param string $title
     * @param array $answers
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
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @throws AssertionFailedException
     */
    public function validate(): void
    {
        Assertion::notBlank($this->title);
        Assertion::minCount($this->answers, 2);
        Assertion::allNotBlank(array_map(fn (array $answer) => $answer["title"], $this->answers));
        Assertion::allBoolean(array_map(fn (array $answer) => $answer["good"], $this->answers));
        Assertion::minCount(array_filter($this->answers, fn (array $answer) => $answer["good"]), 1);
    }
}
