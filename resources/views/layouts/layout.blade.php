<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Akcióvadász</title>
	<script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" >
	<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	
</head>
<body>


<div class="container-fluid">
    @yield('content')
</div>


</body>
</html>