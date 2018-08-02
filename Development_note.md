# Laravel 開発ノート
* Macでの開発例です。
## 開発手順
1. プロジェクトの作成
2. プロフラムの作成
3. サーバーの実行
4. デプロイする

## MacにComposerを導入

Homebrewが導入済みであること。
Composerを探します。

```
brew search composer
```

Composerの導入。

```
brew install composer
```

Composerバージョン確認

```
composer -V
```
## Laravelインストール

最初にComposerで、Laravelインストーラをダウンロードします。

```
composer global require "laravel/installer"
```

次に`create-project`コマンドを実行し、Laravelをインストール  
今回はlaravelappフォルダにlaravelをインストールします。

```
composer create-project --prefer-dist laravel/laravel laravelapp"
```

`cd`でlaravelappフォルダに移動して次のコマンドで「http://localhost:8000/」で初期画面が表示

***Laravel開発時には次のコマンドはよく使いますので覚えておきましょう。***

```
php artisan serve
```
### サーバー停止

artisan serveを停止するには「コントロールキー＋C」

Laravelをインストールすると、色々なフォルダやファイルができますが、まず必要なフォルダは「app」、「routes」、「resources」の3つのフォルダ内のファイルです。

## ルーティングとコントローラー

ルーティングはURLアドレスに対してどのような処理を行うかを管理する仕組みです。

例えば、ブラウザに`localhost:8000/webapp/hello.html`のアドレスを入れるとhello.htmlファイルが表示される仕組みです。

単純な静的なページならハイパーリンクで設定するだけですが、laravelではそのアドレスに対して実行するプログラムを設定する必要があります。

### Laravelのルーティングの仕組み

「routes」フォルダの「web.php」ファイルにルーティングの処理情報があります。

インストールしたばかりの状態では、この中にはルート情報のみ記載されています。

web.phpコード

```
<?php
Route::get('/', function () {
    return view('welcome');
});
```

ルート情報は`Rout::get(アドレス,関数)`で記述されます。

`::`はPHPではダブルコロンと呼ばれ、静的(static)メソッドや静的(static)プロパティを呼び出すときに使用されるものです。  
`static`の特徴はインスタンス化しなくても直接クラスのstaticメソッドやstaticプロパティを`::`で呼び出すことができることです。    
ここではRoutクラスのget()メソッドを呼び出しています。

`view('welcome')`関数は引数に指定されたテンプレートを表示するものです。ここではresource/views/welcome.blade.phpテンプレートを指しています。bladeと拡張子のphpは記述しません。

** `view('welcome')`関数を呼び出すのに無名関数を使うことでクロージャーを活用している点に着目 **

### Helloの表示(Git Branch hello)
ルーティングファイルの「web.php」ファイルを少し編集してみます。以下のように記述を追加します。  
`localhost:8000/hello`とURLを入力するとHelloと表示させます。

web.php
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('hello/', function () {
	return "<html><body><h1>Hello</h1></body></html>";
});
```
#### Rout::getのパラメータについて
URL指定にパラメータを追加することでそのパラメータを表示させることができます。

web.php
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('hello/{msg}', function ($msg) {
	return "<html><body><h1>{$msg}</h1></body></html>";
});
```
URLを`localhost:8000/hello/Hello,world!`と入力すると
Hello,world!と表示されます。

### テンプレートの場所
welcomeテンプレートの場所は「resource/views」フォルダに「welcome.blade.php」ファイルとして用意されています。
テンプレートの作成方法は後ほど学習するとしてファイルの場所を覚えておきましょ。

## Controllerの使い方(Git Branch controller)
###Controllerの作成
以下コマンドでHelloControllerを作成します。
```
php artisan make:controller <コントローラ名>
```
`php artisan make:controller HelloController`とコマンドを入力すると「app/Http/Controllers」フォルダに「HelloController.php」ファイルができます。  
このファイルの内容は以下
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    //
}
```
Controllerクラスを継承したHelloControllerの雛形が作成されました。
* `namespace App\Http\Controllers;`は名前空間の指定
* `use Illuminate\Http\Request;`はRequestクラスを使える状態にしたものです。

## アクションの追加

コントローラーに追加される処理のことをアクションと言います。

クラスHelloControllerの中に具体的な処理を記述します。
例
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
    	return <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Hello | index</title>
</head>
<body>
<h1>Hello!</h1>
<p>This is index of Hello Controller.</p>
	
</body>
</html>
EOF;
    }
}
```

次に、ルート情報の変更を行います。

### ルート情報の変更
「routes」フォルダのweb.phpファイルを変更します。
コントローラーを利用するには第2引数の記述は関数ではなく、`コントローラ名@アクション名`の記述をします。
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('hello', 'HelloController@index');
```
URLに`http://localhost:8000/hello`と入力すると「HelloController.php」ファイルに記述した内容が表示されます。

