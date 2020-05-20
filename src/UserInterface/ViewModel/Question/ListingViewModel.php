<?php

namespace App\UserInterface\ViewModel\Question;

use App\UserInterface\DataTransferObject\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question as DomainQuestion;
use TBoileau\CodeChallenge\Domain\Quiz\Response\ListingResponse;

/**
 * Class ListingViewModel
 * @package App\UserInterface\ViewModel\Question
 */
class ListingViewModel
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
     * @var int[]
     */
    private array $range;

    /**
     * @param ListingResponse $response
     * @return static
     */
    public static function fromResponse(ListingResponse $response): self
    {
        return new self(
            array_map(
                fn (DomainQuestion $question) => Question::fromDomainQuestion($question),
                $response->getQuestions()
            ),
            $response->getCurrentPage(),
            $response->getPages(),
            $response->getLimit(),
            $response->getField(),
            $response->getOrder()
        );
    }

    /**
     * ListingViewModel constructor.
     * @param Question[]|array $questions
     * @param int $currentPage
     * @param int $pages
     * @param int $limit
     * @param string $field
     * @param string $order
     */
    public function __construct(
        array $questions,
        int $currentPage,
        int $pages,
        int $limit,
        string $field,
        string $order
    ) {
        $this->questions = $questions;
        $this->currentPage = $currentPage;
        $this->pages = $pages;
        $this->limit = $limit;
        $this->field = $field;
        $this->order = $order;
        $this->range = range(
            max(1, $this->currentPage - 3),
            min($this->pages, $this->currentPage + 3)
        );
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

    /**
     * @return int[]
     */
    public function getRange(): array
    {
        return $this->range;
    }
}
