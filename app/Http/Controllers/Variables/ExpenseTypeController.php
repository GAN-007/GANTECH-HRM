<?php


namespace App\Http\Controllers\Variables;


use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseTypeController {

	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(ExpenseType::with('company')->get())
				->setRowId(function ($expense_type)
				{
					return $expense_type->id;
				})
				->addColumn('company', function ($row)
				{
					return $row->company->company_name ?? ' ' ;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_type'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="expense_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="expense_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
					} else
					{
						return '';
					}
				})
				->rawColumns(['action'])
				->make(true);

		}

	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$validator = Validator::make($request->only('expense_type', 'company_id'),
				[
					'expense_type' => 'required|unique:expense_types,type',
					'company_id' => 'required',
				]

			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['type'] = $request->get('expense_type');
			$data['company_id'] = $request->get('company_id');

			ExpenseType::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return abort('403', __('You are not authorized'));

	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = ExpenseType::findOrFail($id);
			$company_name = $data->company->company_name ?? '';

			return response()->json(['data' => $data, 'company_name' => $company_name]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$id = $request->get('hidden_expense_id');

			$validator = Validator::make($request->only('expense_type_edit'),
				[
					'expense_type_edit' => 'required|unique:expense_types,type,' . $id,
				]

			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['type'] = $request->get('expense_type_edit');
			if ($request->get('company_id_edit'))
			{

				$data['company_id'] = $request->get('company_id_edit');
			}

			ExpenseType::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return abort('403', __('You are not authorized'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			ExpenseType::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return abort('403', __('You are not authorized'));
	}

}
