<?php

namespace App\Http\Controllers;


use App\Models\ReadState;
use Illuminate\View\View;
use App\Models\TechnicalCase;
use App\Models\TechnicalReport;
use App\Models\TechnicalDirective;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;




class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function clearCache(): View
    {
        Artisan::call('cache:clear');

        return view('clear-cache');
    }


    public function dashboard(): View
    {
        // $user_id=Auth::id();
        //    $unread_directives=ReadState::number_unread_user('DIRECTIVE',$user_id);

        $user_country = Auth::user()->country_id;
        if (!$user_country) {       // not restricted
            $directives = TechnicalDirective::count();
            $pending_cases = TechnicalCase::whereIn('status_id',['1','2','3'])->count();
            $waiting_cases = TechnicalCase::where('status_id','1')->count();
        } else {
            $directives = TechnicalDirective::whereHas('motorCountries', function ($query) use ($user_country) {
                $query->where('country_id', $user_country);
            })->count();
            $pending_cases = TechnicalCase::where('country_id', $user_country)->whereIn('status_id',['1','2','3'])->count();
            $waiting_cases = TechnicalCase::where('country_id', $user_country)->where('status_id','1')->count();
        }

        return view('nippo.home', compact('directives', 'pending_cases', 'waiting_cases'));
    }




}
