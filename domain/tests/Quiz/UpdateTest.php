<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Quiz;

use Assert\AssertionFailedException;
use Generator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Answer;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Presenter\UpdatePresenterInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Request\UpdateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\Response\UpdateResponse;
use TBoileau\CodeChallenge\Domain\Quiz\UseCase\Update;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\QuestionRepository;

/**
 * Class UpdateTest
 * @package TBoileau\CodeChallenge\Domain\Tests\Quiz
 */
class UpdateTest extends TestCase
{
    /**
     * @var Update
     */
    private Update $useCase;
    /**
     * @var UpdatePresenterInterface
     */
    private UpdatePresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class () implements UpdatePresenterInterface {
            public UpdateResponse $response;

            public function present(UpdateResponse $response): void
            {
                $this->response = $response;
            }
        };

        $this->useCase = new Update(new QuestionRepository());
    }

    public function testSuccessful(): void
    {
        $id = Uuid::uuid4();

        $request = UpdateRequest::create(
            $id,
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

        $this->assertInstanceOf(UpdateResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Question::class, $this->presenter->response->getQuestion());
        $this->assertEquals($id, $this->presenter->response->getQuestion()->getId());
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
        $request = new UpdateRequest(Uuid::uuid4(), $title, $answers);

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
