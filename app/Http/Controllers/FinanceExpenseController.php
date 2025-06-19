<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\FinanceBankCash;
use App\Models\FinanceExpense;
use App\Models\FinancePayees;
use App\Models\FinanceTransaction;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FinanceExpenseController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		$accounts = FinanceBankCash::select('id', 'account_name')->get();
		$payment_methods = PaymentMethod::select('id', 'method_name')->get();
		$payees = FinancePayees::select('id', 'payee_name')->get();
		$categories = ExpenseType::select('id', 'type')->get();


		if ($logged_user->can('view-expense'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceExpense::with('Account', 'PaymentMethod', 'Payee', 'Category')->latest('expense_date'))
					->setRowId(function ($expense)
					{
						return $expense->id;
					})
					->addColumn('account', function ($row)
					{
						return empty($row->Account->account_name) ? '' : $row->Account->account_name;
					})
					->addColumn('payment_method', function ($row)
					{
						return $row->PaymentMethod->method_name ?? trans('file.Bank');
					})
					->addColumn('payee', function ($row)
					{
						return empty($row->Payee->payee_name) ? '' : $row->Payee->payee_name;
					})
					->addColumn('category', function ($row)
					{
						return $row->Category->type ?? '';
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						// if (auth()->user()->can('edit-expense') && $data->expense_reference !== trans('file.Payroll'))
						if (auth()->user()->can('edit-expense'))
						{

							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						// if (auth()->user()->can('delete-expense') && $data->expense_reference !== trans('file.Payroll'))
						if (auth()->user()->can('delete-expense'))
						{

							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('finance.expense.index', compact('accounts', 'payment_methods', 'payees', 'categories'));
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


		if ($logged_user->can('store-expense'))
		{
			$validator = Validator::make($request->only('account_id', 'amount', 'category_id', 'description', 'payment_method_id', 'payee_id',
				'expense_reference', 'expense_date', 'expense_file'
			),
				[
					'account_id' => 'required',
					'amount' => 'required|numeric',
					'category_id' => 'required',
					'expense_reference' => 'required',
					'expense_date' => 'required',
					'expense_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			DB::beginTransaction();
			try
			{
				$account_balance = DB::table('finance_bank_cashes')->where('id', $request->account_id)->pluck('account_balance')->first();

				if ((int)$account_balance < (int)$request->amount)
				{
					return response()->json(['error' => 'requested balance is less then available balance']);
				}

				$new_balance = (int)$account_balance - (int)$request->amount;

				$data = [];

				$data['account_id'] = $request->account_id;
				$data['amount'] = $request->amount;
				$data['category_id'] = $request->category_id;
				$data ['description'] = $request->description;
				$data ['payment_method_id'] = $request->payment_method_id;
				$data ['payee_id'] = empty($request->payee_id) ? null : $request->payee_id;
				$data ['expense_date'] = $request->expense_date;
				$data ['expense_reference'] = $request->expense_reference;

				$file = $request->expense_file;
				$file_name = null;


				if (isset($file))
				{
					$file_name = $request->expense_reference;
					if ($file->isValid())
					{
						$file_name = preg_replace('/\s+/', '', $file_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
						$file->storeAs('expense_file', $file_name);
						$data['expense_file'] = $file_name;
					}
				}

				FinanceBankCash::whereId($request->account_id)->update(['account_balance' => $new_balance]);

				$Expense = FinanceTransaction::create($data);

				$data['id'] = $Expense->id;

				FinanceExpense::create($data);
				DB::commit();
			} catch (Exception $e)
			{
				DB::rollback();

				return response()->json(['error' => $e->getMessage()]);
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
			$data = FinanceExpense::findOrFail($id);
			$account_name = $data->Account->account_name ?? '';
			$payment_method_name = $data->PaymentMethod->method_name ?? '';
			$payee_name = $data->Payee->payee_name ?? '';
			$category_name = $data->Category->type ?? '';

			return response()->json(['data' => $data, 'account_name' => $account_name, 'payment_name' => $payment_method_name,
				'payee_name' => $payee_name, 'category_name' => $category_name]);
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
			$data = FinanceExpense::findOrFail($id);


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

		if ($logged_user->can('edit-expense'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('account_id', 'hidden_account_id', 'amount', 'hidden_amount', 'category_id', 'description', 'payment_method_id', 'payee_id',
				'expense_reference', 'expense_date'
			),
				[
					'account_id' => 'required',
					'amount' => 'required|numeric',
					'category_id' => 'required',
					'expense_reference' => 'required',
					'expense_date' => 'required',
					'expense_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			DB::beginTransaction();
			try
			{
				if ($request->account_id != $request->hidden_account_id && $request->account_id)
				{

					$data['account_id'] = $request->account_id;

					$account_balance = DB::table('finance_bank_cashes')->where('id', $request->account_id)->pluck('account_balance')->first();

					if ((int)$account_balance < (int)$request->amount)
					{
						return response()->json(['error' => __('requested balance is less then available balance')]);
					}

					$new_balance = (int)$account_balance - (int)$request->amount;

					$old_account_balance = DB::table('finance_bank_cashes')->where('id', $request->hidden_account_id)->pluck('account_balance')->first();

					$old_balance = (int)$old_account_balance + (int)$request->hidden_amount;

					FinanceBankCash::whereId($request->account_id)->update(['account_balance' => $new_balance]);

					FinanceBankCash::whereId($request->hidden_account_id)->update(['account_balance' => $old_balance]);

				} else
				{

					$data['account_id'] = $request->hidden_account_id;

					$account_balance = DB::table('finance_bank_cashes')->where('id', $request->hidden_account_id)->pluck('account_balance')->first();

					$new_balance = (int)$account_balance - (int)$request->amount + (int)$request->hidden_amount;

					if ((int)$new_balance < (int)$request->amount)
					{
						return response()->json(['error' => __('requested balance is less then available balance')]);
					}

					FinanceBankCash::whereId($request->hidden_account_id)->update(['account_balance' => $new_balance]);

				}

				$data = [];


				$data['amount'] = $request->amount;
				$data ['description'] = $request->description;
				$data ['expense_date'] = $request->expense_date;
				$data['expense_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['expense_date'])));
				$data ['expense_reference'] = $request->expense_reference;


				$data['category_id'] = $request->category_id;

				$data ['payment_method_id'] = $request->payment_method_id;

				$data ['payee_id'] = $request->payee_id;

				$file = $request->expense_file;
				$file_name = null;


				if (isset($file))
				{
					$file_name = $request->expense_reference;
					if ($file->isValid())
					{
						$file_name = preg_replace('/\s+/', '', $file_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
						$file->storeAs('expense_file', $file_name);
						$data['expense_file'] = $file_name;
					}
				}

				FinanceTransaction::find($id)->update($data);

				FinanceExpense::find($id)->update($data);

				DB::commit();

			} catch (Exception $e)
			{
				DB::rollback();

				return response()->json(['error' => $e->getMessage()]);
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
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-expense'))
		{
			DB::beginTransaction();
			try
			{
				$expense = FinanceExpense::findOrFail($id);
				$file_path = $expense->expense_file;
				$amount = $expense->amount;
				$account_id = $expense->account_id;

				$account_balance = DB::table('finance_bank_cashes')->where('id', $account_id)->pluck('account_balance')->first();

				$new_balance = (int)$account_balance + (int)$amount;

				FinanceBankCash::whereId($account_id)->update(['account_balance' => $new_balance]);

				if ($file_path)
				{
					$file_path = public_path('uploads/expense_file/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}

				// check if the image indeed exists

				$expense->delete();

				FinanceTransaction::whereId($id)->delete();
				DB::commit();
			} catch (Exception $e)
			{
				DB::rollback();

				return response()->json(['error' => $e->getMessage()]);
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
		$expense = FinanceExpense::findOrFail($id);
		$file_path = $expense->expense_file;
		$file_path = public_path('uploads/expense_file/' . $file_path);

		return response()->download($file_path);
	}

}
