<?php

namespace App\Http\Controllers\Management;

use App\Contracts\Department\DepartmentServiceInterface;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentServiceInterface $departmentService,
    )
    {
    }

    public function index(): JsonResponse
    {
        $this->authorize('view', Department::class);
        $list = $this->departmentService->list(new DepartmentListFilterDto(
            null,
            null,
            10,
            1,
            'id',
            true
        ));

        return response()->json(PaginateResource::make($list));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->authorize('update', Department::class);
        $this->departmentService->update(new UpdateDepartmentDto(
            id: $id,
            name: $request->get('name'),
            parentDepartmentId: $request->get('parent_department_id'),
            headEmployeeId: $request->get('head_employee_id'),
        ));

        return response()->json();
    }

    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', Department::class);
        $this->departmentService->delete($id);
        return response()->json();
    }
}
