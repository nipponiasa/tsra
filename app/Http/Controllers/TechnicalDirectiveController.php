<?php

namespace App\Http\Controllers;

use File;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\MailOut;
use App\Http\Requests;
use App\Models\Message;
use App\Models\ReadState;
use App\Models\MotorModel;
use Illuminate\Http\Request;
use App\Models\TechnicalDirective;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class TechnicalDirectiveController extends Controller
{
  
    // GET CREATE
    public function create()
    {
        $models=MotorModel::all();
        return view('support.technical_directives.directive', ["models"=>$models]);
    }





    // POST CREATE
    public function store(Request $request)   
    {
            

        $validated = $request->validate([
            'subject' => 'required',
            'notes' => 'nullable',
            'directivefile' => 'nullable',
            'models' => 'required',
            'countries' => 'nullable',
            'state' => 'required',
        ]);


        // SAVE DIRECTIVE

        $technicaldirective = new TechnicalDirective();


        $technicaldirective->subject=$request->subject;
        $technicaldirective->notes=$request->notes;
        $technicaldirective->state=$request->state;
        $technicaldirective->agent_id=Auth::user()->id;

        // SAVE DIRECTIVE FILE...
        $file=$request->file('directivefile');

        $technicaldirective->save();



        // ATTACH MOTOR MODELS TO DIRECTIVE

        // $directive_id=$technicaldirective->id;
        $motorModelIds = $request->input('models');
        $technicaldirective->motorModels()->attach($motorModelIds);

        $motorCountryIds = $request->input('countries');
        $technicaldirective->motorCountries()->attach($motorCountryIds);

        
        //models

        // if( !is_null($models)) 
        // {     

        //     foreach($models as $model)
        //     {
        //         DB::table('relations')-> insert(array('source' =>$directive_id ,'relation_type' => "directives_for_model",'destination'=>$model));

        //     }

        // }

        //models
        // ReadState::mark_unread($directive_id,"DIRECTIVE");



        // $agent_email = Auth::user()->email;
        // $date=Carbon::now();
        //dd( $technicaldirective);



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
        public function show(Request $request)
        {
            // $directive_id = $request->directive_id;
            // $user_id=Auth::id();

            // $uii=TechnicalDirective::get_directive_user($user_id,$directive_id)[0];
            // ReadState::mark_read_user($directive_id,'DIRECTIVE',$user_id);
            $directive = TechnicalDirective::find($request->directive_id);
            
          
                   
            return view('support.technical_directives.show', ["directive"=>$directive]);
        }














}
