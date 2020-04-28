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
        Assertion::allNotBlank($this->answers);
    }
}
