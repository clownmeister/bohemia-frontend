<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\Request\RequestInterface;
use App\Service\ServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

interface HandlerApiInterface
{
    public function getServiceClass(): string;

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(?RequestInterface $request = null): array;

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;
}
