<?php

namespace App\Dto\User;

use App\Dto\PaginateDto;
use App\Http\Resources\Management\User\UserListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/** @property array<UserListItemDto> $items */
readonly class UserListDto extends PaginateDto
{
    public function getItems(): AnonymousResourceCollection
    {
        return UserListItemResource::collection($this->items);
    }
}
