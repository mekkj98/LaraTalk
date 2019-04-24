<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Auth;

class ProfileController extends Controller
{

    public function index(Request $rq) 
    {
        $authId = Auth::user()->id;
        $user = User::where('id' ,$rq->id)->with('activity')->with('setting')->get();

        return view('pages.Profile.profile')->withUser($user[0] ?? [])->withCurrentid($authId);
    }

}
