<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;

class AssignRoleController extends Controller {

	public function update(Request $request, User $user)
	{
		$logged_user = auth()->user();
		// if ($logged_user->can('assign-role'))
		if ($logged_user->can('role-access-user'))
		{

			$role_id = $request->only('roleId');

			// if (!$role_id)
			// {
			// 	return response()->json(['success' => trans('Please assign a role')]);
			// }

			$employee = Employee::find($user->id);
			$employee->role_users_id = $role_id['roleId'];
			$employee->update();


			$user = User::find($user->id);
			$user->role_users_id = $role_id['roleId'];
			$user->update();

			$user->syncRoles($role_id);

			return response()->json(['success' => trans('Role assigned  successfully')]);
		}

		return response()->json(['error' => trans('Error')]);
	}


	public function mass_update(Request $request)
	{
		$logged_user = auth()->user();
		// if ($logged_user->can('assign-role'))
		if ($logged_user->can('role-access-user'))
		{
			$user_id = $request['userIdArray'];
			$role = $request['mass_role'];

			if ($role)
			{
				$users = User::whereIntegerInRaw('id', $user_id)->get();

				foreach ($users as $user)
				{
					$user->syncRoles($role);
				}

				return response()->json(['success' => trans('Role assigned  successfully')]);

			} else
			{
				return response()->json(['error' => trans('Error')]);
			}
		} else
		{
			return response()->json(['error' => trans('Error')]);
		}
	}
}
