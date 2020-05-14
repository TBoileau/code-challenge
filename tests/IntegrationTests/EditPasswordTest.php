<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Security\Provider\UserProvider;
use App\Infrastructure\Security\User;
use App\Infrastructure\Test\Adapter\Repository\ParticipantRepository;
use App\Infrastructure\Test\IntegrationTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EditPasswordTest extends IntegrationTestCase
{
    private AbstractBrowser $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    // public function testSuccessful(): void
    // {
    //     $this->logIn();

    //     $crawler = $this->client->request(Request::METHOD_GET, '/dashboard');

    //     $this->assertResponseIsSuccessful();

    //     $form = $crawler->filter('form')->form([
    //         'edit_password[plainPassword][first]' => 'password',
    //         'edit_password[plainPassword][second]' => 'password'
    //     ]);

    //     $this->client->submit($form);

    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    // }

    private function logIn()
    {
        $session = self::$container->get('session');

        $user = new User(self::$container->get(ParticipantRepository::class)->getParticipantByEmail('used@email.com'));

        $firewallName = 'secure_area';
        $firewallContext = 'secured_area';

        $token = new UsernamePasswordToken($user, null, $firewallName);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}