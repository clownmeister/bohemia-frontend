<?php

declare(strict_types=1);


namespace App\Handlers;

use App\Service\GetPostsService;

final class GetPostsHandler extends AbstractApiHandler
{
    protected string $serviceClass = GetPostsService::class;
}
