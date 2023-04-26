<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akcióvadász</title>
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('horseracher.png') }}">
</head>

<body>

    <div class="container-fluid">
        @include('../layouts/navbar')
        @yield('content')
    </div>


</body>

</html>
