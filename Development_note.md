# Laravel 開発ノート
Laravelを導入するとXAMMPなどの仮想サーバーは必要ありません。ローカルの好きな場所にプロジェクトフォルダを作成して始めることができます。

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
最初にComposerを使用し、Laravelインストーラをダウンロードします。
```
composer global require "laravel/installer"
```
ターミナルでComposerのcreate-projectコマンドを実行し、Laravelをインストール
この場合はlaravelappフォルダにlaravelをインストール
```
composer create-project --prefer-dist laravel/laravel laravelapp"
```
`cd`でlaravelappフォルダに移動して次のコマンドで「http://localhost:8000/」で初期画面が表示
```
php artisan serve
```
artisan serveを停止するには「コントロールキー＋C」

色々なフォルダやファイルができますが、まず必要なフォルダは「app」、「routes」、「resources」の3つのフォルダ内のファイルです。

## ルーティングとコントローラー
ルーティングはURLアドレスに対してどのような処理を行うかを管理する仕組みです。
例
`localhost:8000/webapp/hello.html`のアドレスを入れるとhello.htmlファイルが表示される仕組みです。
単純な静的なページならハイパーリンクで設定するだけですが、laravelではそのアドレスに対して実行するプログラムを設定する必要があります。

### Laravelのルーティングの仕組み
「routes」フォルダの「web.php」ファイルにルーティングの処理情報があります。
インストールしたばかりの状態では、この中にはルート情報のみ記載されています。

web.php(コメントアウト部分は省略)
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

`view('welcome')`関数は引数に指定されたテンプレートを表示するものです。ここではwelcomeテンプレートを指しています。

** `view('welcome')`関数を呼び出すのに無名関数を使うことでクロージャーを活用している点に着目 **

### Helloの表示(Banch hello)
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

## Controllerの使い方(Branch controller)
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
ここが`hello`のままだと`http://localhost:8000/hello/masaharu/tahara`では問題なく表示されますが、`http://localhost:8000/hello/other`としてもother部分を引数と認識してしまい。`index()`アクションのページが開かれて、名前のところにotherが表示されてしまいます。

web.php
```
Route::get('/', function () {
    return view('welcome');
});
Route::get('name/{first_name?}/{second_name?}', 'HelloController@index');
Route::get('hello/other', 'HelloController@other');
```

## テンプレート作成







