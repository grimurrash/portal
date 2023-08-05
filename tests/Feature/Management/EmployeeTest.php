<?php

namespace Tests\Feature\Management;

use App\Enums\Employee\GenderEnum;
use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\Management\Department;
use App\Models\Management\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;

    public function testImport(): void
    {
        $this->authUser(permission: PermissionEnum::IMPORT_EMPLOYEE);

        $file = new UploadedFile(
            base_path('tests/Mock/test_import_employee_table.xlsx'),
            'employees.xlsx',
            'application/vnd.ms-excel',
            null,
            true
        );
        $response = $this->post(route('management.employees.import'), [
            'file' => $file,
            'sheet_name' => 'Модуль "КО"'
        ]);
        $response->assertOk();

        $response = $this->post(route('management.employees.import'), [
            'file' => $file,
            'sheet_name' => 'Модуль "КО"'
        ]);
        $response->assertOk();
    }

    public function testList(): void
    {
        $this->authUser(permission: PermissionEnum::READ_EMPLOYEE);

        $dep1 = Department::factory()->create();

        Employee::factory()->create([
            'full_name' => 'employee1',
            'education_level' => 'Высшее образование',
            'gender' => GenderEnum::FEMALE,
            'date_of_birth' => Carbon::now()->subYears(27)->startOfDay()
        ]);
        Employee::factory()->create([
            'full_name' => 'employee2',
            'department_id' => $dep1->id,
            'gender' => GenderEnum::FEMALE
        ]);
        Employee::factory()->create([
            'full_name' => 'employee3',
            'gender' => GenderEnum::MALE,
            'advanced_training_courses_for_founders_representatives_date' => Carbon::now()
        ]);
        $filter = [
            'search' => 'emp',
            'per_page' => 2,
        ];
        $response = $this->get(route('management.employees.list', $filter));
        $response->assertOk();

        $data = $response->json();
        $this->assertCount(2, $data['items']);
        $this->assertEquals(3, $data['total_count']);
        $this->assertEquals(2, $data['last_page']);

        $filter = [
            'search' => 'emp',
            'department_id' => $dep1->id,
        ];

        $response = $this->get(route('management.employees.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);

        $filter = [
            'search' => 'emp',
            'is_founders_representative' => true,
        ];

        $response = $this->get(route('management.employees.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);

        $filter = [
            'search' => 'emp',
            'age_from' => 25,
        ];

        $response = $this->get(route('management.employees.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);

        $filter = [
            'search' => 'emp',
            'age_to' => 25,
        ];

        $response = $this->get(route('management.employees.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(2, $data['items']);
        $this->assertEquals(2, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);

        $filter = [
            'search' => 'emp',
            'education_level' => 'высшее образование',
        ];

        $response = $this->get(route('management.employees.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);
    }


    public function testOptionsByDepartment(): void
    {
        $this->authUser(permission: PermissionEnum::READ_EMPLOYEE);
        $dep = Department::factory()->create();
        Employee::factory(2)->create(['department_id' => $dep->id]);
        $response = $this->get(route('management.employees.options-by-department', ['department_id' =>$dep->id]));
        $response->assertOk();
        $this->assertCount(2, $response->json());
    }
}
