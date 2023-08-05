<?php

namespace App\Contracts\Employee;

use App\Dto\Employee\EmployeeListDto;
use App\Dto\Employee\EmployeeListFilterDto;
use Illuminate\Http\UploadedFile;

interface EmployeeServiceInterface
{
    public function createImport(UploadedFile $file, string $sheetName): void;

    public function import(string $fileName, string $sheetName): void;

    public function list(EmployeeListFilterDto $filter): EmployeeListDto;

    public function optionsByDepartment(int $departmentId): array;

}
