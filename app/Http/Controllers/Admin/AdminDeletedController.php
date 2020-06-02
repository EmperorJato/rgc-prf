<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PRForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDeletedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $prform = PRForms::rightJoin('users', 'id', 'prforms.user_id')->where('status', 'Rejected')->orderBy('date', 'desc')->paginate(10);
        return view('admin.admin-deleted', compact('prform'));
        
    }

    
    public function search(Request $request){

        $search = $request->get('search');

        if($search != ""){

            $prform = PRForms::where('date', 'like', '%'.$search.'%')
            ->where('status', '=', 'Rejected')
            ->orWhere('requestor', 'like', '%'.$search.'%')
            ->where('status', '=', 'Rejected')
            ->orWhere('series', 'like', '%'.$search.'%')
            ->where('status', '=', 'Rejected')
            ->orWhere('project', 'like', '%'.$search.'%')
            ->where('status', '=', 'Rejected')
            ->orWhere('purpose', 'like', '%'.$search.'%')
            ->where('status', '=', 'Rejected')
            ->orderBy('date', 'desc')
            ->paginate(10);

            $prform->appends(['search' => $search]);

            return view('admin.admin-deleted', compact('prform'));

        }

        return redirect()->route('admin-removed');
    }
    
    public function restore(Request $request){

        $status_id = $request->get('status_id');

        PRForms::where('pr_id',  $status_id)->update([

            'status' => 'Requested',
            'status_date' => null,
            'status_remarks' => null

        ]);

    }

}
