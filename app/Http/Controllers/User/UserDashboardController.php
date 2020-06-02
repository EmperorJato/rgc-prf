<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PRForms;
use App\Products;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\User;
use App\Message;


class UserDashboardController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index(){
        $send = null;
        $last_requested = null;
        $last_id = null;
        $last_total = null;
        $status = null;
        $messages = null;

        $last_pr = PRForms::where('user_id', Auth::user()->id)->first();

        if($last_pr){

            $send = PRForms::where('user_id', Auth::user()->id)->latest('created_at')->first();

            $last_requested = PRForms::where('user_id', Auth::user()->id)->latest('created_at')->first()->series;

            $last_id = PRForms::where('user_id', Auth::user()->id)->latest('created_at')->first()->pr_id;
    
            $last_total = Products::where('prform_id', $last_id)->sum('total');

            $status = PRForms::where('user_id', Auth::user()->id)->latest('created_at')->first()->status;

        }
        

        $req = PRForms::where('user_id', Auth::user()->id)
        ->where('status', null)->count();

        $requested = PRForms::where('user_id', Auth::user()->id)
        ->where('status', 'Requested')->count();

        $approved = PRForms::where('user_id', Auth::user()->id)
        ->where('status', 'Approved')->count();

        $rejected = PRForms::where('user_id', Auth::user()->id)
        ->where('status', 'Rejected')->count();

        $grand = null;
        $app = PRForms::where('user_id', Auth::user()->id)->where('status', 'Approved')->first();

        if($app){

            $grand = PRForms::leftJoin('products', 'products.prform_id', '=', 'prforms.pr_id')->where('user_id', Auth::user()->id)->where('status', 'Approved')->sum('total');
        }

        $messageStats = PRForms::where('user_id', Auth::user()->id)->where('status_remarks', '<>', null)->where('status', 'Rejected')->first();
        
        if($messageStats){

            $messages = PRForms::join('users', 'users.id', '=', 'prforms.from_remarks')->where('user_id', Auth::user()->id)->where('msg_status', 0)->orderBy('series_no', 'asc')->get();
        }

        return view('user.user-dashboard', compact('req', 'requested', 'approved', 'rejected', 'last_pr', 'last_requested', 'last_total', 'grand', 'status', 'send', 'messages'));

    }

    public function profile($id){

        if(Auth::user()->id == $id){

            $user = User::find($id);

            return view('user.user-profile', ['user' => $user]);
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
            'fullname' => ['required', 'string', 'max:255']
        ]);
    }

    public function save_profile(Request $request){

        $this->profile_validate($request->all())->validate();

        User::where('id', Auth::user()->id)->update([
            'name' => $request->fullname,
        ]);
    }

}
