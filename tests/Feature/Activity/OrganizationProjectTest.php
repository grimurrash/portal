<?php

namespace Tests\Feature\Activity;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Enums\RoleAndPermission\PermissionEnum;
use App\Enums\RoleAndPermission\RoleEnum;
use App\Models\Activity\OrganizationProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrganizationProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function testList(): void
    {
        $user = $this->authUser(role: RoleEnum::ORGANIZATION_PROJECT_ORGANIZER, permission: PermissionEnum::READ_ORGANIZATION_PROJECT);
        OrganizationProject::factory()->create([
            'organizer_user_id' => $user->id,
        ]);

        $response = $this->get(route('activity.organization-projects.list'));
        $response->assertOk();
        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
    }

    public function testGeneralList(): void
    {
        $this->authUser(permission: PermissionEnum::CONTROL_ORGANIZATION_PROJECT);
        OrganizationProject::factory()->create(['name' => 'org project #1']);
        OrganizationProject::factory()->create(['name' => 'org project']);

        $response = $this->get(route('activity.organization-projects.general-list', [
            'search' => 'project #1'
        ]));
        $response->assertOk();
        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
    }

    public function testModerateList(): void
    {
        $this->authUser(permission: PermissionEnum::UPDATE_ORGANIZATION_PROJECT);
        OrganizationProject::factory()->create(['status' => OrganizationProjectStatusEnum::MODERATION]);
        OrganizationProject::factory()->create(['status' => OrganizationProjectStatusEnum::CREATE]);
        OrganizationProject::factory()->create(['status' => OrganizationProjectStatusEnum::IN_PROCESS]);

        $response = $this->get(route('activity.organization-projects.moderate-list'));
        $response->assertOk();
        $data = $response->json();
        $this->assertCount(1, $data['items']);
        $this->assertEquals(1, $data['total_count']);
    }
}
