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

    public static function create(string $title): self
    {
        return new self(Uuid::uuid4(), $title);
    }

    /**
     * Answer constructor.
     * @param UuidInterface $id
     * @param string $title
     */
    public function __construct(UuidInterface $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
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
}
