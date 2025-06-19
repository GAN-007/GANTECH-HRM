<?php

namespace App\Http\Controllers\Variables;

use App\Models\FileManagerSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileManagerSettingController extends Controller
{
    public function index(){

    	$file_config =FileManagerSetting::first();

    	return view ('file_manager.file_config',compact('file_config'));
	}

	public function store(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('view-file_config'))
		{
			$validator = Validator::make($request->only('allowed_extensions', 'max_file_size'),
				[
					'allowed_extensions' => 'required',
					'max_file_size' => 'required',
				]
//				,
//				[
//					'allowed_extensions.required' => 'Extension name can not be empty',
//					'max_file_size.required' => 'Please select a Company',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}
			$data = [];

			$data['allowed_extensions'] = strtolower($request->allowed_extensions);
			$data['max_file_size'] = strtolower($request->max_file_size);

			$file_config= FileManagerSetting::updateOrCreate(['id'=>1],$data);

			return response()->json(['success' => 'successfully added','file_config' =>$file_config]);

		}
	}


}
