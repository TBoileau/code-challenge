<?php

namespace TBoileau\CodeChallenge\Domain\System\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\System\Request\TrackRequest;

/**
 * Class Log
 * @package TBoileau\CodeChallenge\Domain\System\Entity
 */
class Log
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $route;

    /**
     * @var array
     */
    private array $routeParams;

    /**
     * @var array
     */
    private array $requestData;

    /**
     * @var array
     */
    private array $queryData;

    /**
     * @var string
     */
    private string $ip;

    /**
     * @var Participant|null
     */
    private ?Participant $participant;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $loggedAt;

    /**
     * @param TrackRequest $trackRequest
     * @param Participant|null $participant
     * @return static
     */
    public static function fromTrack(TrackRequest $trackRequest, ?Participant $participant): self
    {
        return new self(
            $trackRequest->getMethod(),
            $trackRequest->getRoute(),
            $trackRequest->getRouteParams(),
            $trackRequest->getRequestData(),
            $trackRequest->getQueryData(),
            $trackRequest->getIp(),
            $participant
        );
    }

    /**
     * Log constructor.
     * @param string $method
     * @param string $route
     * @param array $routeParams
     * @param array $requestData
     * @param array $queryData
     * @param string $ip
     * @param Participant|null $participant
     */
    public function __construct(
        string $method,
        string $route,
        array $routeParams,
        array $requestData,
        array $queryData,
        string $ip,
        ?Participant $participant
    ) {
        $this->method = $method;
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->requestData = $requestData;
        $this->queryData = $queryData;
        $this->ip = $ip;
        $this->participant = $participant;
        $this->loggedAt = new DateTimeImmutable();
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @return array
     */
    public function getQueryData(): array
    {
        return $this->queryData;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return Participant|null
     */
    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLoggedAt(): DateTimeInterface
    {
        return $this->loggedAt;
    }
}
