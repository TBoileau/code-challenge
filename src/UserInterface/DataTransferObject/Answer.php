<?php

namespace App\UserInterface\DataTransferObject;

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
