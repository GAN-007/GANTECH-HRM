<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller {


	public function index()
	{
		$locations = location::all('id','location_name');
		if (request()->ajax())
		{
			return datatables()->of(company::with('Location.Country')->latest()->get())
				->setRowId(function ($company)
				{
					return $company->id;
				})
				->addColumn('city',function ($row)
				{
					return $row->Location->city ?? "" ;
				})
				->addColumn('country',function ($row)
				{
					return $row->Location->Country->name ?? "" ;
				})
				->addColumn('action', function ($data)
				{
					$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
					$button .= '&nbsp;&nbsp;';
					if(auth()->user()->can('edit-company'))
					{
						$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
					}
					if(auth()->user()->can('delete-company'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}
					return $button;
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('organization.company.index',compact('locations'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(Request $request)
	{
		if(auth()->user()->can('store-company'))
		{
			$validator = Validator::make($request->only('company_name', 'company_type', 'trading_name', 'registration_no', 'contact_no', 'email', 'website', 'tax_no',
				'location_id', 'company_logo'),
				[
					'company_name' => 'required|unique:companies,company_name,',
					'company_type' => 'required',
					'email' => 'email',
					'contact_no' => 'nullable|numeric',
					'location_id' => 'required',
					'company_logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['company_name'] = $request->company_name;
			$data['company_type'] = $request->company_type;
			$data ['trading_name'] = $request->trading_name;
			$data ['registration_no'] = $request->registration_no;
			$data ['contact_no'] = $request->contact_no;
			$data ['email'] = $request->email;
			$data ['website'] = $request->website;
			$data ['tax_no'] = $request->tax_no;
			$data ['location_id'] = $request->location_id;

			$company_logo = $request->company_logo;

			if (isset($company_logo))
			{

				if ($company_logo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', rand()) . '_' . time() . '.' . $company_logo->getClientOriginalExtension();
					$company_logo->storeAs('company_logo', $file_name);
					$data['company_logo'] = $file_name;
				}
			}


			company::create($data);


			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if (request()->ajax())
		{
			$data = company::with('location.country')->findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		if (request()->ajax())
		{
			$data = company::findOrFail($id);

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

		if ($logged_user->can('edit-company'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('company_name', 'company_type', 'trading_name', 'registration_no', 'contact_no', 'email', 'website', 'tax_no',
				'location_id', 'company_logo'),
				[
					'company_name' => 'required|unique:companies,company_name,' . $id,
					'email' => 'email',
					'contact_no' => 'nullable|numeric',
					'location_id' => 'required',
					'company_logo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['company_name'] = $request->company_name;
			$data ['trading_name'] = $request->trading_name;
			$data ['registration_no'] = $request->registration_no;
			$data ['contact_no'] = $request->contact_no;
			$data ['email'] = $request->email;
			$data ['website'] = $request->website;
			$data ['tax_no'] = $request->tax_no;
			$data ['location_id'] = $request->location_id;

			if ($request->company_type)
			{
				$data ['company_type'] = $request->company_type;
			}


			$company_logo = $request->company_logo;

			if (isset($company_logo))
			{

				if ($company_logo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', rand()) . '_' . time() . '.' . $company_logo->getClientOriginalExtension();
					$company_logo->storeAs('company_logo', $file_name);
					$data['company_logo'] = $file_name;
				}
			}
			company::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);

		} else
		{
			return response()->json(['success' => __('You are not authorized')]);
		}


	}


	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}

		$logged_user = auth()->user();

		if ($logged_user->can('delete-company'))
		{
            company::whereId($id)->delete();
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

		if ($logged_user->can('delete-company'))
		{

			$company_id = $request['companyIdArray'];
			$company = company::whereIntegerInRaw('id', $company_id);

			if ($company->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.Company')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected users can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

}


