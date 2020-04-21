<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Foo;

use TBoileau\CodeChallenge\Domain\Foo\Entity\Item;
use TBoileau\CodeChallenge\Domain\Foo\Gateway\ItemGateway;
use TBoileau\CodeChallenge\Domain\Foo\Presenter\BarPresenterInterface;
use TBoileau\CodeChallenge\Domain\Foo\Request\BarRequest;
use TBoileau\CodeChallenge\Domain\Foo\Response\BarResponse;
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

        $repository = new class () implements ItemGateway {
            public function find(int $id): Item
            {
                return new Item($id, 'name');
            }
        };


        $presenter = new class () implements BarPresenterInterface {
            public BarResponse $response;

            public function present(BarResponse $response): void
            {
                $this->response = $response;
            }
        };

        $useCase = new Bar($repository);

        $useCase->execute($request, $presenter);

        $this->assertInstanceOf(BarResponse::class, $presenter->response);
        $this->assertEquals(1, $presenter->response->getItem()->getId());
        $this->assertEquals("name", $presenter->response->getItem()->getName());
    }
}
