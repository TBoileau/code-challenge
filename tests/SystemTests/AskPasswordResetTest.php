<?php

namespace App\Tests\SystemTests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationTest
 * @package App\Tests\IntegrationTests
 */
class AskPasswordResetTest extends WebTestCase
{
    public function testSuccessful()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/reset-password');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form([
            "reset_password[email]" => "used@email.com",
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    /**
     * @dataProvider provideFormData
     * @param string $email
     * @param string $errorMessage
     */
    public function testFailed(string $email, string $errorMessage)
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/reset-password');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form([
            "reset_password[email]" => $email,
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $errorMessage);
    }

    /**
     * @return Generator
     */
    public function provideFormData(): Generator
    {
        yield [
            "",
            "This value should not be blank."
        ];

        yield [
            "fail",
            "This value is not a valid email address."
        ];
    }
}
