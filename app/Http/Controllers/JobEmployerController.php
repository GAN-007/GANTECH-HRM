<?php

namespace App\Http\Controllers;

use App\Models\JobEmployer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class JobEmployerController extends Controller {

	//
	public function index()
	{
		$logged_user = auth()->user();
		if ($logged_user->can('view-job_employer'))
		{
			if (request()->ajax())
			{
				return datatables()->of(JobEmployer::latest()->get())
					->setRowId(function ($job_employer)
					{
						return $job_employer->id;
					})
					->addColumn('full_name', function ($row)
					{
						return $row->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-job_employer'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-job_employer'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('recruitment.job_employer.index');
		}
		return abort('403', __('You are not authorized'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */

	public function store(Request $request)
	{

		if (auth()->user()->can('store-job_employer'))
		{
			$validator = Validator::make($request->only('username', 'company_name', 'first_name', 'last_name', 'password', 'contact_no', 'email',
				'logo'),
				[
					'username' => 'required|unique:users,username,',
					'email' => 'required|email|unique:users',
					'company_name' => 'required',
					'contact_no' => 'nullable|numeric',
					'password' => 'required|min:4',
					'logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['password'] = bcrypt($request->password);
			$user_data['is_active'] = 1;
			$user_data['role_users_id'] = 4;

			$logo = $request->logo;
			$file_name = null;


			if (isset($logo))
			{
				$new_user = $user_data['username'];
				if ($logo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $logo->getClientOriginalExtension();
					$logo->storeAs('employer_logo', $file_name);
					$data['logo'] = $file_name;
				}
			}

			$data ['first_name'] = $request->first_name;
			$data ['last_name'] = $request->last_name;
			$data ['company_name'] = $request->company_name;

			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];

			DB::beginTransaction();
				try
				{
					$user = User::create($user_data);
					$data['id'] = $user->id;
					JobEmployer::create($data);

					DB::commit();
				} catch (Exception $e)
				{
					DB::rollback();
					return response()->json(['error' =>  $e->getMessage()]);
				} catch (Throwable $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				}
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
			$data = JobEmployer::findOrFail($id);
			$username = $data->user->username;

			return response()->json(['data' => $data, 'username' => $username]);
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

		if ($logged_user->can('edit-job_employer'))
		{
			$id = $request->hidden_id;

			$job_employer = JobEmployer::findOrFail($id);

			$validator = Validator::make($request->only('username', 'company_name', 'first_name', 'last_name', 'contact_no', 'email',
				'logo'),
				[
					'username' => 'required|unique:users,username,' . $id,
					'email' => 'required|email|unique:users,email,' . $id,
					'company_name' => 'required',
					'contact_no' => 'nullable|numeric',
					'logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['is_active'] = 1;


			$logo = $request->logo;
			$file_name = null;


			if (isset($logo))
			{
				$new_user = $user_data['username'];
				if ($logo->isValid())
				{
					$file_path = public_path('uploads/employer_logo/' . $job_employer->logo);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $logo->getClientOriginalExtension();
					$logo->storeAs('employer_logo', $file_name);
					$data['logo'] = $file_name;
				}
			}

			$data ['first_name'] = $request->first_name;
			$data ['last_name'] = $request->last_name;
			$data ['company_name'] = $request->company_name;
			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];

			DB::beginTransaction();
				try
				{
					User::whereId($id)->update($user_data);

					JobEmployer::whereId($id)->update($data);

					DB::commit();
				} catch (Exception $e)
				{
					DB::rollback();
					return response()->json(['error' =>  $e->getMessage()]);
				} catch (Throwable $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				}

				return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-job_employer'))
		{
			DB::beginTransaction();
				try
				{
					$job_employer = JobEmployer::findOrFail($id);

					$file_path = $job_employer->logo;

					if ($file_path)
					{
						$file_path = public_path('uploads/employer_logo/' . $file_path);
						if (file_exists($file_path))
						{
							unlink($file_path);
						}
					}

					$job_employer->delete();

					User::whereId($id)->delete();

					DB::commit();
				} catch (Exception $e)
				{
					DB::rollback();
					return response()->json(['error' =>  $e->getMessage()]);
				} catch (Throwable $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				}
				return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function delete_by_selection(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-job_employer'))
		{
			$employer_id = $request['job_employerIdArray'];
			$job_employer = JobEmployer::whereIntegerInRaw('id', $employer_id);
			$user =  User::whereIntegerInRaw('id', $employer_id);
			if ($job_employer->delete() && $user->delete() )
			{
				return response()->json(['success' => __('Multi Delete', ['key' => __('Job Employer')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected Employers can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

}
