<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;

/**
 * Class FooTest
 *
 * @package App\Tests\IntegrationTests
 */
class FooTest extends IntegrationTestCase
{
    public function test()
    {
        $client = static::createClient();

        $client->request("GET", "/foo/bar/1");

        $this->assertResponseIsSuccessful();

        $this->isJson();

        $json = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(["id" => 1, "name" => "name"], $json);
    }
}
