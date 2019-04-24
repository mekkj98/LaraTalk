<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Setting;
use Auth;

class SettingController extends Controller
{

    public function update(Request $request) 
    {
        $user = Setting::where('user_id', Auth::user()->id);
        if($user->update(['hide_email' =>  $request->hide_email,'hide_gender' => $request->hide_gender])) {
            return ['message'=> 'Setting Updated', 'status' => 'success'];
        } else {
           return ['message'=> 'Unable to updated Setting', 'status' => 'error'];
        }
    }
}
