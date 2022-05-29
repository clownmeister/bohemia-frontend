<?php

declare(strict_types=1);

namespace App\Service;

final class GetPostsService extends AbstractService
{
    protected string $method = self::METHOD_GET;
    protected string $target = '/api/v1/posts';
}
