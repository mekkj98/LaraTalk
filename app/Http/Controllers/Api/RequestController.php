<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Friend;
use Auth;

class RequestController extends Controller
{
    public function add(Request $re) {
        if(($re->has('sender') && $re->has('reciver'))) {
            $found = Friend::where( [ 
                ['sender', '=', $re->sender], 
                ['reciver' ,'=', $re->reciver]
            ])->orWhere([ 
                ['reciver', '=', $re->sender], 
                ['sender', '=', $re->reciver]
            ])->get();
            if($found->count() == 0) {
                $create = Friend::create([
                    'sender' => $re->sender,
                    'reciver' => $re->reciver
                ]);
                return ['message' => 'User has been sent a request.', 'status'=> 'success'];
            } else {
                return ['message' => "user and you have already a connection, please refresh your page", 'status' => 'error', 'found' => $found->count()];
            }
        }
        return ['message' => 'Unable to add friend.', 'status'=> 'error'];
    }
    
    public function accept(Request $re) {
        if(($re->has('sender') && $re->has('reciver'))) {
            $found = Friend::where( [ 
                ['sender', '=', $re->sender], 
                ['reciver' ,'=', $re->reciver]
            ])->orWhere([ 
                ['reciver', '=', $re->sender], 
                ['sender', '=', $re->reciver]
            ]);
            if($found->count() == 1) {
                if($found->update(['status' => '1']))
                    return ['message' => 'Request Accepted.', 'status'=> 'success'];
            }
        }
        return ['message' => 'Unable to accept request.', 'status'=> 'error'];
    }

    public function remove(Request $re) {
        if(($re->has('sender') && $re->has('reciver'))) {
            $found = Friend::where( [ 
                ['sender', '=', $re->sender], 
                ['reciver' ,'=', $re->reciver]
            ])->orWhere([ 
                ['reciver', '=', $re->sender], 
                ['sender', '=', $re->reciver]
            ]);
            if($found->count()== 1) {
                if($found->delete())
                    return ['message' => 'Friendship removed.', 'status'=> 'success'];
            }
        }
        return ['message' => 'Unable to remove friendship.', 'status'=> 'error'];
    }

    public function reject(Request $re) {
        if(($re->has('sender') && $re->has('reciver'))) {
            $found = Friend::where('reciver', '=', $re->sender)->where('sender', '=', $re->reciver)->where('status', '=', '0');
            if($found) {
                $found->delete();
                return ['message' => 'Request rejected.', 'status'=> 'success'];
            }
        }
        return ['message' => 'Unable to reject request.', 'status'=> 'error'];
    }
    
    public function take_back(Request $re) {
        if(($re->has('sender') && $re->has('reciver'))) {
            $found = Friend::where('sender', '=', $re->sender)->where('reciver', '=', $re->reciver)->where('status', '=', '0');
            if($found->count() == 1) {
                if($found->delete())
                    return ['message' => 'Request cancled.', 'status'=> 'success'];
            }
        }
        return ['message' => 'Unable to take back request.', 'status'=> 'error'];
    }
}
