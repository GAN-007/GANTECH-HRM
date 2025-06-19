<?php

namespace App\Http\Controllers;

use App\Models\FinancePayees;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FinancePayeeController extends Controller {

	public function index()
	{
		if (auth()->user()->can('view-payee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinancePayees::select('id', 'payee_name', 'contact_no', 'updated_at')->get())
					->setRowId(function ($payee)
					{
						return $payee->id;
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-payee'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-payee'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);

			}

			return view('finance.payees.payees');
		}

		return abort(403, __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-payees'))
		{
			$validator = Validator::make($request->only('payee_name', 'contact_no'),
				[
					'payee_name' => 'required|unique:finance_payees',
					'contact_no' => 'required|unique:finance_payees',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['payee_name'] = $request->payee_name;
			$data['contact_no'] = $request->contact_no;

			FinancePayees::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */


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
			$data = FinancePayees::findOrFail($id);

			return response()->json(['data' => $data]);
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

		if ($logged_user->can('edit-payee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('payee_name_edit', 'contact_no_edit'),
				[
					'payee_name_edit' => 'required|unique:finance_payees,payee_name,' . $id,
					'contact_no_edit' => 'required|unique:finance_payees,contact_no,' . $id,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['payee_name'] = $request->payee_name_edit;
			$data['contact_no'] = $request->contact_no_edit;

			FinancePayees::whereId($id)->update($data);

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

		if ($logged_user->can('delete-payee'))
		{
			FinancePayees::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
