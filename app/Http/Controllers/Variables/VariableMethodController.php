<?php


namespace App\Http\Controllers\Variables;


class VariableMethodController {

	public function index()
	{
		if(auth()->user()->can('access-variable_method'))
		{
			return view('settings.variables_method.index');
		}
		return abort('403', __('You are not authorized'));
	}

}