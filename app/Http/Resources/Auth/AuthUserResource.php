<?php

namespace App\Http\Resources\Auth;

use App\Dto\Auth\UserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var UserDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->maneRole->value,
        ];
    }
}
