<?php

namespace TBoileau\CodeChallenge\Domain\System\Request;

use Ramsey\Uuid\UuidInterface;

/**
 * Class TrackRequest
 * @package TBoileau\CodeChallenge\Domain\System\Request
 */
class TrackRequest
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
     * @var string|null
     */
    private ?string $email;

    /**
     * Log constructor.
     * @param string $method
     * @param string $route
     * @param array $routeParams
     * @param array $requestData
     * @param array $queryData
     * @param string $ip
     * @param string|null $email
     */
    public function __construct(
        string $method,
        string $route,
        array $routeParams,
        array $requestData,
        array $queryData,
        string $ip,
        ?string $email
    ) {
        $this->method = $method;
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->requestData = $requestData;
        $this->queryData = $queryData;
        $this->ip = $ip;
        $this->email = $email;
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
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
