<?php

namespace App\Http\Resources;

use App\Dto\PaginateDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var PaginateDto $this */
        return [
            'items' => $this->getItems(),
            'total_count' => $this->getTotalCount(),
        ];
    }
}
