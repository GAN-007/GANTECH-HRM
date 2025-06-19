<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function index()
	{
		if (auth()->user()->can('view-role'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Role::latest()->get())
					->setRowId(function ($role)
					{
						return $role->id;
					})
					->addColumn('name', function ($data)
					{
						return ucfirst ($data->name);
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if($data->name != 'admin' && $data->name != 'employee' && $data->name != 'client' )
						{
							if (auth()->user()->can('set-permission'))
							{
								$button = '<a class="show btn btn-primary btn-sm mr-1" href="'.route('rolePermission',$data->id).'">' . trans('file.Permission') . '</a>';
							}
							if (auth()->user()->can('edit-role'))
							{
								$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-1"><i class="dripicons-pencil"></i></button>';

							}
							if (auth()->user()->can('delete-role'))
							{
								$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
							}
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('settings.roles.index');

		}

		return abort(403, __('You are not authorized'));
	}


	public function store(Request $request)
	{
		if (auth()->user()->can('store-role'))
		{

			$validator = Validator::make($request->only('name', 'description', 'is_active'),
				[
					'name' => 'required|unique:roles,name,',
					'description' => 'nullable|max:1000',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->name;
			$data['description'] = $request->description;
			$data ['is_active'] = $request->is_active;

			Role::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function edit($id)
	{

		if (request()->ajax())
		{
			$data = Role::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request, $id)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('edit-role'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('name', 'description', 'is_active'),
				[
					'name' => 'required|unique:roles,name,' . $id,
					'description' => 'nullable|max:1000',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->name;
			$data['description'] = $request->description;
			$data ['is_active'] = $request->is_active;

			if (Role::whereId($id)->update($data))
			{
				return response()->json(['success' => __('Data is successfully updated')]);
			} else
			{
				return response()->json(['errors' => trans('Error')]);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-role'))
		{
			Role::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
