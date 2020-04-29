<?php

namespace App\UserInterface\DataTransferObject;

use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer as DomainAnswer;

/**
 * Class Answer
 * @package App\UserInterface\DataTransferObject
 */
class Answer
{
    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var bool
     */
    private bool $good = false;

    /**
     * @param DomainAnswer $answer
     * @return static
     */
    public static function fromDomainAnswer(DomainAnswer $answer): self
    {
        $newAnswer = new self();
        $newAnswer->title = $answer->getTitle();
        $newAnswer->good = $answer->isGood();

        return $newAnswer;
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
     * @return bool
     */
    public function isGood(): bool
    {
        return $this->good;
    }

    /**
     * @param bool $good
     */
    public function setGood(bool $good): void
    {
        $this->good = $good;
    }
}
