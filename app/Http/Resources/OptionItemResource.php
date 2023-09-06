<?php

namespace App\Http\Resources;

use App\Dto\OptionItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var OptionItemDto $this */
        return [
            'id' => $this->id,
            'label' => $this->label
        ];
    }
}
