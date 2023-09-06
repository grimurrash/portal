<?php

namespace App\Dto\OrganizationProject;

use Carbon\Carbon;

readonly class OrganizationProjectChangeLogItemDto
{
    public function __construct(
        public string  $name,
        public int     $userId,
        public string  $userName,
        public Carbon  $datetime,
        public ?string $description = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'datetime' => $this->datetime->toDateTimeString()
        ];
    }
}
