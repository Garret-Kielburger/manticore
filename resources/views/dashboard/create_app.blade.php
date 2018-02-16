@extends('templates.default')

@section('content')

    @include('templates.partials.sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="col-lg-6">
            {{ Form::model($app, array('route' => array('dashboard.create_app', Auth::user()->username), 'class'=>'form-vertical', 'role' => 'form')) }}
            {{--{{ Form::open(array('route' => 'auth.signup')) }}--}}

            {{--   <form class="form-vertical" role="form" method="post" action="{{ route('auth.signup') }}">--}}

                <h1>Create a New App</h1>
                <br/>
                <h2> App Details:</h2>

                <div class="form-group{{ $errors->has('app_name') ? ' has-error' : "" }}">
                    {!! Form::label('app_name', 'App name') !!}
                    {!! Form::text('app_name', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('app_name'))
                        <span class="help-block">{{ $errors->first('app_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('app_api_key', 'Enter app api-key for push messaging') !!}
                    {!! Form::text('app_api_key',null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('navigation_id', 'Choose a navigation style') !!}
                    {!! Form::select('navigation_id',$navList, null, ['class' => 'form-control']) !!}
                </div>
{{--                <div class="form-group">
                    {!! Form::label('location_id', 'Select your location') !!}
                    {!! Form::select('location_id', $locationList, null, ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('role_id', 'Select your role/account type') !!}
                    {!! Form::select('role_id', $roleList, null, ['class' => 'form-control']) !!}
                </div>--}}

{{--                <h4>About Me</h4>
                <div class="form-group">
                    {!! Form::label('about', 'Tell the uSynapsis community about yourself') !!}
                    {!! Form::text('about', null, ['class' => 'form-control']) !!}
                </div>--}}

                <div class="form-group">
                    {!! Form::submit('Create New App', ['class' => 'btn btn-primary']) !!}
                    {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                </div>
            {{ Form::close() }}

        </div>
    </div>


@stop
