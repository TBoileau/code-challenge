<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\LoginTrait;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Request;

class EditPasswordTest extends IntegrationTestCase
{
    use LoginTrait;

    private AbstractBrowser $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSuccessful(): void
    {
        // $this->logIn();

        // $crawler = $this->client->request(Request::METHOD_GET, '/dashboard/edit-password');

        // $this->assertResponseIsSuccessful();

        // $form = $crawler->filter('form')->form([
        //     'edit_password[plainPassword][first]' => 'password',
        //     'edit_password[plainPassword][second]' => 'password'
        // ]);

        // $this->logIn();

        // $this->client->submit($form);

        // $this->assertResponseIsSuccessful();
    }

    
}
