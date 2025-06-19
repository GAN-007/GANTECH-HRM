<?php

namespace App\Http\Controllers;

use App\AboutInfo;
use App\Models\CMS;
use Illuminate\Http\Request;


class CmsController extends Controller
{
	public function index()
	{
		$cms = CMS::find(1);

		return view('recruitment.cms',compact('cms'));
	}

	public function store(Request $request)
	{


		$data1 = [];
		$data2 = [];
		$data3 = [];

		$data1['home'] = $request->home;
		$data2['about'] = $request->about;
		$data3['contact'] = $request->contact;

		CMS::updateOrCreate(['id'=>1],$data1);
		CMS::updateOrCreate(['id'=>1],$data2);

		CMS::updateOrCreate(['id'=>1],$data3);


		return redirect()->back()->with('message', 'Data updated successfully');
	}

}
