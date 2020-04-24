<?php

namespace App\Tests\EndToEndTests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class VisitorTest
 * @package App\Tests\EndToEndTests
 */
class VisitorTest extends PantherTestCase
{
    public function test()
    {
        $client = static::createPantherClient();

        $crawler = $client->request(Request::METHOD_GET, '/registration');

        $form = $crawler->filter("form")->form([
            "registration[email]" => "email@email.com",
            "registration[pseudo]" => "pseudo",
            "registration[plainPassword][first]" => "password",
            "registration[plainPassword][second]" => "password"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains(
            '.FlashBag',
            'Bienvenue sur Code Challenge ! Votre inscription a été effectuée avec succès !'
        );

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $form = $crawler->filter("form")->form([
            "username" => "email@email.com",
            "password" => "password"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains(
            '.FlashBag',
            'Bon retour sur Code Challenge !'
        );
    }
}
