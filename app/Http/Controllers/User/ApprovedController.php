<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PRForms;

class ApprovedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $prform =  PRForms::where('user_id', Auth::user()->id)
        ->where('status', 'Approved')->orderBy('date', 'desc')->paginate(10);

        return view('user.user-approved', compact('prform'));
        
    }

    public function search(Request $request){

        $search = $request->get('search');

        if($search != ""){

            $prform = PRForms::where('user_id', Auth::user()->id)
            ->where('date', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('user_id', Auth::user()->id)
            ->where('series', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('user_id', Auth::user()->id)
            ->where('project', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('user_id', Auth::user()->id)
            ->where('purpose', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orderBy('date', 'desc')
            ->paginate(10);

            $prform->appends(['search' => $search]);

            return view('user.user-approved', compact('prform'));

        }

        return redirect()->route('user-approved');
    }
}
