<?php

namespace App\Http\Resources\Management\Employee;

use App\Dto\Employee\EmployeeOptionItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeOptionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var EmployeeOptionItemDto $this */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
