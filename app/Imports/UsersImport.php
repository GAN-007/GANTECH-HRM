<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use App\Models\company;
use App\Models\department;
use App\Models\designation;
use App\Models\Country;
use App\Models\office_shift;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel,WithHeadingRow, ShouldQueue,WithChunkReading,WithBatchInserts, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	use Importable;

    public function model(array $row)
	{
        $comapny_name     =  $row['company_name'];
        $department_name  =  $row['department_name'];
        $designation_name =  $row['designation_name'];
        $shift_name       =  $row['shift_name'];
        $role_name        =  $row['role_name'];
        $country_name     =  $row['country_name'];

        $company = company::where('company_name',$comapny_name)->select('id')->first();
        $department = department::where('department_name',$department_name)->where('company_id',$company->id)->select('id')->first();
        $designation = designation::where('designation_name',$designation_name)->where('company_id',$company->id)->where('department_id',$department->id)->select('id')->first();
        $office_shift = office_shift::where('shift_name',$shift_name)->where('company_id',$company->id)->select('id')->first();
        $role = Role::where('name',$role_name)->select('id')->first();
        $country = Country::where('name',$country_name)->select('id')->first();


		$user = User::create([
			'first_name' => $row['first_name'],
			'last_name' => $row['last_name'],
			'username' => $row['username'],
			'email' => $row['email'],
			'password' => Hash::make($row['password']),
			'contact_no' => $row['contact_no'],
			'role_users_id'=> $role->id,
			'is_active'=> 1,
		]);

		return new Employee([
			'id' => $user->id,
			'first_name' => $row['first_name'],
			'last_name' => $row['last_name'],
            'staff_id' => $row['staff_id'],
			'email' => $row['email'],
			'contact_no' => $row['contact_no'],
			'joining_date' => $row['joining_date'],
			'date_of_birth' => $row['date_of_birth'],
			'gender' => $row['gender'],
			'address' => $row['address'],
			'city' => $row['city'],
			'country' => $country->id,
			'zip_code' => $row['zip'],
			'attendance_type'=> $row['attendance_type'],
			'company_id'=> $company->id,
			'department_id'=> $department->id,
			'designation_id'=> $designation->id,
			'office_shift_id'=> $office_shift->id,
			'role_users_id'=> $role->id,
            'is_active'=> 1,
		]);
	}

	public function rules(): array
	{
		return [
			'first_name' => 'required',
			'last_name' => 'required',
            'staff_id' => 'required|numeric|unique:employees',
            'email'    => 'nullable|email|unique:users',
            'contact_no' => 'required|unique:users',
            'joining_date' => 'required|dateformat:'.env('Date_Format'),
            'date_of_birth' => 'required|dateformat:'.env('Date_Format'),
            'gender' => 'nullable|in:Male,Female,Other',
            'company_name'=> 'required|exists:companies,company_name',
            'department_name'=> 'required|exists:departments,department_name',
            'designation_name'=> 'required|exists:designations,designation_name',
            'shift_name'=> 'required|exists:office_shifts,shift_name',
            'username' => 'required|unique:users',
            'role_name'=> 'required|exists:roles,name',
            'password' => 'required|min:4',
            'attendance_type'=> 'required|in:general,ip_based',
		];
	}

	public function chunkSize(): int
	{
		return 500;
	}

	public function batchSize(): int
	{
		return 1000;
	}
}
