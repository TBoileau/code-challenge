<?php

namespace TBoileau\CodeChallenge\Domain\Quiz\Response;

use Ramsey\Uuid\Uuid;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;

/**
 * Class ListingResponse
 * @package TBoileau\CodeChallenge\Domain\Quiz\Response
 */
class ListingResponse
{
    /**
     * @var Question[]
     */
    private array $questions;

    /**
     * @var int
     */
    private int $currentPage;

    /**
     * @var int
     */
    private int $pages;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var string
     */
    private string $field;

    /**
     * @var string
     */
    private string $order;

    /**
     * ListingResponse constructor.
     * @param array|Question[] $questions
     * @param int $currentPage
     * @param int $pages
     * @param int $limit
     * @param string $field
     * @param string $order
     */
    public function __construct($questions, int $currentPage, int $pages, int $limit, string $field, string $order)
    {
        $this->questions = $questions;
        $this->currentPage = $currentPage;
        $this->pages = $pages;
        $this->limit = $limit;
        $this->field = $field;
        $this->order = $order;
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }
}
