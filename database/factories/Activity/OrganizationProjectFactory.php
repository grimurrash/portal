<?php

namespace Database\Factories\Activity;

use App\Enums\OrganizationProject\OrganizationProjectStatusEnum;
use App\Models\Activity\OrganizationProject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrganizationProjectFactory extends Factory
{
    protected $model = OrganizationProject::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'status' => OrganizationProjectStatusEnum::CREATE->value,
            'start_date' => Carbon::now()->addDay(),
            'end_date' => Carbon::now()->addWeek(),
            'dates' => [],
            'metrics' => $this->faker->word(),
            'planned_coverage' => 10,
            'actual_coverage' => 0,
            'change_logs' => [],

            'responsible_user_id' => User::factory(),
            'curator_user_id' => User::factory(),
            'organizer_user_id' => User::factory(),
        ];
    }
}
