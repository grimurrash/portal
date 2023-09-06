<?php

namespace App\Dto\OrganizationProject;

use Carbon\Carbon;

readonly class OrganizationProjectDateItemDto
{
    public function __construct(
        public string  $name,
        public Carbon  $datetime,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'datetime' => $this->datetime->toDateTimeString()
        ];
    }
}
