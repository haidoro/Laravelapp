<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(Request $request){
    	$data = [
    		'msg'=>'これはコントローラーから渡されたメッセージです。',
    		'id'=>$request -> id
    	];
    	return view('hello.index',$data);
    }
}
