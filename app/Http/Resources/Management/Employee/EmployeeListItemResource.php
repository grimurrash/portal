<?php

namespace App\Http\Resources\Management\Employee;

use App\Dto\Employee\EmployeeListItemDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var EmployeeListItemDto $this */
        return [
            'full_name' => $this->fullName,
            'department_id' => $this->departmentId,
            'work_position' => $this->workPosition,
            'date_of_birth' => $this->dateOfBirth,
            'export_number' => $this->exportNumber,
            'work_email' => $this->workEmail,
            'work_phone' => $this->workPhone,
            'gender' => $this->gender->value,
            'phone' => $this->phone,
            'work_address' => $this->workAddress,
            'work_room_number' => $this->workRoomNumber,
            'work_start_date' => $this->workStartDate,
            'work_end_date' => $this->workEndDate,
        ];
    }
}
