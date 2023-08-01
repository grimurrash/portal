<?php

namespace App\Http\Resources\Permission;

use App\Enums\PermissionEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property PermissionEnum $resource */
class AbilitiesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'action' => $this->resource->getAction(),
            'subject' => $this->resource->getSubject()
        ];
    }
}
