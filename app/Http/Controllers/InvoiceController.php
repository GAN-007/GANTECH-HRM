<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Notifications\InvoicePaidNotification;
use App\Notifications\InvoiceReceivedNotification;
use App\Models\Project;
use App\Models\TaxType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;


class InvoiceController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-invoice'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Invoice::with('project:id,title')->get())
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
						$button = '<a  class="show btn btn-success btn-sm" href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-invoice'))
						{
							$button .= '<a id="' . $data->id . '" class="edit btn btn-primary btn-sm" href="' . route('invoices.edit', $data) . '"><i class="dripicons-pencil"></i></a>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-invoice'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('projects.invoices.index');
		}

		return abort('403', __('You are not authorized'));
	}


	public function create()
	{
		$projects = Project::select('id', 'title')->get();
		$tax_types = TaxType::select('id', 'name', 'rate', 'type')->get();
		$invoice_number = 'INV-' . Str::random('6');

		return view('projects.invoices.create', compact('projects', 'tax_types', 'invoice_number'));
	}

	public function show(Invoice $invoice)
	{
		$invoice->load('project','client') ;

		if (auth()->user()->can('view-invoice')||$invoice->client_id == auth()->user()->id)
		{
			$invoice_items = InvoiceItem::whereInvoiceId($invoice->id)->get();
			$project = $invoice->project;
			$client = $invoice->client;
			$company = $project->company;
			$location = $company->Location;

			if (auth()->user()->role_users_id == 3){
				return view('client.invoice_show', compact('invoice', 'invoice_items', 'project', 'company', 'client','location'));
			}

			return view('projects.invoices.show', compact('invoice', 'invoice_items', 'project', 'company', 'client','location'));
		}
		return abort('403', __('You are not authorized'));
	}

	public function edit(Invoice $invoice)
	{
		if (auth()->user()->can('edit-invoice'))
		{
			$invoice_items = InvoiceItem::whereInvoiceId($invoice->id)->get();
			$tax_types = TaxType::select('id', 'name', 'rate', 'type')->get();
			$projects = Project::select('id', 'title')->get();

			return view('projects.invoices.edit', compact('invoice', 'invoice_items', 'tax_types', 'projects'));
		}
		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-invoice'))
		{
			$validator = Validator::make($request->only('project_id', 'invoice_number', 'item_name', 'qty_hrs', 'unit_price', 'tax_type_id',
				'tax-amount', 'sub_total_item', 'invoice_due_date', 'items_sub_total', 'items_tax_total', 'invoice_date', 'discount_type', 'discount_amount'
				, 'discount_figure', 'invoice_note', 'grand_total'
			),
				[
					'invoice_number' => 'required|unique:invoices,invoice_number',
					'project_id' => 'required',
					'qty_hrs.*' => 'nullable|numeric',
					'unit_price.*' => 'nullable|numeric',
					'invoice_date' => 'required',
					'invoice_due_date' => 'required|after_or_equal:invoice_date',
					'item_name.*' => 'required_with_all:qty_hours,unit_price',
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

					$project = Project::findOrFail($request->project_id);

					$client_id = $project->client->id;

					$data['project_id'] = $request->project_id;
					$data['invoice_number'] = $request->invoice_number;
					$data['sub_total'] = $request->items_sub_total;
					$data ['discount_type'] = $request->discount_type;
					$data ['client_id'] = $client_id;
					$data ['discount_figure'] = $request->discount_figure;
					$data ['total_discount'] = $request->discount_amount;
					$data ['total_tax'] = $request->items_tax_total;
					$data ['invoice_date'] = $request->invoice_date;
					$data ['invoice_due_date'] = $request->invoice_due_date;
					$data['grand_total'] = $request->grand_total;
					$data['invoice_note'] = $request->invoice_note;
					$data['status'] = 0;

					$invoice = Invoice::create($data);

					$qty = $request->qty_hrs;
					$unit_price = $request->unit_price;
					$item_name = $request->item_name;
					$tax_type_id = $request->tax_type_id;
					$tax_amount = $request->tax_amount;
					$sub_total_item = $request->sub_total_item;

					$invoice_item = [];

					for ($count = 0; $count < count($qty); $count++)
					{

						$invoice_item[] = [
							'invoice_id' => $invoice->id,
							'project_id' => $request->project_id,
							'item_qty' => $qty[$count],
							'item_unit_price' => $unit_price[$count],
							'item_name' => $item_name[$count],
							'item_tax_type' => $tax_type_id[$count],
							'item_tax_rate' => $tax_amount[$count],
							'item_sub_total' => $sub_total_item[$count],
							'sub_total' => $request->items_sub_total,
							'discount_type' => $request->items_sub_total,
							'discount_figure' => $request->discount_figure,
							'total_tax' => $request->items_tax_total,
							'total_discount' => $request->discount_amount,
							'grand_total' => $request->grand_total,
						];

					}

					InvoiceItem::insert($invoice_item);

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


	public function update(Request $request, $id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-invoice'))
		{

			$validator = Validator::make($request->only('project_id', 'invoice_number', 'item_name', 'qty_hrs', 'unit_price', 'tax_type_id',
				'tax-amount', 'sub_total_item', 'invoice_due_date', 'items_sub_total', 'items_tax_total', 'invoice_date', 'discount_type', 'discount_amount'
				, 'discount_figure', 'invoice_note', 'grand_total'
			),
				[
					'invoice_number' => 'required|unique:invoices,invoice_number,' . $id,
					'project_id' => 'required',
					'qty_hrs.*' => 'nullable|numeric',
					'unit_price.*' => 'nullable|numeric',
					'invoice_date' => 'required',
					'invoice_due_date' => 'required|after_or_equal:invoice_date',
					'item_name.*' => 'required_with_all:qty_hours,unit_price',
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

					$project = Project::findOrFail($request->project_id);

					$client_id = $project->client->id;

					$data['project_id'] = $request->project_id;
					$data['invoice_number'] = $request->invoice_number;
					$data['sub_total'] = $request->items_sub_total;
					$data ['discount_type'] = $request->discount_type;
					$data ['client_id'] = $client_id;
					$data ['discount_figure'] = $request->discount_figure;
					$data ['total_discount'] = $request->discount_amount;
					$data ['total_tax'] = $request->items_tax_total;
					$data ['invoice_date'] = $request->invoice_date;
					$data ['invoice_due_date'] = $request->invoice_due_date;
					$data['grand_total'] = $request->grand_total;
					$data['invoice_note'] = $request->invoice_note;

					Invoice::find($id)->update($data);


					$qty = $request->qty_hrs;
					$unit_price = $request->unit_price;
					$item_name = $request->item_name;
					$tax_type_id = $request->tax_type_id;
					$tax_amount = $request->tax_amount;
					$sub_total_item = $request->sub_total_item;
					$invoice_item_id = $request->invoice_item_id;

					$invoice_item = [];

					foreach ($invoice_item_id as $count => $item)
					{

						$invoice_item['invoice_id'] = $id;
						$invoice_item['project_id'] = $request->project_id;
						$invoice_item['item_qty'] = $qty[$count];
						$invoice_item['item_unit_price'] = $unit_price[$count];
						$invoice_item['item_name'] = $item_name[$count];
						$invoice_item['item_tax_type'] = $tax_type_id[$count];
						$invoice_item['item_tax_rate'] = $tax_amount[$count];
						$invoice_item['item_sub_total'] = $sub_total_item[$count];
						$invoice_item['sub_total'] = $request->items_sub_total;
						$invoice_item['discount_type'] = $request->discount_type;
						$invoice_item['discount_figure'] = $request->discount_figure;
						$invoice_item['total_tax'] = $request->items_tax_total;
						$invoice_item['total_discount'] = $request->discount_amount;
						$invoice_item['grand_total'] = $request->grand_total;


						if (InvoiceItem::where('id', $item)->exists())
						{
							InvoiceItem::find($item)->update($invoice_item);
						} else
						{
							InvoiceItem::create($invoice_item);
						}
					}
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

	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-invoice'))
		{
			Invoice::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function status($status_id,$invoice_id)
	{

		if ($status_id == 1){
			Invoice::find($invoice_id)->update(['status'=>1]);
			$invoice = Invoice::with('project','client')->findOrFail($invoice_id);

			$notifiable = User::findOrFail($invoice->client->id);

			$notifiable->notify(new InvoicePaidNotification($invoice));

		}

		elseif ($status_id == 2){
			Invoice::find($invoice_id)->update(['status'=>2]);

			$invoice = Invoice::with('project','client')->findOrFail($invoice_id);

			$notifiable = User::findOrFail($invoice->client->id);

			$notifiable->notify(new InvoiceReceivedNotification($invoice));
		}

		else{
			Invoice::find($invoice_id)->update(['status'=>0]);
		}

		return response()->json(['success' => trans('Status Changed successfully')]);
	}
}
