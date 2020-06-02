<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PRForms;
use App\Products;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Attachment;
use Illuminate\Support\Facades\Validator;

class UserFormController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index(){

        return view('user.user-form');

    }

    public function create(array $data){

        $dateNow = Carbon::now();

        return PRForms::create([

            'user_id' => Auth::user()->id,
            'requestor' => Auth::user()->name,
            'date' => $dateNow,
            'department' => $data['department'],
            'project' => $data['project'],
            'purpose' => $data['purpose']
            
        ]);

    }

    public function store(Request $request){
        
        $pr_id = $this->create($request->all())->id;


        $this->storeAttachment($pr_id);

        if(count($request->product) > 0){

            foreach($request->product as $item => $a){
                $data = array(
                    'prform_id' => $pr_id,
                    'product' => $request->product[$item],
                    'quantity' => $request->quantity[$item],
                    'unit' => $request->unit[$item],
                    'price' => $request->price[$item],
                    'total' => $request->total[$item],
                    'remarks' => $request->remarks[$item]
                );
                Products::insert($data);
            }
        }

        return response()->json(['pr_id' => $pr_id, 'requestor' => Auth::user()->name]);
        
    }

    private function storeAttachment($pr_id){

        if (request()->file('attachments')){

            $file = request()->file('attachments');


            foreach($file as $item => $b){

                
                $file_path = Carbon::parse(Carbon::now())->format('Y-m-d').'_ATTACH_'.rand().'-'.$file[$item]->getClientOriginalName();

                $attachment = array(

                    'attachment_id' => $pr_id,
                    'attach_name' =>  $file[$item]->getClientOriginalName(),
                    'attach_path' => $file_path
                );

            
                $file[$item]->move(public_path('storage/attachments'), $file_path);

                Attachment::insert($attachment);
                
            }
        }
    }

}
