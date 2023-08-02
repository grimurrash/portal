<?php

namespace Database\Factories;

use App\Enums\Employee\GenderEnum;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'export_number' => 0,
            'full_name' => $this->faker->name(),
            'department_id' => Department::factory(),
            'phone' => $this->faker->phoneNumber(),
            'work_position' => $this->faker->word(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(GenderEnum::cases()),
            'work_start_date' => Carbon::now()->subMonths(3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
