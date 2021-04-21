<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;
use Generator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListingQuestionsTest
 * @package App\Tests\IntegrationTests
 */
class ListingQuestionsTest extends IntegrationTestCase
{
    /**
     * @dataProvider providePaginationData
     * @param int $page
     * @param int $expectedPage
     * @param int $limit
     * @param int $pages
     * @param int $count
     */
    public function test(int $page, int $expectedPage, int $limit, int $pages, int $count)
    {
        $client = static::createClient();

        $crawler = $client->request(
            Request::METHOD_GET,
            sprintf('/questions?page=%d&limit=%d', $page, $limit)
        );

        $this->assertCount($count, $crawler->filter(".Table tbody tr"));
        if ($pages > 1) {
            $this->assertCount($pages, $crawler->filter(".Pagination__Item"));
            $this->assertEquals($expectedPage, $crawler->filter(".Pagination__Item--active")->text());
        } else {
            $this->assertCount(0, $crawler->filter(".Pagination__Item"));
        }
    }

    /**
     * @return Generator
     */
    public function providePaginationData(): Generator
    {
        yield [1, 1, 10, 4, 10];
        yield [2, 2, 10, 5, 10];
        yield [3, 3, 10, 4, 5];
        yield [4, 1, 10, 4, 10];
        yield [1, 1, 50, 1, 25];
    }
}
