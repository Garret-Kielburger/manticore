@extends('templates.default')
@section('content')

    @include('templates.partials.sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1>Welcome to your Manticore, {{ $user->getFirstNameOrUsername() }}</h1>


        <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>Label</h4>
                <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                <h4>Label</h4>
                <span class="text-muted">Something else</span>
            </div>

    </div>
    </div>

@stop