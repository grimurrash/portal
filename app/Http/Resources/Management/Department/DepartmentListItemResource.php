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
            'id' => $this->id,
            'name' => $this->name,
            'parent_department_id' => $this->parentDepartmentId,
            'parent_department_name' => $this->parentDepartmentName,
            'head_employee_id'=> $this->headEmployeeId,
            'head_employee_name'=> $this->headEmployeeFullName,
            'employees_count' => $this->employeeCount,
        ];
    }
}
