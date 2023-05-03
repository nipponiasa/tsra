<?php

namespace App\Http\Controllers;


use App\Models\ReadState;
use Illuminate\View\View;
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
        $directives = TechnicalDirective::count();
        $reports = TechnicalReport::count();
           
        // return view('nippo.home')->with('unread_directives',$unread_directives);;
        return view('nippo.home', compact('directives', 'reports'));
    }




}
