<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Chat;
use App\Match;
use App\Http\Requests;
use App\Events\AddedNewMessage;

class ChatController extends Controller
{
    public function postMessage(Request $request, $match_id)
    {
        $match = Match::findOrFail($match_id);

        $chat = new Chat;
        $chat->match_id = (in_array($request->user()->id, $match->users->lists('id')->toArray())) ? $match->id : redirect()->back();
        $chat->user_id = $request->user()->id;
        $chat->message = $request->message;
        $chat->save();

        event(
            new AddedNewMessage($chat)
        );

        return response()->json([]);
    }

    public function checkChannel()
    {

    }
}
