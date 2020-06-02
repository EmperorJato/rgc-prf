<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PRForms;
use App\Products;
use Illuminate\Support\Carbon;
use App\Attachment;
use App\Message;

class AdminPendingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $prform = PRForms::select('prforms.*', 'attachments.attachment_id')->leftJoin('attachments', 'attachments.attachment_id', 'prforms.pr_id')->where('prforms.status', 'Requested')->orderBy('prforms.series_no', 'asc')->distinct('attachments.attachment_id')->get();
        return view('admin.admin-pending', compact('prform'));

    }

    public function view($id){

        $prforms = Products::select('products.*', 'prforms.*', 'users.*')
        ->join('prforms', 'prforms.pr_id', '=', 'products.prform_id')
        ->join('users', 'users.id', 'prforms.user_id')
        ->where('prforms.pr_id', $id)->first();
        $products = Products::where('prform_id', $id)->get();
        $attachments = Attachment::where('attachment_id', $id)->get();

        return view('admin.admin-view', compact('prforms', 'products', 'attachments'));

    }


    public function approve(Request $request){

        $status_id = $request->get('status_id');

        PRForms::where('pr_id', $status_id)->update([

            'approve' => Auth::user()->name,
            'status' => 'Approved',
            'status_date' => Carbon::now()

        ]);

    }

    public function remove(Request $request){

        $reason_id = $request->get('reason_id');

        PRForms::where('pr_id', $reason_id)->update([
            
            'approve' => Auth::user()->name,
            'status' => 'Rejected',
            'status_date' => Carbon::now(),
            'status_remarks' => $request->reason,
            'from_remarks' => Auth::user()->id,
            'msg_status' => 0,
            'msg_status_admin' => 1,
            'msg_status_date' => Carbon::now()

        ]);

        Message::insert([
            'msg_prf_id' => $reason_id,
            'msg_user_id' => Auth::user()->id,
            'comments' => $request->reason,
            'cmt_date' => Carbon::now()
        ]);

    }


    public function search(Request $request){

        $search = $request->get('search');

        if($search != ""){

            $prform = PRForms::where('date', 'like', '%'.$search.'%')
            ->where('status', '=', 'Requested')
            ->orWhere('series', 'like', '%'.$search.'%')
            ->where('status', '=', 'Requested')
            ->orWhere('requestor', 'like', '%'.$search.'%')
            ->where('status', '=', 'Requested')
            ->orWhere('project', 'like', '%'.$search.'%')
            ->where('status', '=', 'Requested')
            ->orWhere('purpose', 'like', '%'.$search.'%')
            ->where('status', '=', 'Requested')
            ->orderBy('series_no', 'asc')
            ->paginate(10);

            $prform->appends(['search' => $search]);

            return view('admin.admin-pending', compact('prform'));

        }

        return redirect()->route('admin-pending');
    }

    public function addProduct(Request $request){


        Products::insert([

            'prform_id' => $request->prform_id,
            'product' => $request->product,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'total' => $request->total,
            'remarks' => $request->remarks
            
        ]);

    }

    public function saveProduct(Request $request){

        $p_id = $request->get('edit_id');

        Products::where('p_id', $p_id)->update([

            'product' => $request->edit_product,
            'unit' => $request->edit_unit,
            'quantity' => $request->edit_quantity,
            'price' => $request->edit_price,
            'remarks' => $request->edit_remarks,
            'total' => $request->edit_total

        ]);

    }

    public function destroy(Request $request){

        $delete_id = $request->get('delete_id');
        
        $product = Products::where('p_id', $delete_id);

        $product->delete();

    }

    public function viewAttachment(Request $request){

        $id = $request->attachment_id;

        $attachments = Attachment::where('attachment_id', $id)->get();

        return view('admin.admin-attachment', compact('attachments'))->render();

    }
}
