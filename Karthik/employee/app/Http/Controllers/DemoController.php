<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    //
    public function demo(Request $request){
        $token=$request->get('usertoken');
        dd($token);
    }
}
