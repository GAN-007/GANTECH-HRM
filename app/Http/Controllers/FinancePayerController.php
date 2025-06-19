<?php

namespace App\Http\Controllers;

use App\Models\FinancePayers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FinancePayerController extends Controller {

	public function index()
	{
		if (auth()->user()->can('view-payer'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinancePayers::select('id', 'payer_name', 'contact_no', 'updated_at')->get())
					->setRowId(function ($payer)
					{
						return $payer->id;
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-payer'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-payer'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);

			}

			return view('finance.payers.payers');
		}
		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-payer'))
		{
			$validator = Validator::make($request->only('payer_name', 'contact_no'),
				[
					'payer_name' => 'required|unique:finance_payers',
					'contact_no' => 'required|unique:finance_payers',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['payer_name'] = $request->payer_name;
			$data['contact_no'] = $request->contact_no;

			FinancePayers::create($data);

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
			$data = FinancePayers::findOrFail($id);

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

		if ($logged_user->can('edit-payer'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('payer_name_edit', 'contact_no_edit'),
				[
					'payer_name_edit' => 'required|unique:finance_payers,payer_name,' . $id,
					'contact_no_edit' => 'required|unique:finance_payers,contact_no,' . $id,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['payer_name'] = $request->payer_name_edit;
			$data['contact_no'] = $request->contact_no_edit;

			FinancePayers::whereId($id)->update($data);

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

		if ($logged_user->can('delete-payer'))
		{
			FinancePayers::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
