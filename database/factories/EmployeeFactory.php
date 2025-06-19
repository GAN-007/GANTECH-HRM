<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\Models\company;
use App\Models\department;
use App\Models\designation;
use App\Models\Employee;
use App\Model;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [

		'first_name'=> $faker->name,
		'last_name'=> $faker->name,
		'email' => $faker->unique()->safeEmail,
		'contact_no' => $faker->phoneNumber,
		'date_of_birth' => $faker->dateTimeBetween('1990-01-01', '2002-12-31')
			->format('d/m/Y'),
		'gender' => $faker->randomElement(['Male', 'Female']),
		'company_id' => company::all()->random()->id,
		'department_id' => department::all()->random()->id,
		'designation_id' => designation::all()->random()->id

    ];
});
