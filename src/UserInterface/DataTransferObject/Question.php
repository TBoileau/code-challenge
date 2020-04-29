<?php

namespace App\UserInterface\DataTransferObject;

/**
 * Class Question
 * @package App\UserInterface\DataTransferObject
 */
class Question
{
    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var array
     */
    private array $answers = [];

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
