@extends('templates.default')

@section('content')

    @include('templates.partials.sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="col-md-3">
            {{--{{ Form::model($app, array('route' => array('dashboard.edit_app', Auth::user()->username, $app->app_name), 'class'=>'form-vertical', 'role' => 'form')) }}--}}

            {{ Form::model($app, array('route' => array('dashboard.edit_app', Auth::user()->username, $app_name ))) }}

            <input name="type" type="hidden" value="edit_app">

            <h1>Edit App</h1>
            <br/>
            <h3> App Details:</h3>
            <br/>

            <div class="form-group{{ $errors->has('app_name') ? ' has-error' : "" }}">
                {!! Form::label('app_name', 'App name') !!}
                {!! Form::text('app_name', null, ['class' => 'form-control']) !!}
                @if ($errors->has('app_name'))
                    <span class="help-block">{{ $errors->first('app_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('app_api_key', 'App api-key for push messaging') !!}
                {!! Form::text('app_api_key', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('navigation_id', 'Choose a navigation style') !!}
                {!! Form::select('navigation_id',$navList, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Edit App', ['class' => 'btn btn-primary']) !!}
            </div>
            {{ Form::close() }}
            <br/>
        </div>
        <div class="col-md-5">

            <h1>Manage Screens</h1>
            <br/>
            <h3> Add Screen:</h3>
            <br/>
            <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ Session::token() }}">
                <input name="type" type="hidden" value="add_screen">

                <div class="form-group">
                    {!! Form::submit('Create New Screen', ['class' => 'btn btn-primary']) !!}
                    {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                </div>
            </form>
            <br/>

            <h3>Screen Info:</h3>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>Name</th>
                            <th>Order</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($screens as $screen)
                        <tr>
                            <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                                <input name="_token" type="hidden" value="{{ Session::token() }}">
                                <input name="uuid" type="hidden" value="{{ $screen->uuid }}">

                                <td class="col-lg-5">{!! Form::text('name', $screen->screen_name, ['class' => 'form-control']) !!} </td>
                                <td class="col-md-1">{!! Form::text('order', $screen->screen_order_number, ['class' => 'form-control']) !!} </td>
                                <td>
                                    <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_screen">Delete</button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-mini" name="type" value="update_screen">Update</button>
                                </td>
                             {{ Form::close() }}
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>
        <div class="col-md-2">

            <h1>Push</h1>
            <br/>
            {{--

            Sync Data

            --}}
            <h3> Sync Data:</h3>
            <br/>
            <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ Session::token() }}">
                <input name="type" type="hidden" value="push_sync">

                <div class="form-group">
                    {!! Form::submit('Sync App Data', ['class' => 'btn btn-primary']) !!}
                    {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                </div>
            </form>
            <br/>
            {{--


            Push Message


             --}}
            <h3> Push Message:</h3>
            <br/>
            <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ Session::token() }}">
                <input name="type" type="hidden" value="push_message">

                <div class="form-group">
                    {!! Form::label('push_title', 'Title:') !!}
                    {!! Form::textarea('push_title', null, ['class' =>'form-control','rows' => "2"]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('push_msg', 'Message:') !!}
                    {!! Form::textarea('push_msg', null, ['class' =>'form-control','rows' => "2"]) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Send Push Message', ['class' => 'btn btn-primary']) !!}
                    {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
        <div class="col-md-4">
            {{--Section for selecting ActionBar, System Bar (eventually?) and Navigation styling--}}
            <h3>Action Bar Styling:</h3>
            <br/>
            <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                <input name="_token" type="hidden" value="{{ Session::token() }}">
                <input name="type" type="hidden" value="update_action_bar_colour">
                <div class="form-group">
                    {!! Form::label('action_bar_colour', "Action Bar Colour:") !!}
                    @if ($app->action_bar_colour == null)
                        <input class="form-control" name="action_bar_colour" type="color">
                    @else
                        <input class="form-control" name="action_bar_colour" type="color" value="{{$app->action_bar_colour}}">
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::submit('Update Action Bar Colour', ['class' => 'btn btn-success']) !!}
                    {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                </div>
            </form>
        </div>
        <div class="col-md-8">
            {{--Section for selecting ActionBar, System Bar (eventually?) and Navigation styling--}}
            <h3>Navigation Styling:</h3>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        {{--<th>uuid</th>--}}
                        <th>Name</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <form method="POST" action="{{ route('dashboard.edit_app', [Auth::user()->username, $app_name ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="uuid" type="hidden" value="{{$navStyle->uuid}}">

            @if ($app->navigation_id == 1) {{-- Bottom Tabs--}}
                        @if ($navStyle->background_colour == null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="background_colour" type="color" >
                                </td>
                            </tr>
                        @elseif ($navStyle->background_colour != null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="background_colour" type="color" value="{{$navStyle->background_colour}}">
                                </td>
                            </tr>
                        @endif

                        @if ($navStyle->text_colour == null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="text_colour" type="color" >
                                </td>
                            </tr>
                        @elseif ($navStyle->text_colour != null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="text_colour" type="color" value="{{$navStyle->text_colour}}">
                                </td>
                            </tr>
                        @endif

{{--                        @if ($navStyle->text_highlight_colour == null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="text_highlight_colour" type="color">
                                </td>
                            </tr>

                        @elseif ($navStyle->text_highlight_colour != null)
                            <tr>
                                <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                <td class="col-lg-4">
                                    <input class="form-control" name="text_highlight_colour" type="color" value="{{$navStyle->text_highlight_colour}}">
                                </td>
                            </tr>
                        @endif--}}


            @elseif ($app->navigation_id == 2) {{--Swipe Tabs--}}

                            @if ($navStyle->background_colour == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="background_colour" type="color" >
                                    </td>
                                </tr>
                            @elseif ($navStyle->background_colour != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="background_colour" type="color" value="{{$navStyle->background_colour}}">
                                    </td>
                                </tr>
                            @endif

                            @if ($navStyle->text_colour == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_colour" type="color" >
                                    </td>
                                </tr>
                            @elseif ($navStyle->text_colour != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_colour" type="color" value="{{$navStyle->text_colour}}">
                                    </td>
                                </tr>
                            @endif

                            @if ($navStyle->text_highlight_colour == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_highlight_colour" type="color">
                                    </td>
                                </tr>

                            @elseif ($navStyle->text_highlight_colour != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_highlight_colour" type="color" value="{{$navStyle->text_highlight_colour}}">
                                    </td>
                                </tr>
                            @endif


            @elseif($app->navigation_id == 3) {{-- Navigation Drawer--}}
                            @if ($navStyle->background_colour == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="background_colour" type="color" >
                                    </td>
                                </tr>
                            @elseif ($navStyle->background_colour != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('background_colour', 'Background Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="background_colour" type="color" value="{{$navStyle->background_colour}}">
                                    </td>
                                </tr>
                            @endif

                            {{-- Doesn't allow colour change for header title/subtitle - yet - need to be included?--}}
                            @if ($navStyle->text_colour == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_colour" type="color" >
                                    </td>
                                </tr>
                            @elseif ($navStyle->text_colour != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('text_colour', 'Text Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4">
                                        <input class="form-control" name="text_colour" type="color" value="{{$navStyle->text_colour}}">
                                    </td>
                                </tr>
                            @endif

                            {{--                        @if ($navStyle->text_highlight_colour == null)
                                                        <tr>
                                                            <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                                            <td class="col-lg-4">
                                                                <input class="form-control" name="text_highlight_colour" type="color">
                                                            </td>
                                                        </tr>

                                                    @elseif ($navStyle->text_highlight_colour != null)
                                                        <tr>
                                                            <td class="col-md-4">{!! Form::label('text_highlight_colour', 'Text Highlight Colour', ['class' => 'form-control form-control-no-border']) !!} </td>
                                                            <td class="col-lg-4">
                                                                <input class="form-control" name="text_highlight_colour" type="color" value="{{$navStyle->text_highlight_colour}}">
                                                            </td>
                                                        </tr>
                                                    @endif--}}

                            {{--todo: eventually, make sure that this is actually nullable from front-end so that the textview doesn't take up space on the header - eg. for larger logo/image --}}
                            @if ($navStyle->title == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('title', 'Title', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4"> {!! Form::text('title', null, ['class' => 'form-control']) !!} </td>

                                </tr>
                            @elseif ($navStyle->title != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('title', 'Title', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4"> {!! Form::text('title', $navStyle->title, ['class' => 'form-control']) !!} </td>
                                </tr>
                            @endif

                            @if ($navStyle->subtitle == null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('subtitle', 'Subtitle', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4"> {!! Form::text('subtitle', null, ['class' => 'form-control']) !!} </td>

                                </tr>
                            @elseif ($navStyle->subtitle != null)
                                <tr>
                                    <td class="col-md-4">{!! Form::label('subtitle', 'Subtitle', ['class' => 'form-control form-control-no-border']) !!} </td>
                                    <td class="col-lg-4"> {!! Form::text('subtitle', $navStyle->subtitle, ['class' => 'form-control']) !!} </td>

                                </tr>
                            @endif

            @endif

            <td>
                <button type="submit" class="btn btn-success btn-mini" name="type" value="update_navigation_style">Update Navigation Style</button>
            </td>
            {{ Form::close() }}
            </tbody>
            </table>
        </div>
        </div>
    </div>


@stop
