<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\City;

class UserController extends Controller
{
	public function index()
	{
		$users = User::orderBy('sort_id')->get();

		$cities = City::orderBy('sort_id')->get();

		return view('admin.users.index', compact('users', 'cities'));
	}
}
