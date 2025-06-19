<?php

namespace App\Http\Controllers;

use App\Models\FinanceBankCash;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AccountListController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-account'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceBankCash::oldest()->get())
					->setRowId(function ($bankCash)
					{
						return $bankCash->id;
					})
					->addColumn('account_name', function ($row)
					{
						$button = '<h6><a href="' . route('transactions.show', $row->id) . '">' . $row->account_name . '</a></h6>';

						return $button;
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-account'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('edit-account'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->
					rawColumns(['action', 'account_name'])
					->make(true);
			}

			return view('finance.accounting_list.index');
		}

		return abort('403', __('You are not authorized'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public
	function store(Request $request)
	{
		$logged_user = auth()->user();


		if ($logged_user->can('store-account'))
		{
			$validator = Validator::make($request->only('account_name', 'initial_balance', 'account_number', 'branch_code', 'bank_branch'),
				[
					'account_name' => 'required|unique:finance_bank_cashes,account_name,',
					'initial_balance' => 'required|numeric',
					'account_number' => 'required|numeric',
					'branch_code' => 'required',
					'bank_branch' => 'required',
				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['account_name'] = $request->account_name;
			$data['initial_balance'] = $request->initial_balance;
			$data['account_number'] = $request->account_number;
			$data['branch_code'] = $request->branch_code;
			$data['bank_branch'] = $request->bank_branch;
			$data ['account_balance'] = $request->initial_balance;


			FinanceBankCash::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}


	public
	function edit($id)
	{

		if (request()->ajax())
		{
			$data = FinanceBankCash::findOrFail($id);

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
	public
	function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-account'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('account_name', 'initial_balance', 'account_number', 'branch_code', 'bank_branch'),
				[
					'account_name' => 'required|unique:finance_bank_cashes,account_name,' . $id,
					'initial_balance' => 'required',
					'account_number' => 'required',
					'branch_code' => 'required',
					'bank_branch' => 'required',
				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['account_name'] = $request->account_name;
			$data['initial_balance'] = $request->initial_balance;
			$data['account_number'] = $request->account_number;
			$data['branch_code'] = $request->branch_code;
			$data['bank_branch'] = $request->bank_branch;
			$data ['account_balance'] = $request->initial_balance;

			FinanceBankCash::whereId($id)->update($data);

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
	public
	function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-account'))
		{
			$general_setting =  GeneralSetting::findOrFail(1);

			$primary_bank = $general_setting->default_payment_bank;

			if ($primary_bank == $id){
				return response()->json(['error' => 'You can not delete a primary bank, please select another bank as primary from general settings']);
			}

			FinanceBankCash::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-account'))
		{

			$bankCash_id = $request['AccountListIdArray'];
			$bankCash = FinanceBankCash::whereIntegerInRaw('id', $bankCash_id);
			if ($bankCash->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Account')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected Accounts can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public
	function accountBalance()
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-account'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceBankCash::select('id', 'account_name', 'account_balance')->get())
					->setRowId(function ($bankCash)
					{
						return $bankCash->id;
					})
					->make(true);
			}

			return view('finance.account_balance.index');

		}

		return abort('403', __('You are not authorized'));
	}

}
