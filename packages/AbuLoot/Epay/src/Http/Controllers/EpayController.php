<?php

namespace Abuloot\Epay\Http\Controllers;

use App\Http\Controllers\Controller;

class EpayController extends Controller
{
	public function index()
	{
		
		return view('epay::epay');
	}
}