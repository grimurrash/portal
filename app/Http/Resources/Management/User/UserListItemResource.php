<?php

namespace App\Http\Resources\Management\User;

use App\Dto\User\UserListItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var UserListItemDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
