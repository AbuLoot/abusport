<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Match;
use App\Http\Requests;

class MatchController extends Controller
{
    public function myMatches()
    {
    	return view('board.my-matches');
    }
}
