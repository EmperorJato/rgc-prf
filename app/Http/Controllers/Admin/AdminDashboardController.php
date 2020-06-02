<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PRForms;
use App\Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\User;
use App\Message;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $date =  Carbon::parse(now())->format('Y-m-d');

        $today_pr = PRForms::where('status', 'Requested')->where('date', $date)->count();

        $pr = PRForms::where('status', 'Requested')->count(); 

        $prform = PRForms::where('status', 'Requested')->first();

        $total = null;

        $messages = null;

        if($prform){

    
            $total = PRForms::select('prforms.*', 'products.*')->leftJoin('products', 'products.prform_id', '=', 'prforms.pr_id')->where('status', 'Requested')->sum('total');
        }

        $messageStats = PRForms::where('msg_status_admin', 0)->first();
        
        if($messageStats){

            $messages = PRForms::join('users', 'users.id', '=', 'prforms.user_id')->where('msg_status_admin', 0)->get();
        }

        return view('admin.admin-dashboard', compact('today_pr', 'pr', 'total', 'prform', 'messages'));

    }

    public function profile($id){

        if(Auth::user()->id == $id){

            $user = User::find($id);

            return view('admin.admin-profile', ['user' => $user]);
        }

        return back();


    }

    public function upload(Request $request){

        $upload = $request->file('upload');

        $upload->move(public_path('images'), $upload->getClientOriginalName());

        User::where('id', Auth::user()->id)->update([
            'user_avatar' => $upload->getClientOriginalName(),
        ]);
    }

    public function profile_validate(array $data){
        return Validator::make($data, [
            'fullname' => ['required', 'string', 'max:255'],
        ]);
    }

    public function save_profile(Request $request){

        $this->profile_validate($request->all())->validate();

        User::where('id', Auth::user()->id)->update([
            'name' => $request->fullname,
        ]);
    }

}
