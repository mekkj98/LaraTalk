<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Auth;

class IndexController extends Controller
{

    public function index(Request $rq) {
        $thisId = Auth::user()->id;
        $users = null;
        if($rq->has('search') && !empty($rq->search)) {
            $users = User::where('name','LIKE','%'.$rq->search."%")->paginate(12);
        } else {
            $users = User::where('id', '!=', $thisId)->orderBy('id', 'DESC')->paginate(12);
        }
        return view('pages.Users.users')->withUsers($users)->withFriends($this->get_friends($thisId))->withCurrentid($thisId);
    }

    
    public function get_friends(int $id) {
        $all_friends = User::find($id)->friends;
        return $all_friends;
    }

    public function friends() {
        $thisId = Auth::user()->id;
        $all_friends = User::find($thisId)->friends;
        $accepted = [];
        
        foreach($all_friends as $friend) { if($friend->pivot->status == 1) array_push($accepted, $friend); }

        return view('pages.Users.friends')->withFriends($accepted)->withCurrentid($thisId);
    }

    public function requests() {
        $thisId = Auth::user()->id;
        $all_friends = User::find($thisId)->friends;
        $accepted = [];
        
        foreach($all_friends as $friend) { 
            if($friend->pivot->status == 0) 
            array_push($accepted, $friend); }

        return view('pages.Users.requests')->withRequests($accepted)->withCurrentid($thisId);
    }
}
