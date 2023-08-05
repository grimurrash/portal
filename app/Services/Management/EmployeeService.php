<?php

namespace App\Services\Management;

use App\Contracts\Department\DepartmentRepositoryInterface;
use App\Contracts\Employee\EmployeeRepositoryInterface;
use App\Contracts\Employee\EmployeeServiceInterface;
use App\Dto\Employee\EmployeeListDto;
use App\Dto\Employee\EmployeeListFilterDto;
use App\Dto\Employee\ImportEmployeeDto;
use App\Jobs\ImportEmployeesJob;
use App\Support\Helper\CsvHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Exception;
use Throwable;

readonly class EmployeeService implements EmployeeServiceInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private DepartmentRepositoryInterface $departmentRepository,
    )
    {
    }

    public function createImport(UploadedFile $file, string $sheetName): void
    {
        $randomKey = Str::random();
        $fileName = "import_employees_$randomKey.{$file->getClientOriginalExtension()}";
        Storage::disk('temp')->put($fileName, file_get_contents($file->getRealPath()));

        dispatch(new ImportEmployeesJob($fileName, $sheetName));
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Calculation\Exception
     */
    public function import(string $fileName, string $sheetName): void
    {
        $filePath = Storage::disk('temp')->path($fileName);

        $exportList = CsvHelper::readCsv($filePath, $sheetName);

        $employees = $this->employeeRepository->getImportList();
        $departments = $this->departmentRepository->getImportList();
        $createList = [];
        $exceptionList = [];

        foreach ($exportList as $exportItem)
        {
            try {
                if (!is_numeric($exportItem['A'])) {
                    continue;
                }
                $isNewDepartment = false;
                $employee = $employees->where('exportNumber', $exportItem['A'])->first();
                $department = $departments->where('name', $exportItem['F'])->first();

                if (is_null($department)) {
                    $department = $this->departmentRepository->create($exportItem['F']);
                    $isNewDepartment = true;
                }

                $exportEmployee = ImportEmployeeDto::selfByArray($exportItem, $department->id);

                if (is_null($employee)) {
                    $createList[] = $exportEmployee;
                    continue;
                }

                if ($isNewDepartment || !empty(array_diff($employee->toArray(), $exportEmployee->toArray()))) {
                    $this->employeeRepository->update($exportEmployee);
                }
            }catch (Throwable $exception) {
                $exceptionList[] = $exception;
            }
        }

        if (!empty($createList)) {
            $this->employeeRepository->massCreate($createList);
        }


        if (!empty($exceptionList)) {
            throw array_shift($exceptionList);
        }

        Storage::disk('temp')->delete($fileName);
    }

    public function list(EmployeeListFilterDto $filter): EmployeeListDto
    {
        return $this->employeeRepository->list($filter);
    }

    public function optionsByDepartment(int $departmentId): array
    {
        return $this->employeeRepository->optionsByDepartment($departmentId);
    }
}
