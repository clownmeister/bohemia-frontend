<?php

declare(strict_types=1);

namespace App\Dto\Request;

final class GetPostsRequest extends AbstractRequest
{
    use PagingTrait;

    public function jsonSerialize(): mixed
    {
        return [
            'page' => $this->getPage(),
            'pageSize' => $this->getPageSize()
        ];
    }
}
