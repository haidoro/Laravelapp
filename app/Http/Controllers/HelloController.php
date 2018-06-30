<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
    	$data = [
    		'msg'=>'これはBladeを利用したメッセージです。',
    	];
    	return view('hello.index',$data);
    }
}
