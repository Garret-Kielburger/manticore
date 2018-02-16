<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manticore</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">


</head>
<body>
@include('templates.partials.navigation')
<div class="container-fluid">
    <div class="row">
    @include('templates.partials.alerts')

    @yield('content')

    </div>
</div>

@include('templates.partials.footer')

@include('templates.partials.scripts')




</body>
</html>