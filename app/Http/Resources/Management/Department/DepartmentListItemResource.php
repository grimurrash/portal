<?php

namespace App\Http\Resources\Management\Department;

use App\Dto\Department\DepartmentListItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var DepartmentListItemDto $this */
        return [

        ];
    }
}
