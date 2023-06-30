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
use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Dcblogdev\MsGraph\Models\MsGraphToken;

use Vtzimpl\MsgraphMailHandler\MsgraphMailHandler;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\Models\TechnicalCase;


class TechnicalCaseController extends Controller
{

    //* CLASS VARIABLES AND METHODS
    protected $cases_path = 'public/cases/';   // relative to storage/app/. Use: $this->cases_path



    //* GET - CREATE REPORT FORM
    public function create()
    {
      return view('support.technical_cases.initreport',[/*"models"=>$models,*/ "action"=>"create"]);
    }



    //* GET - EDIT REPORT
    public function edit(Request $request)
    {
         $report_id = $request->report_id;
         $report = TechnicalCase::find($report_id);
        //  $support_case_array=TechnicalReport::list_tr_one($reportt);
        //  $support_case=$support_case_array[0]; //gia na paroume ton pinaka mono
        //  $video_extensions=array("mp4","avi");
        //  $statuses_array=DB::select(DB::raw('SELECT id, statusname FROM `case_status` WHERE statuscategory="Technical Report" ;'));
        //  $categories_array=DB::select(DB::raw('SELECT id, issuename FROM `issues_categories` WHERE type="Issue1" ;'));
        //  $issues_array=DB::select(DB::raw('SELECT id, issuename FROM `issues_categories` WHERE type="Issue2" ;'));
        //  $specifymore_array=DB::select(DB::raw('SELECT id, issuename FROM `issues_categories` WHERE type="Issue3" ;'));

        return view('support.technical_cases.initreport', ['report'=>$report, "action"=>"edit"]);
    }





    //* GET - EDIT REPORT LIST (index route)
    public function index()
    {
        
        // $user_id=Auth::id();
        // $user_role=DB::select(DB::raw(' SELECT roleid, rolename FROM  users_with_role WHERE id='. $user_id.';'))[0];
        // //dd($user_role);
        // //$uii=DB::select(DB::raw('SELECT support_cases.subject as subject, support_cases.id as id,support_cases.po as po, support_cases.description as description, support_cases.created_at as created_at, users.name as name, support_cases.attached_files_folder_path as attached_files_folder_path FROM support_cases INNER JOIN users ON support_cases.user_id=users.id;'));
        // $user_role_name=$user_role->rolename;
    
        // if($user_role_name==="Admin" or $user_role_name==="Super Admin" or $user_role_name==="Agent HQ")
        // {
        //     //$uii=DB::select(DB::raw(' SELECT * FROM  list_tr ;'));
            // $uii=TechnicalCas::list_tr_all();
        //     //dd($uii);
        
        // }else
        // {
        //     $uii=DB::select(DB::raw(' SELECT * FROM  list_tr WHERE roleid='. $user_role->roleid.';'));

        // }
        

        $technical_cases = TechnicalCase::all();
        return view('support.technical_cases.list')->with('technical_cases',$technical_cases);
    }
    
    
    



 /** 
     * Create (insert new in db) Technical report
     *
     * @return mixed
     */
    public function store(Request $request): mixed
    {

        $validated = $request->validate([
            'subject' => 'required',
            'description' => 'nullable',
            // 'model' => "required",     
            'models' => 'nullable', //old code where models was many-to-many relationship, not text
            'purchase_order' => 'required',
        ]);
       

        $report = new TechnicalReport();

        $report->subject=$request->subject;
        $report->description=$request->description;
        // $message=$description;
        $report->user_id=Auth::user()->id;
        // $user_email = Auth::user()->email;
        // $date=Carbon::now();
        // $files=$request->file('photos');
        // $isaclaim=$request->isaclaim?1:0;
        $report->po=$request->purchase_order;
        $report->status_id=1;//Waiting for Nipponia
        $report->save(); 
        // $vin_table=$request->vin_table;
        // $distance_table=$request->distance_table;
        //dd($vin_table);
        // $support_case_id=DB::table('support_cases')-> insertGetId(array('subject' => $subject,'description' => $description,'user_id' => $user_id,'created_at'=>$date,'status_id'=>$status_id,'po'=>$po,'isaclaim'=>$isaclaim));
        // $new_message_id=Message::create(
        //     [
        //         'support_case_id' => $support_case_id,
        //         'message' => $message,
        //         'subject' => $subject,
        //         'user_id' => $user_id,
        //         'updated_at'=>$date,
        //         'message_type'=>"client"
            
        //     ]
        // )->id;

        // $this->input_vins( $vin_table,$distance_table,$support_case_id);
       // $new_message_id = DB::table('messages')-> insertGetId(array('support_case_id' => $support_case_id,'message' => $message,'subject' => $subject,'user_id' => $user_id,'updated_at'=>$date, 'mail_type'=>"client"));
        //$new_message_id=Message::create_messages_client($support_case_id);//kalyterh yplopoihsh me classes
        // $directory=$this->create_message_folder($new_message_id, $support_case_id,true);
        // $stored=$this->store_files($files,$directory);
        //  DB::table('support_cases')->where('id',$support_case_id)->update(['attached_files_folder_path' => $directory]);
          
//models

                        // if( !is_null($models)) 
                        // {     

                        //     foreach($models as $model)
                        //     {
                        //         DB::table('relations')-> insert(array('source' => $model,'relation_type' => "model_is_mentioned_in",'destination'=>$support_case_id));

                        //     }

                        // }

                    //models

                    // $ccemail=DB::table('relations')->where('relation_type', 'ccemail')->first()->destination_text;
                    //mail
                    // $data=array("subject"=>$subject." case__".$support_case_id);
                    // $data['casenbr']=$support_case_id;
                    // $data['linkto']=url('technical_cases/toedit/'.$support_case_id);
                    // //$data['to']='vtzimpl@yahoo.gr';
                    // $data['to']=[$ccemail, $user_email];
                    // $this->send_ext_tr_new($data);
                    //mail


                    return redirect()->route('cases.index');
                                        

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