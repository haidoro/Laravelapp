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