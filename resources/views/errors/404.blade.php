<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="icon" href="/favicon.png" type="image/png">
	<title>404 Not found</title>

	<link rel="stylesheet" href="{{ mix('/site/cache/app.css') }}">
</head>
<body class="page-404">
	<div>
		<h1>404</h1>
		<p>{!! trans('translations.404.title') !!}</p>
	</div>
</body>
</html>
