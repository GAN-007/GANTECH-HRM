<?php


namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection,WithHeadingRow, ShouldQueue,WithChunkReading
{
	public function collection(Collection $rows)
	{

		foreach ($rows as $row)
		{
			$user = User::create([
				'username' => $row['username'],
				'email' => $row['email'],
				'password' => Hash::make($row['password']),
				'contact_no' => $row['contact_no'],
				'role_users_id'=> 2
			]);
			Employee::create([
				'id'=> $user->id,
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name'],
				'email' => $row['email'],
				'contact_no' => $row['contact_no'],
				'joining_date' => $row['date_of_joining'],
				'date_of_birth' => $row['date_of_birth'],
				'gender' => $row['gender'],
				'address' => $row['address'],
				'city' => $row['city'],
				'zip_code' => $row['zip'],
				'role_users_id'=> 2
			]);
		}

	}
	public function chunkSize(): int
	{
		return 500;
	}


}
