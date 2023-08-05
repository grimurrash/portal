<?php

namespace Tests\Feature\Management;


use App\Enums\RoleAndPermission\PermissionEnum;
use App\Models\Management\Department;
use App\Models\Management\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use DatabaseTransactions;

    public function testParentDepartmentOptions(): void
    {
        $this->authUser(permission: PermissionEnum::READ_DEPARTMENT);
        $response = $this->get(route('management.departments.parent-department-options'));
        $response->assertOk();
    }

    public function testAllDepartmentOptions(): void
    {
        $this->authUser(permission: PermissionEnum::READ_DEPARTMENT);
        $response = $this->get(route('management.departments.all-department-options'));
        $response->assertOk();
    }

    public function testList(): void
    {
        $this->authUser(permission: PermissionEnum::READ_DEPARTMENT);

        $dep1 = Department::factory()->create(['name' => 'department1']);
        Department::factory()->create(['name' => 'department2', 'parent_department_id' => $dep1->id]);
        $filter = [
            'search' => 'dep',
        ];

        $response = $this->get(route('management.departments.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(2, $data['items']);
        $this->assertEquals(2, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);

        $filter = [
            'parent_department_id' => $dep1->id,
        ];

        $response = $this->get(route('management.departments.list', $filter));

        $response->assertOk();

        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
        $this->assertEquals(1, $data['last_page']);
    }

    public function testUpdate(): void
    {
        $this->authUser(permission: PermissionEnum::UPDATE_DEPARTMENT);

        $dep1 = Department::factory()->create(['name' => 'department1']);
        $dep2 = Department::factory()->create(['name' => 'department2']);

        $employee = Employee::factory()->create(['department_id' => $dep1->id]);
        $updateData = [
            'name' => 'department11',
            'parent_department_id' => $dep2->id,
            'head_employee_id' => $employee->id
        ];
        $response = $this->put(route('management.departments.update', ['id' => $dep1->id]), $updateData);
        $response->assertOk();

        $dep1->refresh();
        $this->assertEquals($updateData['name'], $dep1->name);
        $this->assertEquals($updateData['parent_department_id'], $dep1->parent_department_id);
        $this->assertEquals($updateData['head_employee_id'], $dep1->head_employee_id);
    }

    public function testDelete(): void
    {
        $this->authUser(permission: PermissionEnum::DELETE_DEPARTMENT);

        $dep1 = Department::factory()->create(['name' => 'department1']);

        $response = $this->delete(route('management.departments.delete', ['id' => $dep1->id]));
        $response->assertOk();

        $dep1 = Department::query()->where('id', $dep1)->first();
        $this->assertNull($dep1);
    }
}