### ルートパラメータの活用
ルートパラメータをコントローラーで使ってみます。

1. `Route::get()`の第1引数に{}でパラメータを設定します。
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('hello/{first_name?}/{second_name?}', 'HelloController@index');
```
2. HelloController.phpの中でパラメータを使用します。
`index()`の引数にパラメータを設定することを忘れないように。

HelloController.php
```
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
</body>
</html>
EOF;
    }
}
```
URLは`http://localhost:8000/hello/Masaharu/Tahara`のようにします。

## 複数のアクションを利用
1つのコントローラーに複数のアクションを設定することができます。そうすることで、複数の下層ページを作成することができます。

次の例では`HelloController.php`に新しいアクション`other()`を追加します。
```
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
```
ルーティングも変更します。
`index()`アクションの第1引数`hello`を`name`に変更しました。
`http://localhost:8000/name/masaharu/tahara`では問題なく表示されますが、`http://localhost:8000/name/other`としてもother部分を引数と認識してしまい。`index()`アクションのページが開かれて、名前のところにotherが表示されてしまいます。

web.php
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('name/{first_name?}/{second_name?}', 'HelloController@index');
Route::get('hello/other', 'HelloController@other');
```

## テンプレート作成(Git Branch template)
簡単なテンプレート作成を行います。
1. テンプレート用のフォルダは「resources/views」の中に作成します。一般的にはさらにその中にフォルダを作成してその中にテンプレートをおきます。
`resources/views/hello`フォルダにテンプレートを置くことにします。
2. 今回はテンプレートの関連を見るだけですので、テンプレートの内容は簡単なHTMLを記述します。
テンプレートファイル名index.php
```
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Index</h1>
	<p>this is a sample page with php-template.</p>
</body>
</html>
```

3.ルートの設定を行います。  
テンプレートの指定はviewメソッドで行います。フォルダ名とファイル名をドットでつなぎ引数とします。
```
Route::get('hello', function () {
    return view('hello.index');
});
```

## コントローラでテンプレートを使う

HelloController.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
    	return view('hello.index');
    }
}
```

web.php
```
Route::get('hello', 'HelloController@index');
```
## コントローラーからテンプレートへ値の受け渡し
コントローラーからテンプレート側へ単純なデータの受け渡し方法。  
変数$msgを使います。

index.php
```
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Index</h1>
	<p><?php echo $msg; ?></p>
	<p><?php echo date("Y年n月j日"); ?></p>
</body>
</html>
```

HelloController.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
    	$date = ['msg'=>'これはコントローラーから渡されたメッセージです。'];
    	return view('hello.index',$date);
    }
}
```
### ルートパラメータをテンプレートに渡す

HelloController.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index($id='zero'){
    	$date = [
    		'msg'=>'これはコントローラーから渡されたメッセージです。',
    		'id'=>$id
    	];
    	return view('hello.index',$date);
    }
}
```

index.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index($id='zero'){
    	$data = [
    		'msg'=>'これはコントローラーから渡されたメッセージです。',
    		'id'=>$id
    	];
    	return view('hello.index',$data);
    }
}
```

web.php
```
Route::get('hello/{id?}', 'HelloController@index');
```
URLは以下のようにする。  
`http://localhost:8000/hello/aa`

### クエリー文字列の使用

HelloController.php
```
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
```

web.php
```
Route::get('hello', 'HelloController@index');
```

URLは以下のようにする。  
`http://localhost:8000/hello/?id=sample`

## Bladeテンプレート作成
resources/views/hello/index.blade.phpの作成

```
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Blade/Index</h1>
	<p>{{$msg}}</p>
</body>
</html>
```

app/Http/Controller/HelloController.php
```
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
```
URLは`http://localhost:8000/hello`

## フォームの利用
resources/views/hello/index.blade.php
```
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Blade/Index</h1>
	<p>{{$msg}}</p>
	<form action="/hello" method="POST">
	{{ csrf_field() }}
	<input type="text" name="msg">
	<input type="submit">
	</form>
</body>
</html>
```

app/Http/Controller/HelloController.php
```
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
    	$data = [
    		'msg'=>'お名前を入力してください。',
    	];
    	return view('hello.index',$data);
    }
     public function post(Request $request){
     	$msg = $request->msg;
     	$data = [
    		'msg'=>'こんにちは'.$msg.'さん。',
    	];
    	return view('hello.index',$data);
     }
}
```

ルートにpostを付け加えます。
**`Route::get('hello', 'HelloController@index');`**
は残したままにします。これを削除するとエラーになります。

routes/web.php
```
Route::get('/', function(){
  return view('welcome');
});
Route::get('hello', 'HelloController@index');
Route::post('hello', 'HelloController@post');
```

