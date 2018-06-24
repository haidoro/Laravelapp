<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index($first_name='none',$second_name='none'){
    	return <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Hello | index</title>
	<style>
	h1{
		color:blue;
	}
	</style>
</head>
<body>
<h1>Hello!</h1>
<p>This is index of Hello Controller.</p>
<p><span>{$first_name}</span> <span>{$second_name}</span></p>
<p><a href="/hello/other">Other page</a></p>
</body>
</html>
EOF;
    }

    public function other(){
    	return <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Hello | index</title>
	<style>
	h1{
		color:blue;
	}
	</style>
</head>
<body>
<h1>Other</h1>
<p>This is index of Other Controller.</p>
</body>
</html>
EOF;
    }
}
