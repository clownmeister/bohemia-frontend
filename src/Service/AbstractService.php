<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

abstract class AbstractService implements ServiceInterface
{
    protected const METHOD_GET = 'GET';
    protected const METHOD_POST = 'POST';
    protected const METHOD_PATCH = 'PATCH';
    protected const METHOD_PUT = 'PUT';
    protected const METHOD_DELETE = 'DELETE';
    protected const METHOD_HEAD = 'HEAD';

    protected string $method;
    protected string $target;

    public function __construct(private Client $client)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function call(): array
    {
        return json_decode(
            $this->client->request($this->getMethod(), $this->getTarget())->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getTarget(): string
    {
        return $this->target;
    }
}
