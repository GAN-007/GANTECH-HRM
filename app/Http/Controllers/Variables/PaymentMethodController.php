<?php


namespace App\Http\Controllers\Variables;


use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController {

	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(PaymentMethod::select('id', 'method_name','payment_percentage','account_number')->get())
				->setRowId(function ($payment_method)
				{
					return $payment_method->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_method'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="payment_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="payment_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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

		if ($logged_user->can('access-variable_method'))
		{
			$validator = Validator::make($request->only('method_name','payment_percentage','account_number'),
				[
					'method_name' => 'required|unique:payment_methods',
				]
//				,
//				[
//					'method_name.required' => 'Payment name can not be empty',
//					'method_name.unique'  => 'Payment name already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['method_name'] = $request->get('method_name');
			$data['payment_percentage'] = $request->get('payment_percentage') .'%';
			$data['account_number'] = $request->get('account_number');

			PaymentMethod::create($data);

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
		if(request()->ajax())
		{
			$data = PaymentMethod::findOrFail($id);

			return response()->json(['data' => $data]);
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

		if ($logged_user->can('access-variable_method'))
		{
			$id = $request->get('hidden_payment_id');

			$validator = Validator::make($request->only('method_name_edit','payment_percentage_edit','account_number_edit'),
				[
					'method_name_edit' => 'required|unique:payment_methods,method_name,'.$id,
				]
//				,
//				[
//					'method_name_edit.required' => 'Payment name can not be empty',
//					'method_name_edit.unique'  => 'Payment name already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['method_name'] = $request->get('method_name_edit');
			$data['payment_percentage'] = $request->get('payment_percentage_edit') .'%';
			$data['account_number'] = $request->get('account_number_edit');


			PaymentMethod::whereId($id)->update($data);

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

		if ($logged_user->can('access-variable_method'))
		{
			PaymentMethod::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}

}
