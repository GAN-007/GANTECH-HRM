<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-holiday'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Holiday::with('company')->get())
					->setRowId(function ($holiday)
					{
						return $holiday->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-holiday'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-holiday'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('timesheet.holiday.index', compact('companies'));
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


		if ($logged_user->can('store-holiday'))
		{
			$validator = Validator::make($request->only('event_name', 'description', 'start_date', 'end_date', 'company_id', 'is_publish'),
				[
					'event_name' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date',
					'company_id' => 'required',
					'is_publish' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['event_name'] = $request->event_name;
			$data['description'] = $request->description;
			$data['company_id'] = $request->company_id;
			$data['start_date'] = $request->start_date;
			$data['end_date'] = $request->end_date;
			$data['is_publish'] = $request->is_publish;

			Holiday::create($data);

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
			$data = Holiday::findOrFail($id);
			$company_name = $data->company->company_name ?? '';

			return response()->json(['data' => $data, 'company_name' => $company_name]);
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
			$data = Holiday::findOrFail($id);

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

		if ($logged_user->can('edit-holiday'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('event_name', 'description', 'start_date', 'end_date', 'company_id', 'is_publish'),
				[
					'event_name' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date',
					'company_id' => 'required',
					'is_publish' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['event_name'] = $request->event_name;
			$data['description'] = $request->description;
			$data['company_id'] = $request->company_id;
			$data['start_date'] = $request->start_date;
			$data['end_date'] = $request->end_date;
			$data['is_publish'] = $request->is_publish;

			Holiday::find($id)->update($data);

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

		if ($logged_user->can('delete-holiday'))
		{
			Holiday::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-holiday'))
		{

			$holiday_id = $request['holidayIdArray'];
			$holiday = Holiday::whereIntegerInRaw('id', $holiday_id);
			if ($holiday->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Holiday')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected holidays can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function calendarableDetails($id)
	{
		if (request()->ajax())
		{
			$data = Holiday::with('company:id,company_name')->findOrFail($id);

			$new = [];

			$new['Company'] = $data->company->company_name;
			$new['Event Name'] = $data->event_name;
			$new['Start Date'] = $data->start_date;
			$new['End Date'] = $data->end_date;
			$new['Description'] = $data->description;
			$new['Status'] = 'Published';

			return response()->json(['data' => $new]);
		}
	}
}
