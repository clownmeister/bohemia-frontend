<?php

declare(strict_types=1);

namespace App\Service;

final class GetPostService extends AbstractService
{
    protected string $method = self::METHOD_POST;
    protected string $target = '/api/v1/post';
}
