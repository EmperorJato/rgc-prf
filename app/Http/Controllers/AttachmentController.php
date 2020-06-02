<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AttachmentController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }


    public function delete(Request $request){

        $id = $request->get('attachment-id');

        $attach_path = $request->get('attachment-path');
        
        Storage::delete('attachments/'.$attach_path);

        Attachment::where('attach_id', $id)->delete();
        
    }

    public function storeAttach(Request $request){

        $pr_id = $request->get('pr-id');

        if ($request->file('attachments')){

            $file = $request->file('attachments');


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
