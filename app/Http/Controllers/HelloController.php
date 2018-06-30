<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
  
   public function index()
   {
       $data = ['AAA','BBB','CCC','DDD'];
       return view('hello.index', ['data'=>$data]);
   }

}

