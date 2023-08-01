<?php

namespace App\Http\Resources\Auth;

use App\Dto\Auth\LoggedUserDto;
use App\Http\Resources\Permission\AbilitiesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggedUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var LoggedUserDto $this */
        return [
            'user' => AuthUserResource::make($this->user),
            'abilities' => AbilitiesResource::collection($this->user->permissions),
            'token' => $this->token,
            'token_expired_at' => $this->tokenExpiredAt->getTimestampMs()
        ];
    }
}
