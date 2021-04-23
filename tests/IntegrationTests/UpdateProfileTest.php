<?php

declare(strict_types=1);

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Adapter\Repository\ParticipantRepository;
use App\Infrastructure\Security\User;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfileTest extends WebTestCase
{
    public function testSuccessful(): void
    {
        $client = self::createClient();

        $testUser = static::$container->get(ParticipantRepository::class)
          ->getParticipantByEmail('used@email.com');
        $user = new User($testUser);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, 'profile/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            "participant[email]" => "email@email.com",
            "participant[pseudo]" => "pseudo",
            "participant[avatarPath]" => new UploadedFile(__DIR__ . '/avatars/logo.png', 'logo.png'),
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    /**
     * @dataProvider providerValidationData
     *
     * @param string $email
     * @param string $pseudo
     * @param string|null $avatar
     * @param string $errorMessage
     */
    public function testFailed(string $email, string $pseudo, $avatar, string $errorMessage): void
    {
        $client = self::createClient();

        $testUser = static::$container->get(ParticipantRepository::class)
            ->getParticipantByEmail('used@email.com');

        $user = new User($testUser);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, 'profile/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            "participant[email]" => $email,
            "participant[pseudo]" => $pseudo,
            "participant[avatarPath]" => $avatar,
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $errorMessage);
    }

    public function testAccessThisPageWithoutLogged(): void
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, 'profile/edit');

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function providerValidationData(): Generator
    {
        yield [
          "",
          "pseudo",
          "avatar.jpg",
          "This value should not be blank."
        ];

        yield [
          "fail",
          "pseudo",
          "avatar.jpg",
          "This value is not a valid email address."
        ];

        yield [
          "used@email.com",
          "",
          "",
          "This value should not be blank."
        ];

        yield [
          "used@email.com",
          "pseudo",
          new UploadedFile(__DIR__ . '/empty.txt', 'empty.txt'),
          "An empty file is not allowed."
        ];

        yield [
          "used@email.com",
          "pseudo",
          new UploadedFile(__DIR__ . '/fail.txt', 'fail.txt'),
          "Please upload a valid image."
        ];
    }
}
