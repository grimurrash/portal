<?php

namespace App\Http\Resources\Management\User;

use App\Dto\User\UserListItemDto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var UserListItemDto $this */
        $arr = [];
        foreach (User::all() as $user) {
            $userDto = $user->toDto();
            $arr[] = new UserListItemDto($user->id, $user->name, $user->email, [$userDto->mainRole]);
        }
        return $arr;
    }
}
