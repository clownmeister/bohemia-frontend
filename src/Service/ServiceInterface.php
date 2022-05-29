<?php

declare(strict_types=1);

namespace App\Service;

interface ServiceInterface
{
    public function call(): array;

    public function getMethod(): string;

    public function getTarget(): string;
}
