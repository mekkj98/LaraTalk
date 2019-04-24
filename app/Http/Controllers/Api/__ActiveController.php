<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Active;
use Auth;

class ActiveController extends Controller
{

    public function offline(Request $request) 
    {
        $user = Active::where('user_id', Auth::user()->id);
        if($user->update(['is_online' => 0])) {
            return ['message'=> 'You are offline Now.', 'status' => 'success'];
        } else {
           return ['message'=> 'Unable to make you offline', 'status' => 'error'];
        }
    }
    
}
