<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Bladeを使ったIndex</h1>
	<p>{{$msg}}</p>
	<form action="/hello" method="post">
		{{ csrf_field() }}
		<input type="text" name="msg">
		<input type="submit">
	</form>
</body>
</html>
