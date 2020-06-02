<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Products;
use Illuminate\Support\Facades\Auth;
use App\Attachment;

class UserEditController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index($id){

  

            $prforms = Products::select('products.*', 'prforms.*', 'users.*')
            ->join('prforms', 'prforms.pr_id', '=', 'products.prform_id')
            ->join('users', 'users.id', 'prforms.user_id')
            ->where('prforms.pr_id', $id)->where('prforms.user_id', Auth::user()->id)->first();
    
            $products = Products::where('prform_id', $id)->get();

            $attachments = Attachment::where('attachment_id', $id)->get();

            if($prforms){

                return view('user.user-edit', compact('prforms', 'products', 'attachments'));

            } else {

                abort(404);

            }


    }

}
