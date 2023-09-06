<?php

namespace App\Http\Controllers\Management;

use App\Contracts\Employee\EmployeeServiceInterface;
use App\Dto\Employee\EmployeeListFilterDto;
use App\Enums\Employee\GenderEnum;
use App\Enums\SortOrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\Employee\EmployeeListRequest;
use App\Http\Requests\Management\Employee\EmployeeOptionsByDepartmentRequest;
use App\Http\Requests\Management\Employee\ImportEmployeeRequest;
use App\Http\Resources\OptionItemResource;
use App\Http\Resources\PaginateResource;
use App\Models\Management\Employee;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly EmployeeServiceInterface $employeeService,
    )
    {
    }

    public function import(ImportEmployeeRequest $request): JsonResponse
    {
        $this->authorize('import', Employee::class);
        $this->employeeService->createImport(
            file: $request->file('file'),
            sheetName: $request->get('sheet_name', 'Модуль "КО"')
        );
        return response()->json();
    }

    public function list(EmployeeListRequest $request): JsonResponse
    {
        $this->authorize('view', Employee::class);

        $list = $this->employeeService->list(new EmployeeListFilterDto(
            search: $request->get('search'),
            departmentId: $request->get('department_id'),
            gender: GenderEnum::tryFrom($request->get('gender')),
            isFoundersRepresentative: $request->has('is_founders_representative') ? $request->boolean('is_founders_representative') : null,
            ageFrom: $request->get('age_from'),
            ageTo: $request->get('age_to'),
            educationLevel: $request->get('education_level'),
            perPage: $request->integer('per_page', 10),
            page: $request->integer('page', 1),
            sortColumn: $request->get('sort_column', 'id'),
            sortOrder: SortOrderEnum::from($request->get('sort_order', SortOrderEnum::DESC->value))
        ));

        return response()->json(PaginateResource::make($list));
    }

    public function optionsByDepartment(EmployeeOptionsByDepartmentRequest $request): JsonResponse
    {
        $list = $this->employeeService->optionsByDepartment($request->get('department_id'));
        return response()->json(OptionItemResource::collection($list));
    }
}
