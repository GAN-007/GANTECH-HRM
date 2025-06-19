<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Client;
use App\Models\Role_User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class AllUserController extends Controller {

    public function index(){

        $logged_user = auth()->user();

        //$users = User::with('RoleUser')->orderByDesc('is_active');
        $users = User::orderBy('is_active','desc')->get();

        	if ($logged_user->can('view-user')){
                if (request()->ajax()){

                    return datatables()->of($users)
                    ->setRowId(function ($user)
                        {
                            return $user->id;
                        })
                        ->addColumn('username', function ($row)
                        {
                            if ($row->profile_photo)
                            {
                                $url = url("uploads/profile_photos/".$row->profile_photo);
                                $profile_photo = '<img src="'. $url .'" class="profile-photo md" style="height:35px;width:35px"/>';
                            }
                            else {
                                $url = url("logo/avatar.jpg");
                                $profile_photo = '<img src="'. $url .'" class="profile-photo md" style="height:35px;width:35px"/>';
                            }
                            $full_name  = "<span><a class='d-block text-bold' style='color:#24ABF2'>".$row->first_name.' '.$row->last_name."</a></span>";
                            $username = "<span><b>Username :</b> &nbsp;".$row->username."</span>";

                            return "<div class='d-flex'>
                                        <div class='mr-2'>".$profile_photo."</div>
                                        <div>"
                                            .$full_name.'</br>'.$username.'</br>'.
                                            // '<b>Role :</b> '.$row->RoleUser->role_name;
                                            '<b>Role :</b> '.$row->RoleUser->name.
                                        "</div>
                                    </div>";

                        })
                        ->addColumn('contacts', function ($row)
                        {
                            $contact_no = "<i class='text-muted fa fa-phone' title='Phone'></i>&nbsp;".$row->contact_no;
                            if ($row->email != null) {
                                $email = "<i class='fa fa-envelope text-muted' title='Email'></i>&nbsp;".$row->email;
                                return $email.'</br>'.$contact_no;
                            }
                            else {
                                return $contact_no;
                            }
                        })
                        ->addColumn('login_info', function ($row)
                        {
                            return '<b>Last Login Date :</b> '.$row->last_login_date.'</br>'.'<b>Last Login IP :</b> '.$row->last_login_ip;
                        })
                        ->addColumn('action', function ($data)
                        {
                            $button = '';
                            if (auth()->user()->can('edit-user')) {
                                if ($data->role_users_id != 1) {
                                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-document-edit"></i></button>';
                                    $button .= '&nbsp;&nbsp;';
                                }
                                else {
                                    if ($data->id == auth()->user()->id) {
                                        $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-document-edit"></i></button>';
                                        $button .= '&nbsp;&nbsp;';
                                    }
                                }

                            }
                            if (auth()->user()->can('delete-user'))
                            {
                                if ($data->role_users_id != 1) {
                                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-cross"></i></button>';
                                }
                            }

                            return $button;
                        })
                        ->rawColumns(['username','contacts','login_info','action'])
                        ->make(true);

                }
                return view('all_user.index');
            }
            return abort('403', __('You are not authorized'));
    }


	public function edit($id)
	{

		if (request()->ajax())
		{
			$data = User::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	// public function add_user_form()
	// {

	// 	$logged_user = auth()->user();

	// 	if ($logged_user->can('store-user'))
	// 	{

	// 		$data['roles'] = Role_User::select('id', 'role_name')->limit(2)->get();

	// 		return view('all_user.add_user_form', $data);
	// 	}

	// 	return abort('403', __('You are not authorized'));
	// }


	public function add_user_process(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-employee'))
		{

			$validator = Validator::make($request->all(),
				[
					'first_name' => 'required',
					'last_name'  => 'required',
					'username'   => 'required|unique:users',
                    'email'      => 'nullable|email|unique:users',
					'contact_no' => 'required|unique:users',
					'password'   => 'required|min:4|confirmed',
					'profile_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['first_name'] = $request->first_name;
			$data['last_name']  = $request->last_name;
			$data['username'] 	= strtolower(trim($request->username));
			$data['contact_no'] = $request->contact_no;
			$data['email'] 		= strtolower(trim($request->email));
			$data['password'] 	= bcrypt($request->password);
			$data['is_active'] 	= $request->is_active;
			$data['role_users_id'] = 1;

			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $request->username;
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$data['profile_photo'] = $file_name;
				}
			}

			$user = User::create($data);


			$user->syncRoles(1);


			return response()->json(['success' => __('Data Added successfully.')]);
		}


		return abort('403', __('You are not authorized'));

	}

	public function process_update(Request $request)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}

		$logged_user = auth()->user();

		if ($logged_user->can('edit-user'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->all(),
				[
					'first_name' => 'required',
					'last_name'  => 'required',
					'username' => 'required|unique:users,username,' . $id,
                    'email'      => 'nullable|email|unique:users,email,' . $id,
					'contact_no' => 'required|unique:users,contact_no,' . $id,
					'password' => 'nullable|min:4|confirmed',
					'profile_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['first_name'] = $request->first_name;
			$data['last_name']  = $request->last_name;
			$data['username']   = strtolower(trim($request->username));
			$data['contact_no'] = $request->contact_no;
			$data['email']      = strtolower(trim($request->email));
			$data['is_active']  = $request->is_active;




			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $request->username;
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$data['profile_photo'] = $file_name;
				}
			}

			// if (isset($request->password))
			// {
			// 	$data['password'] = bcrypt($request->password);
			// }
            if ($request->password)
			{
				$data['password'] = bcrypt($request->password);
			}

			User::whereId($id)->update($data);

            Employee::whereId($id)->update(['first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'contact_no' => $data['contact_no'], 'is_active' => $data['is_active']]);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function login_info()
	{

		$logged_user = auth()->user();

		if ($logged_user->can('last-login-user'))
		{

			$login_info = User::select('id', 'username', 'profile_photo', 'last_login_date', 'last_login_ip', 'is_active')->latest('last_login_date')->get();

			return view('all_user.login_info', ['login_info' => $login_info]);
		}

		return abort('403', __('You are not authorized'));

	}

	public function user_roles()
	{
		$logged_user = auth()->user();
		if(auth()->user()->role_users_id == 1) {
			$roles = Role::where('id', '!=', 3)->where('is_active',1)->select('id', 'name')->get();
		}
		else {
			$roles = Role::where('id', '!=', 1)->where('id', '!=', 3)->where('is_active',1)->select('id', 'name')->get();
		}


		if ($logged_user->can('role-access-user'))
		{
			$users = User::with('roles')->get();

			//return $users;

			if (request()->ajax())
			{
				return datatables()->of($users)
					->addColumn('role_name', function ($row)
					{
						foreach ($row->roles as $role)
						{
							return $role->name;
						};

						return null;
					})
					->setRowId(function ($user)
					{
						return $user->id;
					})
					->addColumn('role-access-user', function ($data)
					{
						return '';
					})
					->make(true);
			}


			return view('all_user.user_roles', compact('roles'));
		}

		return abort('403', __('You are not authorized'));

	}


	public function delete_user($id)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}

		$logged_user = auth()->user();

		if ($logged_user->can('delete-user'))
		{
			$user = User::findOrFail($id);
			$file_path = $user->profile_photo;

			if ($file_path)
			{
				$file_path = public_path('uploads/profile_photos/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$user->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function delete_by_selection(Request $request)
	{

		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();


		if ($logged_user->can('delete-user'))
		{
			$user_id = $request['userIdArray'];

			$user = User::whereIntegerInRaw('id', $user_id)->where('role_users_id','!=',1);

			if ($user->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.User')])]);
			} else
			{
				return response()->json(['error' => 'Error selected users can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
