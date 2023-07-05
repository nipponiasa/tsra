<?php

namespace App\Http\Controllers;
use File;
use DataTables;
use Carbon\Carbon;
use App\Models\Vin;
use App\Models\User;
use App\Mail\MailOut;
use App\Http\Requests;
use App\Models\Message;
use Illuminate\View\View;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Http\Request;
use App\Models\TechnicalReport;
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

class ReportsController extends Controller
{
  
    
    public function casespervin()
    {

        // $uii=DB::select(DB::raw('SELECT vins.case_id as cas , vins.vin as vi, technical_cases.subject  as sub FROM vins JOIN technical_cases ON vins.case_id=technical_cases.id;'));

        $vins = Vin::all();


        //$hasManageUser = Auth::user()->can('manage_user');
        
      
      return view('reports.casespervin')->with('vins',$vins);
    }




















    
}
