<?php

namespace Database\Seeders;

use App\Models\Role_User;
use Illuminate\Database\Seeder;

class Role_UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//

		Role_User::insert([[


				'role_name' => 'admin'
			], [

				'role_name' => 'employee'
			],
				['role_name' => 'client'
				],
				['role_name' => 'employer'
		]
			]
		);
	}

}
