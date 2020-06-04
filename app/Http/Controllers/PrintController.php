<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Illuminate\Support\Facades\Auth;
use App\Attachment;


class PrintController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function view_print($id){

        $data = [

            'report_path' => '/Reports/prf/pr_report_1',
            'controls' => ['pr_id' => $id]

        ];
        
        return response()->view('pages.print', $data)->header('Content-type', 'application/pdf');

    }

    public function index($id){

        
            $prforms = Products::select('products.*', 'prforms.*', 'users.*')
            ->join('prforms', 'prforms.pr_id', '=', 'products.prform_id')
            ->join('users', 'users.id', 'prforms.user_id')
            ->where('prforms.pr_id', $id)->where('prforms.user_id', Auth::user()->id)->first();

            $products = Products::where('prform_id', $id)->get();
            $attachments = Attachment::where('attachment_id', $id)->get();

            if($prforms){

                return view('pages.view-request', compact('prforms', 'products', 'attachments'));
                
            } else {

                abort(404);

            }

    }

    
    public function adminIndex($id){

        $prforms = Products::select('products.*', 'prforms.*', 'users.*')
            ->join('prforms', 'prforms.pr_id', '=', 'products.prform_id')
            ->join('users', 'users.id', 'prforms.user_id')
            ->where('prforms.pr_id', $id)->first();

        $products = Products::where('prform_id', $id)->get();
        $attachments = Attachment::where('attachment_id', $id)->get();

        return view('pages.admin-view-request', compact('prforms', 'products', 'attachments'));

    }


}


 
