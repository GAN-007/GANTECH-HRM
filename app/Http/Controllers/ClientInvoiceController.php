<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class ClientInvoiceController extends Controller
{
	public function invoices()
	{
		$logged_user = auth()->user();


		if ($logged_user->role_users_id == 3)
		{
			if (request()->ajax())
			{
				return datatables()->of(Invoice::with('project:id,title')
					->where('client_id',$logged_user->id)
					->where('status','=','0')
					->get())
					->setRowId(function ($invoice)
					{
						return $invoice->id;
					})
					->addColumn('project', function ($row)
					{
						$project_name = empty($row->project->title) ? '' : $row->project->title;

						return $project_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('client.invoice');
		}

		return abort('403', __('You are not authorized'));
	}


	public function paidInvoices()
	{
		$logged_user = auth()->user();

		$a = Invoice::with('project:id,title')
			->where('client_id',$logged_user->id)
			->where('status','=',1)
			->get();


		if ($logged_user->role_users_id == 3)
		{
			if (request()->ajax())
			{
				return datatables()->of($a)
					->setRowId(function ($invoice)
					{
						return $invoice->id;
					})
					->addColumn('project', function ($row)
					{
						$project_name = empty($row->project->title) ? '' : $row->project->title;

						return $project_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-success btn-sm"><a href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a></button>';
						$button .= '&nbsp;&nbsp;';
						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('client.paid_invoice');
		}

		return abort('403', __('You are not authorized'));
	}
}
