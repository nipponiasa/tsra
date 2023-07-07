<?php

namespace App\Http\Controllers;

use App\Mail\NewCaseMessage;
use Illuminate\Http\Request;
use App\Mail\MessageToFactory;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{

    //* GET - CREATE DIRECTIVE (view create form)
    public function test()
    {
        Mail::to('test@google.com')->send(new NewCaseMessage());
        return "OK!";
    }
}
