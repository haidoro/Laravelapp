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

