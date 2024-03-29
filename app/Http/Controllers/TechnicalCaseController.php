<?php

namespace App\Http\Controllers;

use File;
use DataTables;
use Carbon\Carbon;
use App\Models\Vin;
use App\Models\User;
use App\Http\Requests;
use App\Models\Country;
use App\Models\Message;
use Illuminate\View\View;
use App\Models\CaseStatus;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\Jobs\SendCaseEmail;
use Illuminate\Http\Request;
use App\Models\TechnicalCase;

use App\Mail\MessageToFactory;
use App\Mail\ReviseCaseMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Dcblogdev\MsGraph\Models\MsGraphToken;
use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Vtzimpl\MsgraphMailHandler\MsgraphMailHandler;


class TechnicalCaseController extends Controller
{

    //* CLASS VARIABLES AND METHODS
    protected $cases_path = 'cases/';   // relative to disk public (storage/app/public). (Use: $this->cases_path)
    protected function storage_path($case_id)      
    { 
        return 'public/cases/'.$case_id.'/';
    }
    protected function case_public_folder($case_id)     // for public access with url
    { 
        return '/storage/cases/'.$case_id.'/';
    } 



    //* GET - CREATE CASE FORM
    public function create()
    {
        return view('support.technical_cases.case',[/*"models"=>$models,*/ "action"=>"create"]);
    }



