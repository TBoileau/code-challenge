<?php

namespace App\Tests;

use App\Infrastructure\Security\User;
use Symfony\Component\BrowserKit\Cookie;
use App\Infrastructure\Test\Adapter\Repository\ParticipantRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Trait LoginTrait
 * @package App\Tests
 */
trait LoginTrait
{
    /**
     * @return void
     */
    private function logIn()
    {
        $session = self::$container->get('session');

        $user = new User(self::$container->get(ParticipantRepository::class)->getParticipantByEmail('used@email.com'));

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, null, $firewallName, ['ROLE_USER']);
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
