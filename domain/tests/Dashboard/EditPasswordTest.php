<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Dashboard;

use Assert\AssertionFailedException;
use Generator;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Dashboard\Presenter\EditPasswordPresenterInterface;
use TBoileau\CodeChallenge\Domain\Dashboard\Request\EditPasswordRequest;
use TBoileau\CodeChallenge\Domain\Dashboard\Response\EditPasswordResponse;
use TBoileau\CodeChallenge\Domain\Dashboard\UseCase\EditPassword;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\LogRepository;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

class EditPasswordTest extends TestCase
{
    private EditPassword $useCase;

    private EditPasswordPresenterInterface $presenter;

    private ParticipantGateway $participantGateway;

    private Participant $participant;

    protected function setUp(): void
    {
        $this->presenter = new class () implements EditPasswordPresenterInterface {
            public ?EditPasswordResponse $response = null;

            public function present(EditPasswordResponse $response): void
            {
                $this->response = $response;
            }
        };

        $this->participantGateway = new ParticipantRepository();

        $this->useCase = new EditPassword($this->participantGateway);

        $this->participant = $this->participantGateway->getParticipantByEmail('used@email.com');
    }

    public function testSuccess(): void
    {
        $request = EditPasswordRequest::create($this->participant, 'password');

        $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(EditPasswordResponse::class, $this->presenter->response);
    }

    /**
     * @dataProvider provideFailedRequestData
     * @param string $plainPassword
     * @return void
     */
    public function testFailedRequest(string $plainPassword): void
    {
        $request = EditPasswordRequest::create($this->participant, $plainPassword);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request, $this->presenter);
    }

    public function provideFailedRequestData(): Generator
    {
        yield [''];
        yield ['fail'];
    }
}
