<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Service\ServiceInterface;

interface HandlerApiInterface
{
    public function getServiceClass(): string;

    public function handle(): array;

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;
}
