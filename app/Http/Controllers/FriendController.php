<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Friend;
use Auth;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        //$users = User::all();
        
        return view('frontend.friend.index', compact('user'));
    }
    
    public function user($id)
    {
        $user = User::findOrFail($id);
        
        return view('frontend.user.index', compact('user'));
    }
    
    public function all_users()
    {
        $users = User::all();
        return view('frontend.friend.all_users', compact('users'));
    }

    public function getAdd($id){
        $user = User::findOrFail($id);
        if(!$user){
            return redirect()
                ->back()
                ->with('info', 'That user could not be found');
        }

        if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())){
            return redirect()
                ->back()
                ->with('info', 'Friend request already pending');
        }

        if(Auth::user()->isFriendWith($user)){
            return redirect()
                ->back()
                ->with('info', 'You are already friends');
        }

        Auth::user()->addFriend($user);
        return redirect()
            ->back()
            ->with('info', 'Friend request sent');
    }

    public function getAccept($id){
        $user = User::findOrFail($id);
        if(!$user){
            return redirect()
                ->back()
                ->with('info', 'That user could not be found');
        }

        if(!Auth::user()->hasFriendRequestReceived($user)){
            return redirect()
                ->back();
        }

        Auth::user()->acceptedFriendRequest($user);
        return redirect()
            ->back()
            ->with('info', 'Friend request accepted');
    }
}
