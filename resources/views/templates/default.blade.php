<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manticore</title>

    <!-- Latest compiled and minified CSS -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="/css/keyvisual.css"/>

    <script>
	    window.addEventListener("message", function (event) {
		    console.log(event);
		    console.log(event.data);
		    console.log(event.target);

	    });
    </script>
    <script src="https://unpkg.com/interactjs@1.3/dist/interact.min.js"></script>
    <script src="../../../../js/mutableApp.js" defer></script>
    <script src="../../../../js/mutableAppConfig.js" defer></script>
    <script src="../../../../js/mutableAppObjects.js" defer></script>
    <script src="../../../../js/app.js" defer></script>

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