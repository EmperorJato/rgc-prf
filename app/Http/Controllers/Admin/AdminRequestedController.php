<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PRForms;
use Illuminate\Support\Facades\Auth;


class AdminRequestedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $prform = PRForms::where('status', 'Approved')->where('checks', null)->orderBy('date', 'desc')->paginate(10);

        return view('admin.admin-requested', compact('prform'));
        
    }

    public function search(Request $request){

        $search = $request->get('search');

        if($search != ""){

            $prform = PRForms::where('date', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('series', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('requestor', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('project', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orWhere('purpose', 'like', '%'.$search.'%')
            ->where('status', '=', 'Approved')
            ->orderBy('date', 'desc')
            ->paginate(10);

            $prform->appends(['search' => $search]);

            return view('admin.admin-requested', compact('prform'));

        }

        return redirect()->route('admin-approved');
    }

}
