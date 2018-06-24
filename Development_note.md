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

## ルーティングとコントローラー
ルーティングはURLアドレスに対してどのような処理を行うかを管理する仕組みです。
例
`localhost:8000/webapp/hello`のアドレスを入れるとhello.htmlファイルが表示される仕組みです。
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

### テンプレートの場所
welcomeテンプレートの場所は「resource/views」フォルダに「welcome.blade.php」ファイルとして用意されています。
テンプレートの作成方法は後ほど学習するとしてファイルの場所を覚えておきましょう。

### Helloの表示
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

