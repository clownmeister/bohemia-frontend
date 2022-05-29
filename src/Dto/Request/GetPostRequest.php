<?php

declare(strict_types=1);

namespace App\Dto\Request;

final class GetPostRequest extends AbstractRequest
{
    public function __construct(
        private string $slug
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'slug' => $this->getSlug()
        ];
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
