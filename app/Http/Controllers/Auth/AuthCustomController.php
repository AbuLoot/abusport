<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Validator;

use App\User;
use App\Profile;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthCustomController extends Controller
{
    protected function postRegister(Request $request)
    {
		$phone = preg_replace('/[^0-9]/', '', $request->phone);

		$request->merge(['phone' => $phone]);

        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'phone' => 'required|min:11|max:11|unique:users',
            // 'email' => 'required|email|max:255|unique:users',
            // 'day' => 'required|numeric|between:1,31',
            // 'month' => 'required|numeric|between:1,12',
            // 'year' => 'required|numeric',
            'sex' => 'required',
            'password' => 'required|min:6|max:255',
            'rules' => 'accepted'
        ]);

        if ($request->phone[0] == 8) {
        	$request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        dd($request);

        $user = User::create([
            'surname' => $request->surname,
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'ip' => $request->ip(),
            'location' => serialize($request->ips()),
        ]);

        $profile = new Profile;
        $profile->sort_id = $user->id;
        $profile->user_id = $user->id;
        $profile->birthday = $request['year'].'-'.$request['month'].'-'.$request['day'];
        $profile->sex = $request['sex'];
        $profile->save();

        return $user;
    }


    public function confirmRegister()
    {
        return view('auth.confirm-register');
    }
}
