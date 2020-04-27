<?php

namespace App\Tests\EndToEndTests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\PantherTestCase;

/**
 * Class ParticipantTest
 * @package App\Tests\EndToEndTests
 */
class ParticipantTest extends PantherTestCase
{
    public function test()
    {
        $client = static::createPantherClient();

        $crawler = $client->request(Request::METHOD_GET, '/login');

        $form = $crawler->filter("form")->form([
            "username" => "used@email.com",
            "password" => "password"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains(
            '.FlashBag',
            'Bon retour sur Code Challenge !'
        );

        $client->clickLink("Déconnexion");
    }
}
