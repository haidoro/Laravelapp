<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
   <h1>Blade/Index</h1>
   
   <ol>
	@foreach($data as $item)
	<li>{{$item}}</li>
	@endforeach
   </ol>	
</body>

</html>