    //* GET - EDIT CASE
    public function edit(Request $request)
    {
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);
        $photos = Storage::disk('public')->files($this->cases_path.$case_id);        // get files array (all files in cases folder)
        $photos_path = $this->case_public_folder($case_id);                         // path for URL is different from path for Storage::disk
        $action = "edit";
        return view('support.technical_cases.case', compact('case', 'photos', 'photos_path', 'action'));
    }



    //* GET - SHOW CASE FILES
    public function files(Request $request)
    {
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);
        $photos = Storage::disk('public')->files($this->cases_path.$case_id);        // get files array (all files in cases folder)
        $photos_path = $this->case_public_folder($case_id);                         // path for URL is different from path for Storage::disk
        return view('support.technical_cases.photos', compact('case','photos', 'photos_path'));
    }



    //* GET - REVIEW & EDIT CASE by Nipponia
    public function review(Request $request)
    {
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);
        $statuses = CaseStatus::All();
        $countries = Country::All();
        $photos = Storage::disk('public')->files($this->cases_path.$case_id);        // get files array (all files in cases folder)
        $photos_path = $this->case_public_folder($case_id);                         // path for URL is different from path for Storage::disk
        @$action = "review";
        return view('support.technical_cases.casereview', compact('case', 'photos', 'photos_path', 'action', 'statuses','countries'));
    }


    //* GET - SHOW FULL CASE by Nipponia basic User
    public function show(Request $request)
    {
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);
        $statuses = CaseStatus::All();
        $countries = Country::All();
        $photos = Storage::disk('public')->files($this->cases_path.$case_id);        // get files array (all files in cases folder)
        $photos_path = $this->case_public_folder($case_id);                         // path for URL is different from path for Storage::disk
        @$action = "shoW";
        return view('support.technical_cases.casereview', compact('case', 'photos', 'photos_path', 'action', 'statuses','countries'));
    }



    //* GET - EDIT REPORT CASE LIST (index route)
    public function index()
    {
        $user_country = Auth::user()->country_id;
        if (!$user_country) {   // not restricted
            $technical_cases = TechnicalCase::with(['user','status'])->get();
        } else {
            $technical_cases = TechnicalCase::with(['user','status'])
                ->where('country_id', $user_country)        //->orWhere('country_id', '')
                ->get();
        }
        
        return view('support.technical_cases.list',['technical_cases'=>$technical_cases,'pending'=>false]);
    }
    
    
 
    //* GET - EDIT PENDING CASE LIST (indexpending route)
    public function indexpending()
    {
        $user_country = Auth::user()->country_id;
        if (!$user_country) {       // user sees all countries
            $technical_cases = TechnicalCase::with(['user','status'])
                ->whereHas('status', function($query)         // where case->status->statuscategory is one of ["Initial", "Pending"]
                    {
                        $query->whereIn('statuscategory', ["Initial", "Pending"]); 
                    })
                ->get();
        } else {
            $technical_cases = TechnicalCase::with(['user','status'])
                ->where('country_id', $user_country)
                ->whereHas('status', function($query)         // where case->status->statuscategory is one of ["Initial", "Pending"]
                    {
                        $query->whereIn('statuscategory', ["Initial", "Pending"]); 
                    })
                ->get();

        }

            return view('support.technical_cases.list', ['technical_cases'=>$technical_cases , 'pending'=>true]);
    }   




    /** 
     * Create (insert new in db) Case
     *
     * @return mixed
     */
    public function store(Request $request): mixed
    {

        $validated = $request->validate([
            'subject' => 'required',
            'description' => 'nullable',
            'model' => "required",     
            // 'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'purchase_order' => 'nullable',
            'vins' => 'required',
        ]);
       

        $case = new TechnicalCase();

        $case->subject=$request->subject;
        $case->description=$request->description;
        $case->user_id=Auth::user()->id;
        $case->country_id=Auth::user()->country_id;
        // $message=$description;
        // $user_email = Auth::user()->email;
        // $date=Carbon::now();
        // $files=$request->file('photos');
        // $isaclaim=$request->isaclaim?1:0;
        $case->model=$request->model;
        $case->purchase_order=$request->purchase_order;
        $case->status_id=1;     //Pending Nipponia
        $case->save();          // save case to get case_id



        foreach($request->vins as $vin){
            $vin_array = explode(',',$vin);     // string to array
            $new_vin = Vin::create(['vin'=>$vin_array[0], 'distance'=>$vin_array[1], 'case_id'=>$case->id]);    // array to associative array
        } 


        // Save files
        $photos=$request->file('photos');
        foreach ($photos??[] as $photo) {
            $filename = 'case'.$case->id.'-'.uniqid() . '.' . $photo->extension();
            Storage::putFileAs($this->storage_path($case->id), $photo, $filename);
        }

        dispatch(New SendCaseEmail(['case'=>$case,'action'=>'new']));

        return redirect()->route('cases.index')->with('success',"Case created!");
                                        

    }



 /** 
     * Update (update in db) Case by the customer that created it
     *
     * @return mixed
     */
    public function update(Request $request): mixed
    {

        $validated = $request->validate([
            'subject' => 'required',
            'description' => 'nullable',
            'model' => "required",     
            // 'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'purchase_order' => 'nullable',
            'vins' => 'required',
        ]);
       
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);

        $case->subject=$request->subject;
        $case->description=$request->description;
        $case->user_id=Auth::user()->id;
        // $message=$description;
        // $user_email = Auth::user()->email;
        // $date=Carbon::now();
        // $files=$request->file('photos');
        // $isaclaim=$request->isaclaim?1:0;
        $case->model=$request->model;
        $case->purchase_order=$request->purchase_order;
        
        $case->save();


        // update associated vins
        $case->vins()->delete();    // delete all old associated vins
        foreach($request->vins as $vin){
            $vin_array = explode(',',$vin);     // string to array
            $new_vin = Vin::create(['vin'=>$vin_array[0], 'distance'=>$vin_array[1], 'case_id'=>$case_id]);    // array to associative array
        } 


        // Store new uploaded files
        $photos=$request->file('photos');
        foreach ($photos??[] as $photo) {
            $filename = 'case'.$case->id.'-'.uniqid() . '.' . $photo->extension();
            Storage::putFileAs($this->storage_path($case->id), $photo, $filename);
        }

        // dispatch(New SendCaseEmail(['case'=>$case,'action'=>'new']));  // send email
        // SendCaseEmail::dispatchAfterResponse(['case'=>$case,'action'=>'new']);  // send email
        
        return redirect()->back()->with('success',"Case updated!");      // refresh page
                                        
    }




 /** 
     * Revise (update in db) Case by a Nipponia Member
     *
     * @return mixed
     */
    public function revise(Request $request): mixed
    {

        $validation = $request->validate([
            'subject' => 'required',
            'description' => 'nullable',
            // 'model' => "required",     
            // 'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'purchase_order' => 'nullable',
        ]);
       
        $case_id = $request->case_id;
        $case = TechnicalCase::find($case_id);

        $case->subject=$request->subject;
        // $case->description=$request->description;    // not editable by Nipponia Member
        // $message=$description;
        $case->agent_id=Auth::user()->id;
        $case->country_id=$request->country;
        // $user_email = Auth::user()->email;
        // $date=Carbon::now();
        // $files=$request->file('photos');
        // $isaclaim=$request->isaclaim?1:0;
        $case->model=$request->model;

        $case->category=$request->category;
        $case->issue=$request->issue;
        $case->part=$request->part;

        $case->purchase_order=$request->purchase_order;
        $case->status_id=$request->status;
        $case->notes=$request->notes;
        $case->approved=$request->approved;
        $case->reminder=$request->reminder;
        if ($request->reminder_desc){       // το έχω έτσι, ώστε αν γίνει disabled το πεδίο, να μην χαλάει η παλιά τιμή του.
            $case->reminder_desc=$request->reminder_desc;
        }

        $case->save(); 



        // update associated vins
        $case->vins()->delete();    // delete all old associated vins
        foreach($request->vins as $vin){
            $vin_array = explode(',',$vin);     // string to array
            $new_vin = Vin::create(['vin'=>$vin_array[0], 'distance'=>$vin_array[1], 'case_id'=>$case_id]);    // array to associative array
        } 

        if (!$request->donotmail){
            dispatch(New SendCaseEmail(['case'=>$case,'action'=>'revise']));  // send email
            // Mail::to('Ismini.Zounta@nipponia.com')->send(new ReviseCaseMessage($case));  
        }
        
        return redirect()->back()->with('success', 'Case updated!');      // refresh page
        

    }







    //* DELETE FILE FROM CASE
    public function destroyfile(Request $request)
    {
        $case_id = $request->case_id;
        $filename = $request->filename;
        Storage::delete($this->storage_path($case_id).'/'.$filename);

        return response()->noContent();
    }
    
    
    




     /** 
     * Message To Factory
     *
     * @return mixed
     */
    public function messageToFactory(Request $request): mixed
    {
        // return $request;
        Mail::send(new MessageToFactory($request));
        return redirect()->back()->with('success',"E-mail was sent!");;      // refresh page
    }






    /**
     * update (insert new message in db) Technical report
     *
     * @return mixed
     */
    public function update_new_message(Request $request): mixed
    {
        $dt = Carbon::now();
        $nowdate=$dt->format('Ymd'); 
        $files = $request->file('photos');
        $support_case_id=$request->supportid;
        $message=$request->message;
        $user_id=Auth::id();
        $uii_array=DB::select(DB::raw('SELECT * FROM `list_tr` WHERE id='.$support_case_id.' ;'));
        $caseuserid=$uii_array[0]->nameid;

      //  if (Gate::allows('view-case')) {
     //      abort(403, "You can't edit this msg!");
       
     //   }


     //$this->authorize('view-case',$caseuserid);

     $date = Carbon::now();


     $new_message_id=Message::create(
        [
            'support_case_id' => $support_case_id,
            'message' => $message,
            'subject' => "",
            'user_id' => $user_id,
                    'message_type'=>"client"
        
        ]
               )->id;
    if( $user_id!=$caseuserid)
     {
        $status=2;
        DB::select(DB::raw('UPDATE `support_cases` SET status_id='.$status.';'));
     }
     $directory=$this->create_message_folder($new_message_id, $support_case_id,true);
     $stored=$this->store_files($files,$directory);
return Redirect::to('/technical_cases/toedit/'.$support_case_id);
     }



 /**
     * update (insert new message in db) Technical report
     *
     * @return mixed
     */
    public function update_summary(Request $request): mixed
    {
        $dt = Carbon::now();
        $nowdate=$dt->format('Ymd'); 
        $support_case_id=$request->supportid;
        $summary=$request->casesummary;
        $user_id=Auth::id();
        $status=!is_null($request->status)?$request->status:0;
        $issue1=!is_null($request->issue1)?$request->issue1:0;
        $issue2=!is_null($request->issue2)?$request->issue2:0;
        $issue3=!is_null($request->issue3)?$request->issue3:0;
        $claim_approved=$request->claimapproved;
        $claim_approved=$claim_approved==='on'?1:0;
        //dd( $claim_approved);
        $nextorderreminder=!is_null($request->nextorderreminder)?1:0;
        $nextorderremindert=$request->nextorderremindert;
//dd($nextorderreminder);
        DB::select(DB::raw('UPDATE `support_cases` SET  summary="'.$summary.'",status_id="'.$status.'",claim_approved="'.$claim_approved.'", issue1='.$issue1.', `issue2`='.$issue2.', `issue3`='.$issue3.', `nextorderreminder`='.$nextorderreminder.', `nextorderremindert`="'.$nextorderremindert.'" WHERE id='.$support_case_id.';'));
   
return Redirect::to('/technical_cases/toedit/'.$support_case_id);
                       

    }
















       


        //////////////////////////////////helper functions/////////////////////////
        //ayto epistrefei json gia na gemisei ta selects sto summary


        public function fetch_select_children(Request $request)
        {
           $parent = intval($request->input('parent'));
           $uii = DB::table('issues_categories')->select('id','issuename')->where('childof',$parent)->get();
           return response()->json(['data'=>$uii]);
         }


        //ayto epistrefei model se json gia sygkekrimeno vin


        public function fetch_model_for_vin(Request $request)
        {
           $vin = $request->vin;
           $uii = DB::table('motos_vins')->select('model_desc')->where('vin',$vin)->get();
           //$uii ='gfg';
           return response()->json(['model_ajax'=>$uii]);
         }






         public function send_ext_tr_new($data)
         {
     $recipients=$data['to'];
     
             Mail::to($recipients)->send(
                 new MailOut($data,"send_ext_tr_new")
             );
     
             return redirect()->back()->withStatus('Case was created!');
         }
     
     
         public function send_ext_tr_new_vendor($data)
         {
     $recipients=$data['to'];
             Mail::to($recipients)->send(
                 new MailOut($data,"send_ext_tr_new_vendor")
             );
     
             return redirect()->back()->withStatus('Message Sent!');
         }

         public function get_customer_files($reportt,$messages)
         {
             $files=array();
             $number_of_files=0;
             foreach ($messages as $message){
                 $files[$message->messageid]=Storage::disk('public')->files($reportt."/".$message->messageid);
                
                 $number_of_files+=count($files[$message->messageid]);
             }
             //dd($files);
         return ['files'=>$files,'number_of_files'=>$number_of_files];
         }
         
         public function create_message_folder($new_message_id, $support_case_id,$isnewcase)
         {
             if($isnewcase)
                    {
                 Storage::makeDirectory($support_case_id);
                     }
             $directory=$support_case_id."/".$new_message_id;
             Storage::makeDirectory( $directory);
             return  $directory;
         }



         public function store_files($files,$directory)
         {
             $allowedfileExtension=['pdf','jpg','avi','mp4','png','docx','PNG'];
             $stored=false;
         if( !is_null($files)) 
                    {   
                foreach($files as $file)
                {
                                $filename = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $originalName = $file->getClientOriginalName();
                                $check=in_array($extension,$allowedfileExtension);
                                $stored=($stored or $check)?true:false;
                                //dd($file);
                                if($check)
                                {
                                        Storage::putFileAs($directory, $file, $originalName);
                                }
         
                }
         
            }
         
         
                             if (!$stored)
         
                             {
                                 Storage::deleteDirectory($directory);
         
                             }
         return $stored;
         }
         
       
         




         public function input_vins($vins_table,$distance_table,$case)
         {
     

                $arraylength=count($vins_table);

                    for ($x = 0; $x < $arraylength; $x++) {
                        DB::table('vin_to_cases')-> insert(array('vin' => $vins_table[$x],'distancekm' => $distance_table[$x],'case' => $case));
                    } 

            return true;
         }































}