<?php

namespace App\Dto\OrganizationProject;

readonly class OrganizationProjectEventDto
{
    public function __construct(
        public string $id,
        public string $title,
        public string $startDate,
        public string $endDate,
        public string $projectId,
        public string $projectName,
    )
    {
    }
}
