<?php

namespace App\Http\Controllers;

use App\Models\FinanceBankCash;
use App\Models\FinanceTransaction;
use App\Models\FinanceTransfer;
use App\Models\PaymentMethod;
use Exception;
use http\Env\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Throwable;

class FinanceTransferController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();

		$accounts = FinanceBankCash::select('id', 'account_name')->get();
		$payment_methods = PaymentMethod::select('id', 'method_name')->get();

		if ($logged_user->can('view-balance_transfer'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceTransfer::with('FromAccount', 'ToAccount', 'PaymentMethod')->get())
					->setRowId(function ($transfer)
					{
						return $transfer->id;
					})
					->addColumn('from_account', function ($row)
					{
						$button = '<h6><a href="' . route('transactions.show', $row->FromAccount->id) . '">' . $row->FromAccount->account_name . '</a></h6>';

						return $button;
					})
					->addColumn('to_account', function ($row)
					{
					    if($row->ToAccount)
						    return '<h6><a href="' . route('transactions.show', $row->ToAccount->id) . '">' . $row->ToAccount->account_name . '</a></h6>';
                        else
                            return null;
					})
					->addColumn('payment_method', function ($row)
					{
						return empty($row->PaymentMethod->method_name) ? ' ' : $row->PaymentMethod->method_name;
					})
					->rawColumns(['from_account', 'to_account'])
					->make(true);
			}

			return view('finance.transfer.index', compact('accounts', 'payment_methods'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();


		if ($logged_user->can('store-balance_transfer'))
		{
			$validator = Validator::make($request->only('from_account_id', 'to_account_id', 'description', 'payment_method_id',
				'reference', 'date', 'amount'
			),
				[
					'from_account_id' => 'required',
					'amount' => 'required|numeric',
					'to_account_id' => 'required',
					'reference' => 'required',
					'date' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			DB::beginTransaction();
				try
				{
					$expense_account_balance = DB::table('finance_bank_cashes')->where('id', $request->from_account_id)->pluck('account_balance')->first();
					$deposit_account_balance = DB::table('finance_bank_cashes')->where('id', $request->to_account_id)->pluck('account_balance')->first();

					if ((int)$expense_account_balance < (int)$request->amount)
					{
						throw new Exception("requested balance is less then available balance");
					}


					$data = [];


					$data['from_account_id'] = $request->from_account_id;
					$data['amount'] = $request->amount;
					$data['to_account_id'] = $request->to_account_id;
					$data ['description'] = $request->description;
					$data ['payment_method_id'] = $request->payment_method_id;
					$data ['date'] = $request->date;
					$data ['reference'] = $request->reference;

					FinanceTransfer::create($data);

					$deposit_data = [];
					$expense_data = [];


					$deposit_data['account_id'] = $request->to_account_id;
					$deposit_data['amount'] = $request->amount;
					$deposit_data ['description'] = $request->description;
					$deposit_data ['payment_method_id'] = $request->payment_method_id;
					$deposit_data ['deposit_date'] = $data['date'];
					$deposit_data ['category'] = 'transfer';
					$deposit_data ['deposit_reference'] = $request->reference;

					$expense_data['account_id'] = $request->from_account_id;
					$expense_data['amount'] = $request->amount;
					$expense_data ['description'] = $request->description;
					$expense_data ['payment_method_id'] = $request->payment_method_id;
					$expense_data ['expense_date'] = $data['date'];
					$expense_data ['category'] = 'transfer';
					$expense_data ['expense_reference'] = $request->reference;

					$new_deposit_balance = (int)$deposit_account_balance + (int)$request->amount;
					$new_expense_balance = (int)$expense_account_balance - (int)$request->amount;


					FinanceTransaction::create($deposit_data);
					FinanceTransaction::create($expense_data);
					FinanceBankCash::whereId($request->to_account_id)->update(['account_balance' => $new_deposit_balance]);
					FinanceBankCash::whereId($request->from_account_id)->update(['account_balance' => $new_expense_balance]);

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
}
