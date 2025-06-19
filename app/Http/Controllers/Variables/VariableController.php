<?php


namespace App\Http\Controllers\Variables;


use App\Http\Controllers\Controller;

class VariableController extends Controller {

	public function index()
	{
		if(auth()->user()->can('access-variable_type'))
		{
			return view('settings.variables.index');
		}
		return abort('403', __('You are not authorized'));
	}

}
