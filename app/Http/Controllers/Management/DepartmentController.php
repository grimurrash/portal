<?php

namespace App\Http\Controllers\Management;

use App\Contracts\Department\DepartmentServiceInterface;
use App\Dto\Department\DepartmentListFilterDto;
use App\Dto\Department\UpdateDepartmentDto;
use App\Enums\SortOrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\Department\DepartmentListRequest;
use App\Http\Requests\Management\Department\UpdateDepartmentRequest;
use App\Http\Resources\OptionItemResource;
use App\Http\Resources\PaginateResource;
use App\Models\Management\Department;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentServiceInterface $departmentService,
    )
    {
    }

    public function index(DepartmentListRequest $request): JsonResponse
    {
        $this->authorize('view', Department::class);
        $list = $this->departmentService->list(new DepartmentListFilterDto(
            search: $request->get('search'),
            parentDepartmentId: $request->get('parent_department_id'),
            perPage: $request->integer('per_page', 10),
            page: $request->integer('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        ));

        return response()->json(PaginateResource::make($list));
    }

    public function allDepartmentOptions(): JsonResponse
    {
        $list = $this->departmentService->allDepartmentOptions();
        return response()->json(OptionItemResource::collection($list));
    }

    public function parentDepartmentOptions(): JsonResponse
    {
        $list = $this->departmentService->parentDepartmentOptions();
        return response()->json(OptionItemResource::collection($list));
    }

    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
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
