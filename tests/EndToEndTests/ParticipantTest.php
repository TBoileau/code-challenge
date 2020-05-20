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

        $crawler = $client->request(Request::METHOD_GET, '/questions/create');

        $client->executeScript("document.querySelector('.Collection__Add').click()");

        $client->executeScript("document.querySelector('.Collection__Add').click()");

        $form = $crawler->filter("form")->form([
            "question[title]" => "title",
            "question[answers][0][title]" => "title",
            "question[answers][0][good]" => 1,
            "question[answers][1][title]" => "title"
        ]);

        $crawler = $client->submit($form);

        $this->assertSelectorTextContains(
            '.FlashBag',
            "Votre question 'title' a été ajoutée avec succès !"
        );

        $this->assertCount(10, $crawler->filter(".Table tbody tr"));

        $crawler = $client->request(
            Request::METHOD_GET,
            $crawler->filter(".Table tbody tr td:last-child a")->attr("href")
        );

        $form = $crawler->filter("form")->form([
            "question[title]" => "1ere question",
            "question[answers][0][title]" => "title",
            "question[answers][0][good]" => 1,
            "question[answers][1][title]" => "title"
        ]);

        $client->submit($form);

        $this->assertSelectorTextContains(
            '.Table',
            "1ere question"
        );

        $client->clickLink("Déconnexion");

        $this->assertPageTitleContains('Code Challenge');
    }
}
