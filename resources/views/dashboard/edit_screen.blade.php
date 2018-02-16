@extends('templates.default')

@section('content')

    @include('templates.partials.sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-4">
            {{--{{ Form::model($screen, array('route' => array('dashboard.edit_screen', $app_name, $screen_name, 'class'=>'form-vertical', 'role' => 'form'))) }}--}}
            {{--{{ Form::model($screen, array('route' => array('dashboard.edit_screen', $app_name, $screen_name, 'class'=>'form-vertical', 'role' => 'form'))) }}--}}
            {{--{{ Form::open(array('route' => 'auth.signup')) }}--}}

            {{--   <form class="form-vertical" role="form" method="post" action="{{ route('auth.signup') }}">--}}

            {{--<form method="POST" action="{{ route('dashboard.edit_screen', ['app_name' => $app_name, 'screen_name' => $screen_name]) }}" accept-charset="UTF-8">--}}
                <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                {{--<form role="form" action="{{ route('status.reply', ['statusId' => $status->id])}}" method="post">--}}
                <input name="_token" type="hidden" value="{{ Session::token() }}">
                <input name="type" type="hidden" value="edit_screen_name">

                    <h1>Edit Screen</h1>
                <br/>
                <h3> Screen Details:</h3>

                <div class="form-group{{ $errors->has('screen_name') ? ' has-error' : "" }}">
                    {!! Form::label('screen_name', 'Screen name') !!}
                    {!! Form::text('screen_name', $screen_name, ['class' => 'form-control']) !!}
                    @if ($errors->has('screen_name'))
                        <span class="help-block">{{ $errors->first('screen_name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::submit('Save Name', ['class' => 'btn btn-primary']) !!}
                </div>
                </form>
                </div>

                <h3>Sub-Screen Info:</h3>
                <br/>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscreens as $subscreen)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                    <input name="_token" type="hidden" value="{{ Session::token() }}">
                                    <input name="uuid" type="hidden" value="{{ $subscreen->uuid }}">

                                    <td class="col-lg-5">{!! Form::text('title', $subscreen->title, ['class' => 'form-control']) !!} </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_sub_screen">Delete</button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-mini" name="type" value="update_sub_screen">Update</button>
                                    </td>
                                {{ Form::close() }}
                            </tr>
                        @endforeach
                        </tbody>


                    </table>

            </div>
            <br/>

            <div class="row">
                <div class="col-md-4">
                    <h3> Add New Image</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_image">

                        <!-- Select Image Form Input -->
                        <div class="form-group">

                            {!! Form::label('image_label', 'Image:' ) !!}
                            {{--{!! Form::file ('image_label', null, ['class' =>'form-control']) !!}--}}
                            {!! Form::file('image') !!}
                            <p class="help-block">
                                Maximum file size: 5mb
                            </p>
                        </div>
                        <!-- Submit Image Form Input -->
                        <div class="form-group">
                            {!! Form::submit('Add Image', ['class' =>'btn btn-primary form-control']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4">
                    <h3> Add New Text</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_text">

                        <div class="form-group">

                            {!! Form::submit('Create Text', ['class' => 'btn btn-primary']) !!}
                            {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <h3> Add New Button</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_button">

                        <div class="form-group">

                            {!! Form::submit('Create Button', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    {{--</div>--}}

                </div>
                <div class="col-md-4">
                    <h3> Add New Sub-Screen</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_sub_screen">

                        <div class="form-group">

                            {!! Form::submit('Create Sub-Screen', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    {{--</div>--}}

                </div>
                <div class="col-md-4">
                    <h3> Add New Web View</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_web_view">

                        <div class="form-group">

                            {!! Form::submit('Create Web View', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    {{--</div>--}}

                </div>
                <div class="col-md-4">
                    <h3> Add New Constraint</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_constraint">

                        <div class="form-group">

                            {!! Form::submit('Create Constraint', ['class' => 'btn btn-primary']) !!}
                            {{--<button type="submit" class="btn btn-primary">Sign up</button>--}}
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <h3> Add New Style</h3>
                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_style">

                        <div class="form-group">

                            {!! Form::submit('Create Style', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    {{--</div>--}}

                </div>



            </div>

        </div>


            {{-- START Elements Table --}}

            <div class="col-lg-12">

                <h3>Screen Contents</h3>

                <div class="table-responsive">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                    {{--<th>uuid</th>--}}
                                    <th>Element Type</th>
                                    <th>Purpose</th>
                                    <th>Content</th>
                                    <th>UUID</th>
                                    <th>Vertical Alignment</th>
                                    <th>Image Width</th>
                                    <th>Image Height</th>
                                    <th></th>
                                    </tr>
                                </thead>
                            <tbody>
                            @foreach($content as $element)
                                <tr>
                                    <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                                    {{-- uuid --}}

                                    {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                    <input name="uuid" type="hidden" value="{{ $element->uuid }}">
                                    {{-- element type --}}
                                    @if($element->uri)
                                        <td class="col-md-1">{!! Form::text('element_type', 'Image', ['class' => 'form-control']) !!} </td>
                                    @else
                                        <td class="col-md-1">{!! Form::text('element_type', 'Text', ['class' => 'form-control']) !!} </td>
                                    @endif
                                    {{-- purpose --}}
                                        <td class="col-md-1">{!! Form::text('purpose', $element->purpose, ['class' => 'form-control']) !!} </td>
                                    {{-- content --}}
                                    @if($element->uri)
                                        <td class="col-lg-4">{!! Form::textarea('contenty', $element->uri, ['class' => 'form-control', 'rows' => "2"]) !!} </td>
                                    @else
                                        <td class="col-lg-4">{!! Form::textarea('contenty', $element->content, ['class' => 'form-control', 'rows' => "2"]) !!} </td>
                                    @endif
                                    {{-- UUID --}}
                                    <td class="col-lg-4">{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>
                                    {{--Vertical Alignment --}}
                                    <td class="col-md-1">{!! Form::text('vertical', $element->vertical_align, ['class' => 'form-control']) !!} </td>
                                    {{-- Image Width --}}
                                    @if($element->uri)
                                        <td class="col-md-4">{!! Form::text('width', $element->width, ['class' => 'form-control']) !!} </td>
                                    @else
                                        <td class="col-md-4"></td>
                                    @endif

                                    {{-- Image Height --}}
                                    @if($element->uri)
                                        <td class="col-md-4">{!! Form::text('height', $element->height, ['class' => 'form-control']) !!} </td>
                                    @else
                                       <td class="col-md-4"></td>
                                    @endif

                                    {{-- Delete Element--}}
                                    <td>
                                        {{--{!! Form::open(['action' => ['DashboardController@destroyElement', $element->uuid], 'method' => 'delete']) !!}--}}
                                        {{--{!! Form::submit('Delete', ['class'=>'btn btn-danger btn-mini', 'name' => 'type']) !!}--}}
                                        <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_element">Delete</button>
                                    </td>
                                    {{-- Update Element--}}
                                    <td>
                                        <button type="submit" class="btn btn-success btn-mini" name="type" value="update_element">Update</button>
                                    </td>
                                    {{ Form::close() }}

                            </tr>
                        @endforeach
                            </tbody>
                        </table>

                </div>

            {{--{!! Form::submit('Save Screen Contents', ['class' => 'btn btn-primary', 'name' => 'save_whole_screen']) !!}--}}
            {{--<button type="submit" class="btn btn-primary" name="type" value="save_whole_screen">Save Screen Contents</button>--}}

                {{-- END Elements Table --}}

        </div>


            {{-- START WebView Table --}}
            <div class="col-lg-12">

                <h3>Web View details</h3>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>Screen UUID</th>
                            <th>Web Address</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($web_views as $web_view)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                    <input name="_token" type="hidden" value="{{ Session::token() }}">
                                    {{-- uuid --}}

                                    {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                    <input name="uuid" type="hidden" value="{{ $web_view->uuid }}">
                                    {{-- Start ID --}}
                                    <td class="col-lg-4">{!! Form::text('screen_uuid', $web_view->screen_uuid, ['class' => 'form-control']) !!} </td>
                                    {{-- Start Side --}}
                                    <td class="col-lg-10">{!! Form::text('web_address', $web_view->web_address, ['class' => 'form-control']) !!} </td>
                                    {{-- Delete Element--}}
                                    <td>
                                        {{--{!! Form::open(['action' => ['DashboardController@destroyElement', $element->uuid], 'method' => 'delete']) !!}--}}
                                        {{--{!! Form::submit('Delete', ['class'=>'btn btn-danger btn-mini', 'name' => 'type']) !!}--}}
                                        <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_element">Delete</button>
                                    </td>
                                    {{-- Update Element--}}
                                    <td>
                                        <button type="submit" class="btn btn-success btn-mini" name="type" value="update_element">Update</button>
                                    </td>
                                {{ Form::close() }}

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- END WebView Table --}}




            {{--START Buttons Table--}}

            <div class="col-lg-12">
                <h3>Buttons</h3>
                <div class="table-responsive">
                    <table class="table table-striped">

                    <thead>
                    <tr>
                        <th>Label</th>
                        <th>Purpose</th>
                        <th>UUID</th>
                        <th>Content</th>
                        <th>Opens Subscreen?</th>
                        <th>Opens this subscreen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($buttons as $button)
                        <tr>
                            <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                <input name="_token" type="hidden" value="{{ Session::token() }}">
                                {{-- uuid --}}

                                {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                <input name="uuid" type="hidden" value="{{ $button->uuid }}">

                                {{-- Label--}}
                                <td class="col-md-1">{!! Form::text('label', $button->label, ['class' => 'form-control']) !!} </td>
                                {{-- Purpose --}}
                                <td class="col-md-1">{!! Form::text('purpose', $button->purpose, ['class' => 'form-control']) !!} </td>
                                {{-- UUID --}}
                                <td class="col-lg-4">{!! Form::textarea('uuid', $button->uuid, ['class' => 'form-control', 'rows'=>"2"]) !!} </td>
                                {{-- Content --}}
                                <td class="col-lg-4">{!! Form::text('contenty', $button->content, ['class' => 'form-control']) !!} </td>
                                {{-- Boolean for opens subscreen --}}
                                <td class="col-md-1">{!! Form::text('with_sub_screen', $button->with_sub_screen, ['class' => 'form-control']) !!} </td>
                                {{-- Subscreen UUID--}}
                                <td class="col-lg-4">{!! Form::textarea('sub_screen_uuid', $button->sub_screen_uuid, ['class' => 'form-control', 'rows' => "2"]) !!} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                {{-- Delete Element--}}
                                <td>
                                    <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_element">Delete</button>
                                </td>
                                {{-- Update Element--}}
                                <td>
                                    <button type="submit" class="btn btn-success btn-mini" name="type" value="update_element">Update</button>
                                </td>
                            {{ Form::close() }}

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            {{--END Buttons Table--}}

            {{-- START Styles Table --}}
            <div class="col-lg-12">

                <h3>Screen's Element's Styles</h3>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>View Object UUID</th>
                            <th>Property to Style</th>
                            <th>Value to Apply</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($styles as $style)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                    <input name="_token" type="hidden" value="{{ Session::token() }}">
                                    {{-- uuid --}}

                                    {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                    <input name="uuid" type="hidden" value="{{ $style->uuid }}">

                                    {{-- View Object UUID --}}
                                    <td class="col-md-4">{!! Form::text('view_object_uuid', $style->view_object_uuid, ['class' => 'form-control']) !!} </td>

                                    @if($style->view_object_uuid != null)
                                    {{-- Property to Style --}}
                                    <td class="col-md-4">{!! Form::select('property_to_style', $propertyList, $style->property_to_style, ['class' => 'form-control']) !!} </td>

                                        {{-- Value to Apply --}}

                                        @if($style->saved_property != null)

                                            @if ($style->saved_property->property_to_style == "text_style")

                                                @if ($style->value_to_apply == null)
                                                    <td class="col-md-4">{!! Form::select('value_to_apply', $styleValueList, null, ['placeholder' => 'Pick a Style...', 'class' => 'form-control']) !!} </td>
                                                @else
                                                    <td class="col-md-4">{!! Form::select('value_to_apply', $styleValueList, $style->value_to_apply, ['placeholder' => 'Pick a Style...', 'class' => 'form-control']) !!} </td>
                                                @endif
                                            @elseif ($style->saved_property->property_to_style == "font_family")
                                                @if ($style->value_to_apply == null)
                                                    <td class="col-md-4">{!! Form::select('value_to_apply', $fontValueList, null, ['placeholder' => 'Pick a Style...', 'class' => 'form-control', 'class' => 'form-control']) !!} </td>
                                                @else
                                                    <td class="col-md-4">{!! Form::select('value_to_apply', $fontValueList, $style->value_to_apply, ['placeholder' => 'Pick a Style...', 'class' => 'form-control', 'class' => 'form-control']) !!} </td>
                                                @endif
                                            @elseif($style->saved_property->property_to_style == "background_color" || $style->saved_property->property_to_style == "text_color")
                                                @if ($style->value_to_apply == null)
                                                    <td class="col-md-4">
                                                        <input class="form-control" name="value_to_apply" type="color">
                                                    </td>
                                                @else
                                                    <td class="col-md-4">
                                                        <input class="form-control" name="value_to_apply" type="color" value="{{$style->value_to_apply}}">
                                                    </td>
                                                @endif
                                            @elseif($style->saved_property->property_to_style == "text_size")
                                                <td class="col-md-4">{!! Form::number('value_to_apply', $style->value_to_apply, ['class' => 'form-control']) !!} </td>
                                            @else
                                                {{--for debugging purposes for now. todo: remove debug tool --}}
                                                <td class="col-md-4"> $style->saved_property->property_to_style</td>
                                            @endif
                                        @else
                                            <td class="col-md-4"></td>
                                        @endif


                                    @else
                                        <td class="col-md-4"></td>
                                        <td class="col-md-4"></td>
                                    @endif


                                    {{-- Delete Element--}}
                                    <td>
                                        {{--{!! Form::open(['action' => ['DashboardController@destroyElement', $element->uuid], 'method' => 'delete']) !!}--}}
                                        {{--{!! Form::submit('Delete', ['class'=>'btn btn-danger btn-mini', 'name' => 'type']) !!}--}}
                                        <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_style">Delete</button>
                                    </td>
                                    {{-- Update Element--}}
                                    <td>
                                        <button type="submit" class="btn btn-success btn-mini" name="type" value="update_style">Update</button>
                                    </td>
                                {{ Form::close() }}

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
            {{-- END Styles Table --}}

            {{-- START Constraints Table --}}
            <div class="col-lg-12">

            <h3>Screen Constraints</h3>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        {{--<th>uuid</th>--}}
                        <th>Start UUID</th>
                        <th>Start Side</th>
                        <th>End UUID</th>
                        <th>End Side</th>
                        <th>Margin</th>
                        <th>Horizontally Center? (T/F)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($constraints as $constraint)
                        <tr>
                            <form method="POST" action="{{ route('dashboard.edit_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid ]) }}" accept-charset="UTF-8">
                                <input name="_token" type="hidden" value="{{ Session::token() }}">
                                {{-- uuid --}}

                                {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                <input name="uuid" type="hidden" value="{{ $constraint->uuid }}">
                                {{-- Start ID --}}
                                <td class="col-lg-4">{!! Form::text('start_id', $constraint->start_id, ['class' => 'form-control']) !!} </td>
                                {{-- Start Side --}}
                                <td class="col-md-1">{!! Form::text('start_side', $constraint->start_side, ['class' => 'form-control']) !!} </td>
                                {{-- End ID --}}
                                <td class="col-lg-4">{!! Form::text('end_id', $constraint->end_id, ['class' => 'form-control']) !!} </td>
                                {{-- End Side --}}
                                <td class="col-md-1">{!! Form::text('end_side', $constraint->end_side, ['class' => 'form-control']) !!} </td>
                                {{-- Margin --}}
                                <td class="col-md-1">{!! Form::text('margin', $constraint->margin, ['class' => 'form-control']) !!} </td>
                                {{-- Horizontally Centered --}}
                                <td class="col-md-1">{!! Form::text('horizontally_centered', $constraint->horizontally_centered, ['class' => 'form-control']) !!} </td>

                                {{-- Delete Element--}}
                                <td>
                                    {{--{!! Form::open(['action' => ['DashboardController@destroyElement', $element->uuid], 'method' => 'delete']) !!}--}}
                                    {{--{!! Form::submit('Delete', ['class'=>'btn btn-danger btn-mini', 'name' => 'type']) !!}--}}
                                    <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_constraint">Delete</button>
                                </td>
                                {{-- Update Element--}}
                                <td>
                                    <button type="submit" class="btn btn-success btn-mini" name="type" value="update_constraint">Update</button>
                                </td>
                            {{ Form::close() }}

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            </div>
            {{-- END Constraints Table --}}




    </div>

@stop

{{--                                {{ Form::model($screen, array('route' => array('profile.edit'), 'class'=>'form-vertical', 'role' => 'form')) }}
                                <td >{!! Form::select('degree_id', $degreesList, null, ['class' => 'form-control']) !!} </td>
                                <td >{!! Form::select('discipline_id', $disciplinesList, null, ['class' => 'form-control']) !!} </td>
                                <td >{!! Form::select('institution_id', $institutionsList,null, ['class' => 'form-control']) !!} </td>
                                <td >{!! Form::select('department_id', $departmentsList, null,['class' => 'form-control']) !!} </td>
                                <td class="col-md-1">{!! Form::text('screen_id', $screen->id, ['class' => 'form-control']) !!} </td>
                                 <td class="col-md-1">{!! Form::text('to', null, ['class' => 'form-control']) !!} </td>
                                 <td class="col-md-1">{!! Form::text('standing', null, ['class' => 'form-control']) !!} </td>--}}