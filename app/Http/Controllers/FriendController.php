<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Friend;
use App\Http\Requests;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('friend.index', compact('user'));
    }
    
    public function userProfile($id)
    {
        $user = User::findOrFail($id);

        return view('user.index', compact('user'));
    }
    
    public function allUsers()
    {
        $users = User::where('id', '<>', Auth::id())->get();

        return view('friend.all-users', compact('users'));
    }

    public function addToFriends($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with('info', 'That user could not be found');
        }

        if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()->back()->with('info', 'Friend request already pending');
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->back()->with('info', 'You are already friends');
        }

        Auth::user()->addFriend($user);

        return redirect()->back()->with('info', 'Friend request sent');
    }

    public function accept($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with('info', 'That user could not be found');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->back();
        }

        Auth::user()->acceptedFriendRequest($user);

        return redirect()->back()->with('info', 'Friend request accepted');
    }
}
