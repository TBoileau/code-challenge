<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Quiz;

use Assert\AssertionFailedException;
use Generator;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\CreatePresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Request\CreateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Response\CreateResponse;
use TBoileau\CodeChallenge\Domain\Quiz\UseCase\Create;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\QuestionRepository;

/**
 * Class CreateTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Quiz
 */
class CreateTest extends TestCase
{
    /**
     * @var Create
     */
    private Create $useCase;
    /**
     * @var CreatePresenterInterface
     */
    private CreatePresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class () implements CreatePresenterInterface {
            public CreateResponse $response;

            public function present(CreateResponse $response): void
            {
                $this->response = $response;
            }
        };

        $this->useCase = new Create(new QuestionRepository());
    }

    public function testSuccessful(): void
    {
        $request = CreateRequest::create(
            "title",
            [
                [
                    "title" => "answer 1",
                    "good" => true
                ],
                [
                    "title" => "answer 2",
                    "good" => false
                ],
                [
                    "title" => "answer 3",
                    "good" => true
                ]
            ]
        );

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(CreateResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Question::class, $this->presenter->response->getQuestion());
        $this->assertInstanceOf(UuidInterface::class, $this->presenter->response->getQuestion()->getId());
        $this->assertEquals("title", $this->presenter->response->getQuestion()->getTitle());
        $this->assertCount(3, $this->presenter->response->getQuestion()->getAnswers());
        $this->assertContainsOnlyInstancesOf(
            Answer::class,
            $this->presenter->response->getQuestion()->getAnswers()
        );
        $this->assertEquals(
            ["answer 1", "answer 2", "answer 3"],
            array_map(
                fn (Answer $answer) => $answer->getTitle(),
                $this->presenter->response->getQuestion()->getAnswers()
            )
        );
        $this->assertContainsOnlyInstancesOf(
            UuidInterface::class,
            array_map(fn (Answer $answer) => $answer->getId(), $this->presenter->response->getQuestion()->getAnswers())
        );
        $this->assertCount(
            2,
            array_filter(
                $this->presenter->response->getQuestion()->getAnswers(),
                fn (Answer $answer) => $answer->isGood()
            )
        );
    }

    /**
     * @dataProvider provideFailedData
     * @param string $title
     * @param array $answers
     */
    public function testFailed(string $title, array $answers)
    {
        $request = new CreateRequest($title, $answers);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    /**
     * @return Generator
     */
    public function provideFailedData(): Generator
    {
        yield [
            "",
            [
                [
                    "title" => "answer 1",
                    "good" => true
                ],
                [
                    "title" => "answer 2",
                    "good" => false
                ],
                [
                    "title" => "answer 3",
                    "good" => true
                ]
            ]
        ];
        yield [
            "title",
            [
                [
                    "title" => "",
                    "good" => true
                ],
                [
                    "title" => "answer 2",
                    "good" => false
                ],
                [
                    "title" => "answer 3",
                    "good" => true
                ]
            ]
        ];
        yield [
            "title",
            [
                [
                    "title" => "answer 1",
                    "good" => true
                ]
            ]
        ];
        yield [
            "title",
            [
                [
                    "title" => "answer 1",
                    "good" => false
                ],
                [
                    "title" => "answer 2",
                    "good" => false
                ],
                [
                    "title" => "answer 3",
                    "good" => false
                ]
            ]
        ];
        yield [
            "title",
            [
                [
                    "title" => "answer 1",
                    "good" => ""
                ],
                [
                    "title" => "answer 2",
                    "good" => false
                ],
                [
                    "title" => "answer 3",
                    "good" => false
                ]
            ]
        ];

        yield ["title", []];
    }
}
