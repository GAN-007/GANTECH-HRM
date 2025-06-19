<?php


namespace App\Http\Controllers\Variables;


use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetCategoryController {

	public function index()
	{
        if (auth()->user()->can('view-assets-category'))
        {
            if (request()->ajax())
            {
                return datatables()->of(AssetCategory::select('id', 'category_name')->get())
                    ->setRowId(function ($assets_category)
                    {
                        return $assets_category->id;
                    })
                    ->addColumn('action', function ($data)
                    {
                        $button = "";
                        if (auth()->user()->can('edit-assets-category'))
                        {
                            $button .= '<button type="button" name="edit" id="' . $data->id . '" class="assets_category_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                        }
                        if(auth()->user()->can('delete-assets-category'))
                        {
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<button type="button" name="delete" id="' . $data->id . '" class="assets_category_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

		    return view('assets.assets_category.assets_category');
        }


	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-assets-category'))
		{
			$validator = Validator::make($request->only('category_name'),
				[
					'category_name' => 'required|unique:asset_categories',
				]

			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['category_name'] = $request->get('category_name');

			AssetCategory::create($data);

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
			$data = AssetCategory::findOrFail($id);

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

		if ($logged_user->can('edit-assets-category'))
		{
			$id = $request->get('hidden_assets_id');

			$validator = Validator::make($request->only('category_name_edit'),
				[
					'category_name_edit' => 'required|unique:asset_categories,category_name,'.$id,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['category_name'] = $request->get('category_name_edit');



			AssetCategory::whereId($id)->update($data);

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

		if ($logged_user->can('delete-assets-category'))
		{
			AssetCategory::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
