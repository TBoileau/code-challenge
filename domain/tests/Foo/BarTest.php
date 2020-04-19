<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Foo;

use App\Infrastructure\Test\Adapter\Repository\ItemRepository;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarPresenterInterface;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarRequest;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarResponse;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\Bar;
use PHPUnit\Framework\TestCase;

/**
 * Class BarTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Foo
 */
class BarTest extends TestCase
{
    public function test(): void
    {
        $request = new BarRequest(1);

        $presenter = new class () implements BarPresenterInterface {
            public BarResponse $response;

            public function present(BarResponse $response): void
            {
                $this->response = $response;
            }
        };

        $useCase = new Bar(new ItemRepository());

        $useCase->execute($request, $presenter);

        $this->assertInstanceOf(BarResponse::class, $presenter->response);
        $this->assertEquals(1, $presenter->response->getItem()->getId());
        $this->assertEquals("name", $presenter->response->getItem()->getName());
    }
}
