<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\RequestInterface;

interface ServiceInterface
{
    public function call(?RequestInterface $request = null): array;

    public function getMethod(): string;

    public function getTarget(): string;

    public function getContentType(): string;
}
