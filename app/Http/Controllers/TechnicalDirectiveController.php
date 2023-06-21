<?php

namespace App\Http\Controllers;

use File;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\MailOut;
use App\Http\Requests;
use App\Models\Country;
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
  
    // GET CREATE (view create form)
    public function create()
    {
        $models=MotorModel::all();
        return view('support.technical_directives.directive', ["models"=>$models, "submit"=>"create"]);
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

        //# TODO: SAVE DIRECTIVE FILE...
        $file=$request->file('directivefile');

        // Save directive
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



        return Redirect()->route('technical_directives.index');
                        

    }





        /**
         * Show Technical Report List (index route)
         *
         */
        public function index()
        {
            // $user_id=Auth::id();
            // $uii=TechnicalDirective::get_directives_list_user($user_id);
            // $technical_directives = TechnicalDirective::all();
            $technical_directives = TechnicalDirective::with('motorCountries','motorModels')->get();

            return view('support.technical_directives.list')->with('technical_directives',$technical_directives);
        }



        /**
         * Show Technical Report
         *
         */
        public function show(Request $request)
        {
            $directive_id = $request->directive_id;
            // $user_id=Auth::id();

            // $uii=TechnicalDirective::get_directive_user($user_id,$directive_id)[0];
            // ReadState::mark_read_user($directive_id,'DIRECTIVE',$user_id);
            // $directive = TechnicalDirective::find($request->directive_id);
            $directive = TechnicalDirective::with('motorCountries','motorModels')->find($directive_id);
            $models=MotorModel::all();
            
          
                   
            // return view('support.technical_directives.show', ["directive"=>$directive]);
            return view('support.technical_directives.directive', ["directive"=>$directive, "models"=>$models, "submit"=>"show"]);
        }














}
