<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Request;

use Assert\Assertion;
use Assert\AssertionFailedException;

/**
 * Class CreateRequest
 * @package TBoileau\CodeChallenge\Domain\Quiz\Request
 */
class CreateRequest
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var array
     */
    private array $answers;

    /**
     * @param string $title
     * @param array $answers
     * @return static
     */
    public static function create(string $title, array $answers): self
    {
        return new self($title, $answers);
    }

    /**
     * CreateRequest constructor.
     * @param string $title
     * @param array $answers
     */
    public function __construct(string $title, array $answers)
    {
        $this->title = $title;
        $this->answers = $answers;
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
