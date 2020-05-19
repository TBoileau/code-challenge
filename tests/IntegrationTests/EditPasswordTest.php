<?php

namespace App\Tests\IntegrationTests;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\LoginTrait;
use Symfony\Component\BrowserKit\AbstractBrowser;

/**
 * Class EditPasswordTest
 * @package App\Tests\IntegrationTests
 */
class EditPasswordTest extends IntegrationTestCase
{
    use LoginTrait;

    /**
     * @var AbstractBrowser
     */
    private AbstractBrowser $client;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @return void
     */
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
