<?php

namespace App\Dto\Employee;

use App\Enums\Employee\GenderEnum;
use Carbon\Carbon;

readonly class EmployeeListItemDto
{
    public function __construct(
        public int          $id,
        public int          $exportNumber,
        public string       $fullName,
        public int          $departmentId,
        public string       $departmentName,
        public string|null  $phone,
        public string|null  $workEmail,
        public string|null  $workPhone,
        public string|null  $workAddress,
        public string|null  $workRoomNumber,
        public string       $workPosition,
        public Carbon       $dateOfBirth,
        public GenderEnum   $gender,
        public Carbon|null  $workStartDate,
        public Carbon|null  $workEndDate,
    )
    {
    }
}
