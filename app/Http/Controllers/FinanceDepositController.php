<?php

namespace App\Http\Controllers;

use App\Models\FinanceBankCash;
use App\Models\FinanceDeposit;
use App\Models\FinancePayers;
use App\Models\FinanceTransaction;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FinanceDepositController extends Controller {


	public function index()
	{
		$logged_user = auth()->user();
		$accounts = FinanceBankCash::select('id', 'account_name')->get();
		$payment_methods = PaymentMethod::select('id', 'method_name')->get();
		$payers = FinancePayers::select('id', 'payer_name')->get();


		if ($logged_user->can('view-deposit'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceDeposit::with('Account', 'PaymentMethod', 'Payer')->latest('deposit_date'))
					->setRowId(function ($deposit)
					{
						return $deposit->id;
					})
					->addColumn('account', function ($row)
					{
						return empty($row->Account->account_name) ? '' : $row->Account->account_name;
					})
					->addColumn('payment_method', function ($row)
					{
						return empty($row->PaymentMethod->method_name) ? '' : $row->PaymentMethod->method_name;
					})
					->addColumn('payer', function ($row)
					{
						return empty($row->Payer->payer_name) ? '' : $row->Payer->payer_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-deposit'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-deposit'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('finance.deposit.index', compact('accounts', 'payment_methods', 'payers'));
		}

		return abort('403', __('You are not authorized'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();


		if ($logged_user->can('add-deposit'))
		{
			$validator = Validator::make($request->only('account_id', 'amount', 'category', 'description', 'payment_method_id', 'payer_id',
				'deposit_reference', 'deposit_date', 'deposit_file'
			),
				[
					'account_id' => 'required',
					'amount' => 'required|numeric',
					'category' => 'required',
					'deposit_reference' => 'required',
					'deposit_date' => 'required',
					'deposit_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			DB::beginTransaction();
				try
				{
					$data = [];

					$data['account_id'] = $request->account_id;
					$data['amount'] = $request->amount;
					$data['category'] = $request->category;
					$data ['description'] = $request->description;
					$data ['payment_method_id'] = $request->payment_method_id;
					$data ['payer_id'] = empty($request->payer_id) ? null : $request->payer_id;
					$data ['deposit_date'] = $request->deposit_date;
					$data ['deposit_reference'] = $request->deposit_reference;

					$file = $request->deposit_file;
					$file_name = null;


					if (isset($file))
					{
						$file_name = $request->deposit_reference;
						if ($file->isValid())
						{
							$file_name = preg_replace('/\s+/', '', $file_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
							$file->storeAs('deposit_file', $file_name);
							$data['deposit_file'] = $file_name;
						}
					}
					$account_balance = DB::table('finance_bank_cashes')->where('id', $request->account_id)->pluck('account_balance')->first();

					$new_balance = (int)$account_balance + (int)$request->amount;

					FinanceBankCash::whereId($request->account_id)->update(['account_balance' => $new_balance]);

					$Deposit = FinanceTransaction::create($data);

					$data['id'] = $Deposit->id;

					FinanceDeposit::create($data);

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
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show($id)
	{
		if (request()->ajax())
		{
			$data = FinanceDeposit::findOrFail($id);
			$account_name = $data->Account->account_name ?? '';
			$payment_method_name = $data->PaymentMethod->method_name ?? '';
			$payer_name = $data->Payer->payer_name ?? '';

			$deposit_date_name = $data->deposit_date;

			return response()->json(['data' => $data, 'account_name' => $account_name, 'payment_name' => $payment_method_name,
				'payer_name' => $payer_name, 'deposit_date_name' => $deposit_date_name]);
		}
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
			$data = FinanceDeposit::findOrFail($id);

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

		if ($logged_user->can('edit-deposit'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('account_id', 'hidden_account_id', 'amount', 'hidden_amount', 'category', 'description', 'payment_method_id', 'payer_id',
				'deposit_reference', 'deposit_date'
			),
				[
					'account_id' => 'required',
					'amount' => 'required|numeric',
					'category' => 'required',
					'deposit_reference' => 'required',
					'deposit_date' => 'required',
					'deposit_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			DB::beginTransaction();
				try
				{
					$data = [];


					$data['amount'] = $request->amount;
					$data ['description'] = $request->description;
					$data ['deposit_date'] = $request->deposit_date;
					$data ['deposit_reference'] = $request->deposit_reference;


					$data['category'] = $request->category;

					$data ['payment_method_id'] = $request->payment_method_id;

					$data ['payer_id'] = $request->payer_id;

					$file = $request->deposit_file;
					$file_name = null;


					if (isset($file))
					{
						$file_name = $request->deposit_reference;
						if ($file->isValid())
						{
							$file_name = preg_replace('/\s+/', '', $file_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
							$file->storeAs('deposit_file', $file_name);
							$data['deposit_file'] = $file_name;
						}
					}

					if ($request->account_id != $request->hidden_account_id && $request->account_id)
					{
						$data['account_id'] = $request->account_id;

						$account_balance = DB::table('finance_bank_cashes')->where('id', $request->account_id)->pluck('account_balance')->first();

						$new_balance = (int)$account_balance + (int)$request->amount;

						$old_account_balance = DB::table('finance_bank_cashes')->where('id', $request->hidden_account_id)->pluck('account_balance')->first();

						$old_balance = (int)$old_account_balance - (int)$request->hidden_amount;

						FinanceBankCash::whereId($request->account_id)->update(['account_balance' => $new_balance]);

						FinanceBankCash::whereId($request->hidden_account_id)->update(['account_balance' => $old_balance]);
					} else
					{

						$data['account_id'] = $request->hidden_account_id;

						$account_balance = DB::table('finance_bank_cashes')->where('id', $request->hidden_account_id)->pluck('account_balance')->first();

						$new_balance = (int)$account_balance + (int)$request->amount - (int)$request->hidden_amount;

						FinanceBankCash::whereId($request->hidden_account_id)->update(['account_balance' => $new_balance]);

					}

					FinanceTransaction::find($id)->update($data);

					FinanceDeposit::find($id)->update($data);

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
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-deposit'))
		{
			DB::beginTransaction();
				try
				{
					$deposit = FinanceDeposit::findOrFail($id);
					$file_path = $deposit->deposit_file;
					$amount = $deposit->amount;
					$account_id = $deposit->account_id;

					$account_balance = DB::table('finance_bank_cashes')->where('id', $account_id)->pluck('account_balance')->first();

					$new_balance = (int)$account_balance - (int)$amount;

					FinanceBankCash::whereId($account_id)->update(['account_balance' => $new_balance]);

					if ($file_path)
					{
						$file_path = public_path('uploads/deposit_file/' . $file_path);
						if (file_exists($file_path))
						{
							unlink($file_path);
						}
					}

					// check if the image indeed exists

					$deposit->delete();

					FinanceTransaction::whereId($id)->delete();

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

	public function download($id)
	{
		$deposit = FinanceDeposit::findOrFail($id);
		$file_path = $deposit->deposit_file;
		$file_path = public_path('uploads/deposit_file/' . $file_path);

		return response()->download($file_path);
	}


}
