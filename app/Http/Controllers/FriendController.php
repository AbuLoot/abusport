<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Friend;

class FriendController extends Controller
{
    public function index()
    {
        //$user = Auth::user();
        //$friends = Friend::all();
        
        $users = User::all();
        
        return view('frontend.friend.index', compact('users'));
    }
    
    public function all_users()
    {
        //$user = Auth::user();
        //$friends = Friend::all();
        
        $users = User::all();
        
        return view('frontend.friend.all_users', compact('users'));
    }
}
