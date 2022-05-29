<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\RequestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use JsonException;

abstract class AbstractService implements ServiceInterface
{
    protected const METHOD_GET = 'GET';
    protected const METHOD_POST = 'POST';
    protected const METHOD_PATCH = 'PATCH';
    protected const METHOD_PUT = 'PUT';
    protected const METHOD_DELETE = 'DELETE';

    protected const TYPE_JSON = 'application/json';
    protected const TYPE_FORM = 'application/x-www-form-urlencoded';

    protected string $method;
    protected string $target;
    protected string $contentType;

    public function __construct(private Client $client)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function call(?RequestInterface $request = null): array
    {
        $options = [
            'headers' =>
                [
                    'Content-Type' => $this->getContentType(),
                ],
        ];


        if ($request !== null) {
            $options = array_merge($options, $this->getData($request));
        }

        return json_decode(
            $this->client->request(
                $this->getMethod(),
                $this->getTarget(),
                $options
            )->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType ?? self::TYPE_JSON;
    }

    /**
     * @param RequestInterface $request
     *
     * @return mixed[]
     * @throws JsonException
     */
    private function getData(RequestInterface $request): array
    {
        return [
            RequestOptions::BODY => json_encode(
                $request,
                JSON_NUMERIC_CHECK | JSON_THROW_ON_ERROR
            )
        ];
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
