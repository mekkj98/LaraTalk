<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Friend;
use App\Http\Models\User;
use Auth;

class ChatController extends Controller
{

    public function index(Request $rq) {
        $thisId = Auth::user()->id;
        return view('pages.Chat.chat')->withFriends($this->friends($thisId))->withCurrentid($thisId);
    }

    public function friends(int $id) {
        $all_friends = User::find($id)->friends;
        $accepted = [];
        foreach($all_friends as $friend) { if($friend->pivot->status == 1) array_push($accepted, $friend); }
        usort($accepted, function($a, $b) {
            return $a['pivot']['updated_at'] < $b['pivot']['updated_at'];
        });
        return $accepted;
    }
}
