<?php

namespace App\Tests\EndToEndTests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class ApiTest
 * @package App\Tests\EndToEndTests
 */
class ApiTest extends PantherTestCase
{
    public function test(): void
    {
        $client = static::createPantherClient();

        $crawler = $client->request(Request::METHOD_GET, "/foo/bar/1");

        $json = json_decode($crawler->filter("body")->text(), true);

        $this->assertEquals(["id" => 1, "name" => "name"], $json);
    }
}
