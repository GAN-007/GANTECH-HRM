<?php

namespace Database\Factories;

use App\Models\department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\department>
 */
class DepartmentFactory extends Factory
{
    protected $model = department::class;

    public function definition(): array
    {
        return [
            'department_name' => fake()->name(),
            'company_id' => 1,
            'department_head' => null,
            'is_active' => 1,
        ];
    }
}
