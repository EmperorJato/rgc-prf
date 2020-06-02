<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use App\PRForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserRequestController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }
    
    public function index(){

        
        $prform =  PRForms::where('user_id', Auth::user()->id)
        ->where('status', '=', null)->orderBy('date', 'desc')->paginate(10);

        return view('user.user-request', compact('prform'));
        
    }

    public function delete(Request $request){

        $req_id = $request->get('req_id');

        PRForms::where('pr_id', $req_id)->update([

            'status' => 'Deleted'

        ]);
        
    }

    public function search(Request $request){

        $search = $request->get('search');

        if($search != ""){

            $prform = PRForms::where('user_id', Auth::user()->id)
            ->where('date', 'like', '%'.$search.'%')
            ->where('status', '=', null)
            ->orwhere('user_id', Auth::user()->id)
            ->where('series', 'like', '%'.$search.'%')
            ->where('status', '=', null)
            ->orWhere('user_id', Auth::user()->id)
            ->where('project', 'like', '%'.$search.'%')
            ->where('status', '=', null)
            ->orWhere('user_id', Auth::user()->id)
            ->where('purpose', 'like', '%'.$search.'%')
            ->where('status', '=', null)
            ->orderBy('date', 'desc')
            ->paginate(10);

            $prform->appends(['search' => $search]);

            return view('user.user-request', compact('prform'));

        }

        return redirect()->route('user-request');
    }


}
