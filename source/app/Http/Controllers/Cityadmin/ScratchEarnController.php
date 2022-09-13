<?php

namespace App\Http\Controllers\Cityadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Session;

class ScratchEarnController extends Controller
{
    public function adminScratchEarn(Request $request)
    {
    	$title = "Scratch & Earn";
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;
    	$adminScratchEarn = DB::table('tbl_scratch_card')
                                ->where('is_deleted', '0')
        			        	->get();

        return view('cityadmin.scratch.index',compact("adminScratchEarn", "title","cityadmin_email","cityadmin","cityadmin_id"));
    }

    public function adminScratchEarnAdd(Request $request)
    {
    	$title = "Add Scratch & Earn";
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;
        return view('cityadmin.scratch.add', compact("title","cityadmin_email","cityadmin","cityadmin_id"));
    }

    public function adminScratchEarnAddNew(Request $request)
    {
 
    	$this->validate(
            $request,
                [
                    'cart_value' => 'required',
                    'scratch_card_name' => 'required',
                    'scratch_card_image' => 'required|mimes:jpeg,png,jpg|max:400',
                    'min_amount' => 'required',
                    'max_amount' => 'required',
                ],
                [
                    'cart_value.required' => 'Enter Minimu Cart Value.',
                    'scratch_card_name.required' => 'enter scratch card name.',
                    'scratch_card_image.required' => 'Choose scratch card image.',
                    'min_amount.required' => 'enter scratch card min amount.',
                    'max_amount.required' => 'enter scratch card max amount.',
                ]
        );

       

            $min_amount = $request->min_amount;
            $max_amount = $request->max_amount;
            $scratch_card_offer = array('min'=>$min_amount, 'max'=>$max_amount);
        

        $cart_value = $request->cart_value;
        $scratch_card_name = $request->scratch_card_name;
        $scratch_card_offers = json_encode($scratch_card_offer);
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $date = date('d-m-Y');

        if($request->hasFile('scratch_card_image')){
            $scratch_card_image = $request->scratch_card_image;
            $fileName = date('dmyhisa').'-'.$scratch_card_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $scratch_card_image->move('images/scratch/'.$date.'/', $fileName);
            $scratch_card_image = 'images/scratch/'.$date.'/'.$fileName;
        }
        else{
            $scratch_card_image = 'N/A';
        }

        $insertScratchEarn = DB::table('tbl_scratch_card')
                            ->insertGetId([
                                'scratch_card_name'=>$scratch_card_name,
                                'scratch_card_image'=>$scratch_card_image,
                                'min_cart_value'=>$cart_value,
                                'scratch_card_rewards'=>$scratch_card_offers,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertScratchEarn){


            return redirect()->back()->withErrors('scratch card added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminScratchEarnEdit(Request $request)
    
    {
      
        $title = "Edit Scratch & Earn";
        $id = $request->id;
        $cityadmin_email=Session::get('cityadmin');
        $cityadmin=DB::table('cityadmin')
        ->where('cityadmin_email',$cityadmin_email)
        ->first();
        $cityadmin_id = $cityadmin->cityadmin_id;
        $adminScratchEarnEdit = DB::table('tbl_scratch_card')
                                    ->where('is_deleted', '0')
                                    ->where('id', $id)
                                    ->first();

        return view('cityadmin.scratch.edit', compact("title", "adminScratchEarnEdit","cityadmin_email","cityadmin","cityadmin_id"));
    }

    public function adminScratchEarnUpdate(Request $request)
    {
        
        
       	$this->validate(
            $request,
                [
                    'cart_value' => 'required',
                    'scratch_card_name' => 'required',
                    'scratch_card_image' => 'required|mimes:jpeg,png,jpg|max:400',
                    'min_amount' => 'required',
                    'max_amount' => 'required',
                ],
                [
                    'cart_value.required' => 'Enter Minimu Cart Value.',
                    'scratch_card_name.required' => 'enter scratch card name.',
                    'scratch_card_image.required' => 'Choose scratch card image.',
                    'min_amount.required' => 'enter scratch card min amount.',
                    'max_amount.required' => 'enter scratch card max amount.',
                ]
        );
            $min_amount = $request->min_amount;
            $max_amount = $request->max_amount;
            $scratch_card_offer = array('min'=>$min_amount, 'max'=>$max_amount);
            
        

      
        $id = $request->id;
        $cart_value = $request->cart_value;
        $scratch_card_offers = json_encode($scratch_card_offer);
        $updated_at = Carbon::now();

        $date = date('d-m-Y');

        $getScratchCard = DB::table('tbl_scratch_card')
                            ->where('id', $id)
                            ->first();

        $image = $getScratchCard->scratch_card_image;


            $scratch_card_name = $request->scratch_card_name;
        

        if($request->hasFile('scratch_card_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $scratch_card_image = $request->scratch_card_image;
            $fileName = date('dmyhisa').'-'.$scratch_card_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $scratch_card_image->move('images/scratch/'.$date.'/', $fileName);
            $scratch_card_image = 'images/scratch/'.$date.'/'.$fileName;
        }
        else{
            $scratch_card_image = $getScratchCard->scratch_card_image;
        }

        $insertScratchEarn = DB::table('tbl_scratch_card')
                            ->where('id', $id)
                            ->update([
                                 'scratch_card_name'=>$scratch_card_name,
                                'scratch_card_image'=>$scratch_card_image,
                                'min_cart_value'=>$cart_value,
                                'scratch_card_rewards'=>$scratch_card_offers,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertScratchEarn){
            return redirect()->back()->withErrors('scratch card updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminScratchEarnDelete(Request $request)
    {
        $id = $request->id;

        $getScratchCard = DB::table('tbl_scratch_card')
                            ->where('is_deleted', '0')
                            ->where('id', $id)
                            ->first();

        

        $adminScratchEarnDelete = DB::table('tbl_scratch_card')
                                    ->where('id', $id)
                                    ->update([
                                        'is_deleted'=>'1',
                                    ]);

        if($adminScratchEarnDelete){
          

            return redirect()->back()->withErrors('scratch card deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
