<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();

        $roles = array(
			array(
				'id' => 1,
				'name' => 'admin',
				'guard_name' => 'web',
				'description' => 'Can access and change everything',
				'is_active' => 1
            ),
			array(
				'id' => 2,
				'name' => 'employee',
				'guard_name' => 'web',
				'description' => 'Default access',
				'is_active' => 1
            ),
			array(
				'id' => 3,
				'name' => 'client',
				'guard_name' => 'web',
				'description' => 'When you create a client, this role and associated.',
				'is_active' => 1
            )
        );

		DB::table('roles')->insert($roles);
    }
}
