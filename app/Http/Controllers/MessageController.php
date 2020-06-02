<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\PRForms;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Products;
use App\MSG;
use App\Reply;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::select('messages.*', 'prforms.*')->rightJoin('prforms', 'prforms.pr_id', '=', 'messages.msg_prf_id')->get();

        return view('view-message');
    }

    public function admin(){
        return view('admin.admin-message');
    }

    public function userInbox(){
        $messages = PRForms::join('users', 'users.id', 'prforms.from_remarks')->where('user_id', Auth::user()->id)->where('from_remarks', '<>', null)->orderBy('msg_status_date', 'desc')->get();
        // $msgs = MSG::join('users', 'users.id', 'msg.msg_from_id')->where('msg_to_id', Auth::user()->id)->orWhere('msg_from_id', Auth::user()->id)->get();
        return view('user.user-inbox', compact('messages'));
    }

    public function adminInbox(){
        $messages = PRForms::join('users', 'users.id', 'prforms.user_id')->where('from_remarks', '<>', null)->orderBy('msg_status_date', 'desc')->get();
        return view('admin.admin-inbox', compact('messages'));
    }

    public function userMessage($id){
       
        $prf = Message::rightJoin('users', 'users.id', '=', 'messages.msg_user_id')->rightJoin('prforms', 'prforms.pr_id', '=', 'messages.msg_prf_id')->where('user_id', Auth::user()->id)->where('status_remarks', '<>', null)->where('status', 'Rejected')->where('pr_id', $id)->orderBy('cmt_date', 'asc')->first();
        $messages = Message::leftJoin('users', 'users.id', '=', 'messages.msg_user_id')->leftJoin('prforms', 'prforms.pr_id', '=', 'messages.msg_prf_id')->where('user_id', Auth::user()->id)->where('status_remarks', '<>', null)->where('status', 'Rejected')->where('pr_id', $id)->orderBy('cmt_date', 'asc')->get();
        $products = Products::where('prform_id', $id)->get();
        if(!isset($prf, $messages)){
            return back();
        }
        return view('user.user-message', compact('messages', 'prf', 'products'));
    }


    public function adminMessage($id){
      
        $prf = Message::rightJoin('users', 'users.id', '=', 'messages.msg_user_id')->rightJoin('prforms', 'prforms.pr_id', '=', 'messages.msg_prf_id')->where('pr_id', $id)->first();
        $messages = Message::leftJoin('users', 'users.id', '=', 'messages.msg_user_id')->leftJoin('prforms', 'prforms.pr_id', '=', 'messages.msg_prf_id')->where('prforms.pr_id', $id)->orderBy('cmt_date', 'asc')->get();
        $products = Products::where('prform_id', $id)->get();
        if(!isset($prf, $messages)){
            return back();
        }
    
        return view('admin.admin-message', compact('messages', 'prf', 'products'));
    }

    public function userReply(Request $request){

        Message::insert([
            'msg_prf_id' => $request->prf_id,
            'msg_user_id' => Auth::user()->id,
            'comments' => $request->comments,
            'cmt_date' => Carbon::now()
        ]);

        $prf_id = $request->prf_id;

        PRForms::where('pr_id', $prf_id)->update([
            'msg_status' => 1,
            'msg_status_admin' => 0,
            'msg_status_date' => Carbon::now()
        ]);
    }

    public function adminReply(Request $request){

        Message::insert([
            'msg_prf_id' => $request->prf_id,
            'msg_user_id' => Auth::user()->id,
            'comments' => $request->comments,
            'cmt_date' => Carbon::now()
        ]);

        $prf_id = $request->prf_id;

        PRForms::where('pr_id', $prf_id)->update([
            'msg_status' => 0,
            'msg_status_admin' => 1,
            'msg_status_date' => Carbon::now()
        ]);
    }

    public function msgUser(Request $request){

        $prf_id = $request->prf_id;

        PRForms::where('pr_id', $prf_id)->update([
            'msg_status' => 1,
            'msg_status_date' => Carbon::now()
        ]);

    }

    
    public function msgAdmin(Request $request){

        $prf_id = $request->prf_id;

        PRForms::where('pr_id', $prf_id)->update([
            'msg_status_admin' => 1,
            'msg_status_date' => Carbon::now()
        ]);

    }

    public function recipient(Request $request){

        $query = $request->get('recipient');
    
        $user = User::where('name', 'LIKE', '%'.$query.'%')->get();

        return response()->json($user);
    }

    public function createMsg(array $data){
        return MSG::create([
            'msg_from_id' => Auth::user()->id,
            'msg_to_id' => $data['recipient_id'],
            'msg_from_status' => 1,
            'msg_to_status' => 0
        ]);
    }

    public function sendMsg(Request $request){
        $msg_id = $this->createMsg($request->all())->id;
        Reply::insert([
            'rm_id' => $msg_id,
            'rm_user' => Auth::user()->id,
            'rm_msg' => $request->msg_input,
            'rm_date' => Carbon::now()
        ]);
    }

}
