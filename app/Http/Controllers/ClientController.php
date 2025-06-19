<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		if ($logged_user->can('view-client'))
		{
			$countries = DB::table('countries')->select('id', 'name')->get();
			if (request()->ajax())
			{
				return datatables()->of(client::latest()->get())
					->setRowId(function ($client)
					{
						return $client->id;
					})
					->addColumn('name', function ($data)
					{
						return $data->first_name.' '.$data->last_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-client'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-client'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('projects.client.index', compact('countries'));
		}
		return abort('403', __('You are not authorized'));
	}


	public function store(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-client'))
		{
			$validator = Validator::make($request->only('username', 'company_name', 'first_name','last_name', 'password', 'contact_no', 'email', 'website', 'address1', 'address2',
				'city', 'state', 'country', 'zip', 'profile_photo'),
				[
					'username' => 'required|unique:users',
                    'email'    => 'nullable|email|unique:users',
					'company_name' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_no' => 'required|unique:users',
					'zip' => 'nullable|numeric',
					'password' => 'required|min:4',
					'profile_photo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['first_name'] = $request->first_name;
			$user_data['last_name'] = $request->last_name;
			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['password'] = bcrypt($request->password);
			$user_data['is_active'] = 1;
			$user_data['role_users_id'] = 3;

			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $user_data['username'];
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$user_data['profile_photo'] = $file_name;
					$data ['profile'] = $user_data['profile_photo'];
				}
			}

			$data['first_name'] = $request->first_name;
			$data['last_name'] = $request->last_name;
			$data ['company_name'] = $request->company_name;
			$data ['website'] = $request->website;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['state'] = $request->state;
			$data ['country'] = $request->country;
			$data ['zip'] = $request->zip;

			$data ['username'] = $user_data['username'];
			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];
			$data['is_active'] = 1;

			$user = User::create($user_data);
			$user->syncRoles(3);

			$data['id'] = $user->id;

			client::create($data);


			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{

		if (request()->ajax())
		{
			$data = client::findOrFail($id);

			return response()->json(['data' => $data,'login_type'=> $data->user->login_type]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('edit-client'))
		{
			$id = $request->hidden_id;
			$client = Client::findOrFail($id);

			$validator = Validator::make($request->only('username', 'company_name', 'first_name', 'last_name', 'contact_no', 'email', 'website', 'address1', 'address2',
				'city', 'state', 'country', 'zip', 'profile_photo'),
				[
					'username' => 'required|unique:users,username,' . $id,
                    'email'    => 'nullable|email|unique:users,email,' . $id,
					'company_name' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_no' => 'required|unique:users,contact_no,' . $id,
					'zip' => 'nullable|numeric',
					'profile_photo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['first_name'] = $request->first_name;
			$user_data['last_name'] = $request->last_name;
			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['is_active'] = $request->is_active;


			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $user_data['username'];
				if ($photo->isValid())
				{
					if ($client->profile){
						$file_path = public_path('uploads/profile_photos/' . $client->profile);
						if (file_exists($file_path))
						{
							unlink($file_path);
						}
					}
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$user_data['profile_photo'] = $file_name;
					$data ['profile'] = $user_data['profile_photo'];
				}
			}

			$data['first_name'] = $request->first_name;
			$data['last_name'] = $request->last_name;
			$data ['company_name'] = $request->company_name;
			$data ['website'] = $request->website;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['state'] = $request->state;
			$data ['country'] = $request->country;
			$data ['zip'] = $request->zip;

			$data ['username'] = $user_data['username'];
			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];
			$data['is_active'] = $request->is_active;

			try
			{
				User::whereId($id)->update($user_data);

				client::whereId($id)->update($data);
			} catch (Exception $e)
			{
				return response()->json(['error' => trans('file.Error')]);
			}


			return response()->json(['success' => __('Data is successfully updated')]);

		} else
		{
			return response()->json(['success' => __('You are not authorized')]);
		}


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-client'))
		{
			$client = Client::findOrFail($id);
			$file_path = $client->profile;

			if ($file_path)
			{
				$file_path = public_path('uploads/profile_photos/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$client->delete();

			User::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-client'))
		{
			$client_id = $request['clientIdArray'];
			$clients = Client::whereIntegerInRaw('id', $client_id)->get();

			foreach ($clients as $client)
			{
				$file_path = $client->profile;

				if ($file_path)
				{
					$file_path = public_path('uploads/profile_photos/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$client->delete();
				User::whereId($client->id)->delete();
			}

			return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Client')])]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
