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
use App\Models\TechnicalReport;

class ReportsController extends Controller
{
  
    
    public function vin_search()
    {

        $uii=DB::select(DB::raw('SELECT vin_to_cases.case as cas , vin_to_cases.vin as vi, technical_cases.subject  as sub FROM vin_to_cases JOIN technical_cases ON vin_to_cases.case=technical_cases.id;'));

     


        //$hasManageUser = Auth::user()->can('manage_user');
        
      
      return view('reports.vin_search')->with('uii',$uii);
    }




















    
}
