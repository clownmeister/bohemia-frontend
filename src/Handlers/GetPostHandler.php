<?php

declare(strict_types=1);


namespace App\Handlers;

use App\Service\GetPostService;

final class GetPostHandler extends AbstractApiHandler
{
    protected string $serviceClass = GetPostService::class;
}
