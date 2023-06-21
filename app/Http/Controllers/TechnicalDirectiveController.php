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
        return view('support.technical_directives.directive', ["models"=>$models, "action"=>"create"]);
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

        $directive = new TechnicalDirective();


        $directive->subject=$request->subject;
        $directive->notes=$request->notes;
        $directive->state=$request->state;
        $directive->agent_id=Auth::user()->id;

        //# TODO: SAVE DIRECTIVE FILE...
        $file=$request->file('directivefile');

        // Save directive
        $directive->save();



        // ATTACH MOTOR MODELS TO DIRECTIVE

        $motorModelIds = $request->input('models');
        $directive->motorModels()->attach($motorModelIds);

        $motorCountryIds = $request->input('countries');
        $directive->motorCountries()->attach($motorCountryIds);

        

        return Redirect()->route('technical_directives.index');
                        

    }





        /**
         * Show Technical Directive List (index route)
         *
         */
        public function index()
        {
            $technical_directives = TechnicalDirective::with('motorCountries','motorModels')->get();
            return view('support.technical_directives.list')->with('technical_directives',$technical_directives);
        }



        /**
         * Show Technical Directive
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
            
          
                
            return view('support.technical_directives.directive', ["directive"=>$directive, "models"=>$models, "action"=>"show"]);
        }


         /**
         * Form Edit Technical Directive
         *
         */
        public function edit(Request $request)
        {
            $directive_id = $request->directive_id;
            $directive = TechnicalDirective::with('motorCountries','motorModels')->find($directive_id);
            $models=MotorModel::all();
            return view('support.technical_directives.directive', ["directive"=>$directive, "models"=>$models, "action"=>"edit"]);
        }


         /**
         * PUT Update Technical Directive
         *
         */
        public function update(Request $request)
        {

            $validated = $request->validate([
                'subject' => 'required',
                'notes' => 'nullable',
                'directivefile' => 'nullable',
                'models' => 'required',
                'countries' => 'nullable',
                'state' => 'required',
            ]);

            $directive_id = $request->directive_id;
            $directive = TechnicalDirective::find($directive_id);
            $directive->subject=$request->subject;
            $directive->notes=$request->notes;
            $directive->state=$request->state;
            $directive->agent_id=Auth::user()->id;

            $directive->motorModels()->detach();               // remove old relationships
            $motorModelIds = $request->input('models');     
            $directive->motorModels()->attach($motorModelIds); // add new relationships
            
            $directive->motorCountries()->detach();                    // remove old relationships
            $motorCountryIds = $request->input('countries');
            $directive->motorCountries()->attach($motorCountryIds);    // add new relationships



            
            //# TODO: SAVE DIRECTIVE FILE...
            $file=$request->file('directivefile');


            $directive->save();

            return redirect()->route('directive.index');

        }




        
         /**
         * Delete Technical Directive
         *
         */
        public function destroy(Request $request,$directive_id)
        {
            // $directive_id = $request()->directive_id;
            $directive = TechnicalDirective::find($directive_id);
            $directive->delete();
            return redirect()->route('directive.index');
        }













}
