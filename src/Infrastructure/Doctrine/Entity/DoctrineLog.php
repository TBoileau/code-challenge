<?php

namespace App\Infrastructure\Doctrine\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

/**
 * Class DoctrineLog
 * @package App\Infrastructure\Doctrine\Entity
 * @ORM\Entity(repositoryClass="App\Infrastructure\Adapter\Repository\LogRepository")
 */
class DoctrineLog
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @var string
     * @ORM\Column
     */
    private string $method;

    /**
     * @var string
     * @ORM\Column
     */
    private string $route;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private array $routeParams;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private array $requestData;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private array $queryData;

    /**
     * @var string
     * @ORM\Column
     */
    private string $ip;

    /**
     * @var DoctrineParticipant|null
     * @ORM\ManyToOne(targetEntity="DoctrineParticipant")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?DoctrineParticipant $participant = null;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $loggedAt;

    /**
     * DoctrineLog constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * @param array $routeParams
     */
    public function setRouteParams(array $routeParams): void
    {
        $this->routeParams = $routeParams;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @param array $requestData
     */
    public function setRequestData(array $requestData): void
    {
        $this->requestData = $requestData;
    }

    /**
     * @return array
     */
    public function getQueryData(): array
    {
        return $this->queryData;
    }

    /**
     * @param array $queryData
     */
    public function setQueryData(array $queryData): void
    {
        $this->queryData = $queryData;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return DoctrineParticipant|null
     */
    public function getParticipant(): ?DoctrineParticipant
    {
        return $this->participant;
    }

    /**
     * @param DoctrineParticipant|null $participant
     */
    public function setParticipant(?DoctrineParticipant $participant): void
    {
        $this->participant = $participant;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLoggedAt(): DateTimeInterface
    {
        return $this->loggedAt;
    }

    /**
     * @param DateTimeInterface $loggedAt
     */
    public function setLoggedAt(DateTimeInterface $loggedAt): void
    {
        $this->loggedAt = $loggedAt;
    }
}
