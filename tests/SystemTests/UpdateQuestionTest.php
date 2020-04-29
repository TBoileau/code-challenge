<?php

namespace App\Tests\SystemTests;

use App\Infrastructure\Doctrine\Entity\DoctrineQuestion;
use App\Infrastructure\Test\IntegrationTestCase;
use Generator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateQuestionTest
 * @package App\Tests\SystemTests
 */
class UpdateQuestionTest extends WebTestCase
{
    public function testSuccessful()
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine.orm.entity_manager");

        $question = $em->getRepository(DoctrineQuestion::class)->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            sprintf('/questions/%s/update', $question->getid())
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form();

        $token = $form->get("question")["_token"]->getValue();

        $client->request(Request::METHOD_POST, sprintf('/questions/%s/update', $question->getid()), [
            "question" => [
                "_token" => $token,
                "title" => "title",
                "answers" => [
                    [
                        "good" => true,
                        "title" => "title"
                    ],
                    [
                        "good" => false,
                        "title" => "title"
                    ]
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    /**
     * @dataProvider provideFailedData
     * @param array $formData
     * @param string $errorMessage
     */
    public function testFailedData(array $formData, string $errorMessage)
    {
        $client = static::createClient();

        $em = $client->getContainer()->get("doctrine.orm.entity_manager");

        $question = $em->getRepository(DoctrineQuestion::class)->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            sprintf('/questions/%s/update', $question->getid())
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter("form")->form();

        $token = $form->get("question")["_token"]->getValue();

        $formData["_token"] = $token;

        $client->request(Request::METHOD_POST, sprintf('/questions/%s/update', $question->getid()), [
            "question" => $formData
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorTextContains('html', $errorMessage);
    }

    /**
     * @return Generator
     */
    public function provideFailedData(): Generator
    {
        yield [
            [
                "title" => "",
                "answers" => [
                    [
                        "good" => true,
                        "title" => "title"
                    ],
                    [
                        "good" => false,
                        "title" => "title"
                    ]
                ]
            ],
            "This value should not be blank."
        ];

        yield [
            [
                "title" => "title",
                "answers" => [
                    [
                        "good" => true,
                        "title" => ""
                    ],
                    [
                        "good" => false,
                        "title" => "title"
                    ]
                ]
            ],
            "This value should not be blank."
        ];

        yield [
            [
                "title" => "title",
                "answers" => [
                    [
                        "good" => true,
                        "title" => "title"
                    ]
                ]
            ],
            "This collection should contain 2 elements or more."
        ];

        yield [
            [
                "title" => "title",
                "answers" => [
                    [
                        "good" => false,
                        "title" => "title"
                    ],
                    [
                        "good" => false,
                        "title" => "title"
                    ]
                ]
            ],
            "Vous devez sélectionner au moins une bonne réponse."
        ];
    }
}
