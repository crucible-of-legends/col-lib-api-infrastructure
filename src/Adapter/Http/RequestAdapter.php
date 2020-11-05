<?php

namespace COL\Library\Infrastructure\Adapter\Http;

use Symfony\Component\HttpFoundation\Request;

final class RequestAdapter
{
    private string $method; # read only
    private array $headers;
    private array $queryParameters;
    private array $bodyParameters;

    public function __construct(Request $request)
    {
        $this->method = $request->getMethod();
        $this->headers = $request->headers->all();
        $this->queryParameters = $request->query->all();
        $this->bodyParameters = $request->request->all();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    public function setQueryParameters(array $queryParameters): void
    {
        $this->queryParameters = $queryParameters;
    }

    public function getBodyParameters(): array
    {
        return $this->bodyParameters;
    }

    public function setBodyParameters(array $bodyParameters): void
    {
        $this->bodyParameters = $bodyParameters;
    }
}