<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationTest
 * @package App\Tests\IntegrationTests
 */
class RecoverPasswordTest extends IntegrationTestCase
{
    public function testSuccessful()
    {
        $client = static::createClient();

        $crawler = $client->request(
            Request::METHOD_GET,
            '/handle-reset-password/used@email.com/bb4b5730-6057-4fa1-a27b-692b9ba8c14a'
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form([
            "recover_password[newPlainPassword][first]" => "new_password",
            "recover_password[newPlainPassword][second]" => "new_password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('html', 'Mot de passe changer avec succès !');
    }

    /**
     * @dataProvider provideFormData
     * @param string $email
     * @param string $token
     * @param array $newPlainPassword
     * @param string $errorMessage
     */
    public function testFailed(string $email, string $token, array $newPlainPassword, string $errorMessage)
    {
        $client = static::createClient();

        $crawler = $client->request(
            Request::METHOD_GET,
            "/handle-reset-password/$email/$token"
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form([
            "recover_password[newPlainPassword][first]" => $newPlainPassword["first"],
            "recover_password[newPlainPassword][second]" => $newPlainPassword["second"],
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $errorMessage);
    }

    /**
     * @dataProvider provideToken
     * @param string $email
     * @param string $token
     * @param array $newPlainPassword
     * @param string $errorMessage
     */
    public function testTokenInvalid(string $email, string $token, array $newPlainPassword, string $errorMessage)
    {
        $client = static::createClient();

        $crawler = $client->request(
            Request::METHOD_GET,
            "/handle-reset-password/$email/$token"
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form([
            "recover_password[newPlainPassword][first]" => $newPlainPassword["first"],
            "recover_password[newPlainPassword][second]" => $newPlainPassword["second"],
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
            "email@email.com",
            "token",
            ["first" => "", "second" => ""],
            "This value should not be blank."
        ];

        yield [
            "email@email.com",
            "token",
            ["first" => "fail", "second" => "fail"],
            "This value is too short. It should have 8 characters or more."
        ];

        yield [
            "email@email.com",
            "token",
            ["first" => "password", "second" => "fail_password"],
            "La confirmation doit être similaire au mot de passe"
        ];
    }

    /**
     * @return Generator
     */
    public function provideToken(): Generator
    {

        yield [
            "fail",
            "token",
            ["first" => "password", "second" => "password"],
            "Participant with fail doesn't exist."
        ];

        yield [
            "used@email.com",
            "pseudo",
            ["first" => "password", "second" => "password"],
            "Invalid token."
        ];
    }
}
