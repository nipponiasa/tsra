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
    
    //* CLASS VARIABLES AND METHODS
    protected $directives_path = 'public/directives/';   // relative to storage/app/. Use: $this->directives_path



    //* GET - CREATE DIRECTIVE (view create form)
    public function create()
    {
        $models=MotorModel::all();
        return view('support.technical_directives.directive', [/*"models"=>$models,*/ "action"=>"create"]);
    }



    //* POST - CREATE DIRECTIVE
    public function store(Request $request)   
    {
            
        $validation = $request->validate([
            'subject' => 'required',
            'notes' => 'nullable',
            'model' => "required",     
            // 'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'countries' => 'nullable',
            'state' => 'required',
            'directivefile' => 'nullable|mimes:pdf|max:5000',
        ]);


        // SAVE DIRECTIVE

        $directive = new TechnicalDirective();

        $directive->subject = $request->subject;
        $directive->notes = $request->notes;
        $directive->model = $request->model;
        $directive->state = $request->state;
        $directive->agent_id = Auth::user()->id;

        // Construct FileName
        $file=$request->file('directivefile');
        if ($file) {
            $filename = uniqid() . '.' . $file->extension();
            $directive->filename = $filename;     // store this to database
        }
        
        // Save directive and get an id
        $directive->save();
        
        
        
        // ATTACH MOTOR MODELS TO DIRECTIVE
        
        //old code where models was many-to-many relationship, not text
        // $motorModelIds = $request->input('models');
        // $directive->motorModels()->attach($motorModelIds);

        $motorCountryIds = $request->input('countries');
        $directive->motorCountries()->attach($motorCountryIds);
        
        
        // SAVE FILE TO DISK (case must be saved first to get an id)
        if ($file) {
            Storage::putFileAs($this->directives_path.$directive->id, $file, $filename);
        }

        

        return Redirect()->route('directives.index');
                        

    }





    //* SHOW TECHNICAL DIRECTIVE LIST (index route)
    public function index()
    {
        $technical_directives = TechnicalDirective::with('motorCountries'/*,'motorModels'*/)->get();
        return view('support.technical_directives.list')->with('technical_directives',$technical_directives);
    }




    //* SHOW TECHNICAL DIRECTIVE
    public function show(Request $request)
    {
        $directive_id = $request->directive_id;
        // $user_id=Auth::id();

        // $uii=TechnicalDirective::get_directive_user($user_id,$directive_id)[0];
        // ReadState::mark_read_user($directive_id,'DIRECTIVE',$user_id);
        // $directive = TechnicalDirective::find($request->directive_id);
        $directive = TechnicalDirective::with('motorCountries'/*,'motorModels'*/)->find($directive_id);
        // $models=MotorModel::all();
            
        return view('support.technical_directives.directive', ["directive"=>$directive, /*"models"=>$models,*/ "action"=>"show"]);
    }



    //* GET - FORM EDIT TECHNICAL DIRECTIVE
    public function edit(Request $request)
    {
        $directive_id = $request->directive_id;
        $directive = TechnicalDirective::with('motorCountries'/*,'motorModels'*/)->find($directive_id);
        // $models = MotorModel::all();
        return view('support.technical_directives.directive', ["directive"=>$directive, /*"models"=>$models,*/ "action"=>"edit"]);
    }



    //* PUT - UPDATE TECHNICAL DIRECTIVE
    public function update(Request $request)
    {

        $validation = $request->validate([
            'subject' => 'required',
            'notes' => 'nullable',
            'model' => "required",     
            // 'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'countries' => 'nullable',
            'state' => 'required',
            'directivefile' => 'nullable|mimes:pdf|max:5000',
        ]);

        $directive_id = $request->directive_id;
        $directive = TechnicalDirective::find($directive_id);
        $directive->subject = $request->subject;
        $directive->notes = $request->notes;
        $directive->model = $request->model;
        $directive->state = $request->state;
        $directive->agent_id = Auth::user()->id;



        // DETACH & ATTACH NEW RELATIONSHIPS

        //old code where models was many-to-many relationship, not text
        // $directive->motorModels()->detach();               // remove old relationships
        // $motorModelIds = $request->input('models');     
        // $directive->motorModels()->attach($motorModelIds); // add new relationships
        
        $directive->motorCountries()->detach();                    // remove old relationships
        $motorCountryIds = $request->input('countries');
        $directive->motorCountries()->attach($motorCountryIds);    // add new relationships



        
        // UPDATE DIRECTIVE FILE...
        $old_filename = $directive->filename;
        $file = $request->file('directivefile');
        if ($file && $old_filename) {
            //* Αν επιτρέψουμε και άλλα είδη αρχείων, εκτός από pdf, τότε θα πρέπει να τροποποιηθεί αυτό (να γίνει διαγραφή αρχείου και ενημέρωση βάσης).
            Storage::putFileAs($this->directives_path.$directive->id, $file, $old_filename);    
        } elseif ($file && !$old_filename) {
            $filename = uniqid() . '.' . $file->extension();            
            $directive->filename = $filename;     // store this to database
            Storage::putFileAs($this->directives_path.$directive->id, $file, $filename);
        }



        $directive->save();

        return redirect()->route('directives.index');

    }




    

     //* DELETE TECHNICAL DIRECTIVE
    public function destroy(Request $request,$directive_id)
    {
        // $directive_id = $request()->directive_id;
        $directive = TechnicalDirective::find($directive_id);
        Storage::deleteDirectory('public/directives/'.$directive_id);
        $directive->delete();
        return redirect()->route('directives.index');
    }













}
