<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SportController extends Controller
{
    public function getSports()
    {
    	return view('board.sports');
    }
}
