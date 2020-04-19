<?php

namespace App\Tests\SystemTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class FooTest
 * @package App\Tests\SystemTests
 */
class FooTest extends WebTestCase
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
