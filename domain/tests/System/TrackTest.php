<?php

namespace TBoileau\CodeChallenge\Domain\Tests\System;

use DateTimeInterface;
use Generator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\System\Entity\Log;
use TBoileau\CodeChallenge\Domain\System\Presenter\TrackPresenterInterface;
use TBoileau\CodeChallenge\Domain\System\Request\TrackRequest;
use TBoileau\CodeChallenge\Domain\System\Response\TrackResponse;
use TBoileau\CodeChallenge\Domain\System\UseCase\Track;
use PHPUnit\Framework\TestCase;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\LogRepository;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

/**
 * Class TrackTest
 * @package TBoileau\CodeChallenge\Domain\Tests\System
 */
class TrackTest extends TestCase
{
    /**
     * @dataProvider provideRequestData
     * @param string $method
     * @param string $route
     * @param array $routeParams
     * @param array $requestData
     * @param array $queryData
     * @param string $ip
     * @param string|null $email
     */
    public function test(
        string $method,
        string $route,
        array $routeParams,
        array $requestData,
        array $queryData,
        string $ip,
        ?string $email
    ): void {
        $request = new TrackRequest($method, $route, $routeParams, $requestData, $queryData, $ip, $email);

        $presenter = new class () implements TrackPresenterInterface {
            public TrackResponse $response;

            public function present(TrackResponse $response): void
            {
                $this->response = $response;
            }
        };

        $useCase = new Track(new ParticipantRepository(), new LogRepository());

        $useCase->execute($request, $presenter);

        $this->assertInstanceOf(TrackResponse::class, $presenter->response);

        $this->assertInstanceOf(Log::class, $presenter->response->getLog());
        $this->assertEquals($method, $presenter->response->getLog()->getMethod());
        $this->assertEquals($route, $presenter->response->getLog()->getRoute());
        $this->assertEquals($routeParams, $presenter->response->getLog()->getRouteParams());
        $this->assertEquals($requestData, $presenter->response->getLog()->getRequestData());
        $this->assertEquals($queryData, $presenter->response->getLog()->getQueryData());
        $this->assertInstanceOf(Participant::class, $presenter->response->getLog()->getParticipant());
        $this->assertInstanceOf(DateTimeInterface::class, $presenter->response->getLog()->getLoggedAt());
        $this->assertEquals($email, $presenter->response->getLog()->getParticipant()->getEmail());
        $this->assertEquals($ip, $presenter->response->getLog()->getIp());
    }

    public function provideRequestData(): Generator
    {
        yield [Request::METHOD_GET, "home", [], [], ["page" => 1], "127.0.0.1", "used@email.com"];
        yield [
            Request::METHOD_POST,
            "registration",
            [],
            [
                "registration" => [
                    "email" => "email@email.com",
                    "pseudo" => "pseudo",
                    "plainPassword" => [
                        "first" => "password",
                        "second" => "password"
                    ]
                ]
            ],
            [],
            "127.0.0.1",
            "used@email.com"
        ];
    }
}
