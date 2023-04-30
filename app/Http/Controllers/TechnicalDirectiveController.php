<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOut;
use App\Models\User;
use File;
use App\Models\Message;
use App\Models\TechnicalDirective;
use App\Models\ReadState;


class TechnicalDirectiveController extends Controller
{
  
    // GET CREATE
    public function show_create()
    {
      $uii=DB::select(DB::raw('SELECT * FROM models;'));
      return view('support.technical_directives.create')->with('uii',$uii);
    }



    // POST CREATE
    public function create(Request $request)   
    {
            


        $validated = $request->validate([
            'subject' => 'required',
            'directive' => 'required',
            'publish_state' => 'required',
            'models' => 'required'
        ]);



        $technicaldirective=new TechnicalDirective();
        $subject=$request->subject;
        $models=$request->models;
        //$directive=$request->directive;//na fygei
        $publish_state=$request->publish_state;
        $agent_id=Auth::user()->id;
        $agent_email = Auth::user()->email;
        $date=Carbon::now();
        //dd( $technicaldirective);
        $technicaldirective->subject=$subject;
        $technicaldirective->publish_state=$publish_state;
        $technicaldirective->agent_id=$agent_id;
        







        // $directive->subject=$subject;
        //******************************* */

        $content = $request->directive;
        $dom = new \DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $content = $dom->saveHTML();

        $technicaldirective->directive=$content;

        //******************************* */
        //dd( $technicaldirective);

        $technicaldirective->save();
        $directive_id=$technicaldirective->id;
        
        //models

        if( !is_null($models)) 
        {     

            foreach($models as $model)
            {
                DB::table('relations')-> insert(array('source' =>$directive_id ,'relation_type' => "directives_for_model",'destination'=>$model));

            }

        }

        //models
        ReadState::mark_unread($directive_id,"DIRECTIVE");


        return Redirect::to('technical_directives/list');
                        

    }





        /**
         * Show Technical Report List
         *
         */
        public function getTechnicalDirectiveList()
        {
            // $user_id=Auth::id();
            // $uii=TechnicalDirective::get_directives_list_user($user_id);
            $technical_directives = TechnicalDirective::all();

            return view('support.technical_directives.list')->with('technical_directives',$technical_directives);
        }



        /**
         * Show Technical Report
         *
         */
        public function showTechnicalDirective(Request $request)
        {
            // $directive_id = $request->directive_id;
            // $user_id=Auth::id();

            // $uii=TechnicalDirective::get_directive_user($user_id,$directive_id)[0];
            // ReadState::mark_read_user($directive_id,'DIRECTIVE',$user_id);
            $directive = TechnicalDirective::find($request->directive_id);
            
          
                   
            return view('support.technical_directives.show')->with('directive',$directive);
        }














}
