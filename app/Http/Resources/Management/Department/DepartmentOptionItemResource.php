<?php

namespace App\Http\Resources\Management\Department;

use App\Dto\Department\DepartmentOptionItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentOptionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var DepartmentOptionItemDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
