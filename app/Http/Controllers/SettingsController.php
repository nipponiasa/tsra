<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SettingsController extends Controller
{
    


    public function index()
    {
        $ccemail_temp=DB::table('relations')->where('relation_type', 'ccemail')->first();
        $bccemail_temp=DB::table('relations')->where('relation_type', 'bccemail')->first();
        $ccemail=$ccemail_temp?$ccemail_temp->destination_text:"";
        $bccemail=$bccemail_temp?$bccemail_temp->destination_text:"";

        return view('settings')->with('ccemail',$ccemail)->with('bccemail',$bccemail);
    }



    public function create(Request $request)
    {


        $ccemail=$request->ccemail;
        $bccemail=$request->bccemail;
        DB::table('relations')-> insert(
            array('relation_type' => 'ccemail',
            'source' => 0,
            'destination' => 0,
            'destination_text'=>$ccemail
        ));
        

        DB::table('relations')-> insert(
            array('relation_type' => 'bccemail',
            'source' => 0,
            'destination' => 0,
            'destination_text'=>$bccemail
        ));
        
      



        return view('settings')->with('ccemail',$ccemail)->with('bccemail',$bccemail);
    }




}
