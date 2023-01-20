<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use App\Models\ReadState;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




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
        $user_id=Auth::id();
           $unread_directives=ReadState::number_unread_user('DIRECTIVE',$user_id);
           
        return view('nippo.home')->with('unread_directives',$unread_directives);;
    }




}
