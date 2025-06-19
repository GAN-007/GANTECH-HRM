<?php

namespace App\Http\Controllers;

use App\Models\FinanceBankCash;
use App\Models\FinanceTransaction;


class FinanceTransactionsController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-transaction'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FinanceTransaction::with('Account')->latest())
					->setRowId(function ($transaction)
					{
						return $transaction->id;
					})
					->addColumn('account', function ($row)
					{
						$button = '<h6><a href="' . route('transactions.show', $row->Account->id) . '">' . $row->Account->account_name . '</a></h6>';

						return $button;
					})
					->addColumn('date', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_date : $row->expense_date;
					})
					->addColumn('ref_no', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_reference : $row->expense_reference;
					})
					->rawColumns(['account'])
					->make(true);
			}

			return view('finance.transaction.index');
		}

		return abort('403', __('You are not authorized'));
	}

	public function show($id)
	{


		$account = FinanceBankCash::findOrFail($id);

		$transactions = FinanceTransaction::with('account')->where('account_id', $id)->get();

		return view('finance.transaction.show', compact('account','transactions','id'));

	}
}
