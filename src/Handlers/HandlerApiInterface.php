<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\Request\RequestInterface;
use App\Service\ServiceInterface;

interface HandlerApiInterface
{
    public function getServiceClass(): string;

    public function handle(?RequestInterface $request = null): array;

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;
}
