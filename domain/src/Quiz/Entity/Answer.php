<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Answer
 * @package TBoileau\CodeChallenge\Domain\Quiz\Entity
 */
class Answer
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
     * @var bool
     */
    private bool $good;

    /**
     * @param array $data
     * @return static
     * @throws \Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(Uuid::uuid4(), $data["title"], $data["good"]);
    }

    /**
     * Answer constructor.
     * @param UuidInterface $id
     * @param string $title
     * @param bool $good
     */
    public function __construct(UuidInterface $id, string $title, bool $good)
    {
        $this->id = $id;
        $this->title = $title;
        $this->good = $good;
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
     * @return bool
     */
    public function isGood(): bool
    {
        return $this->good;
    }
}
