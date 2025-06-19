<?php


namespace App\Http\Controllers\FrontEnd;


use App\Models\CMS;

class ContactController {

	public function index()
	{
		$cms = CMS::find(1);
		$contact = $cms->contact;
		return view('frontend.cms.contact',compact('contact'));
	}

}