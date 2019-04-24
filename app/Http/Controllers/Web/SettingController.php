<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Auth;

class SettingController extends Controller
{

    public function index() 
    {
        $authId = Auth::user()->id;
        $user = User::where('id' ,$authId)->with('activity')->with('setting')->get();
        return view('pages.Setting.setting')->withUser($user[0])->withCurid($authId);
    }
}
