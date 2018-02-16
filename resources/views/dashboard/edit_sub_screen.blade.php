@extends('templates.default')

@section('content')

    @include('templates.partials.sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-10">
                    <h1>Edit Sub-Screen</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <form method="POST"
                          action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $title, $screen_uuid, $subscreen_uuid ]) }}"
                          accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="edit_sub_screen_name">

                        <br/>
                        <h3> Sub-Screen Details:</h3>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : "" }}">
                            {!! Form::label('title', 'Sub-Screen title') !!}
                            {!! Form::text('title', $title, ['class' => 'form-control']) !!}
                            @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('owning_button_uuid', 'Owning Button UUID') !!}
                            {!! Form::text('owning_button_uuid', $owning_button_uuid, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sub_screen_purpose', 'Sub-Screen Purpose') !!}
                            {!! Form::text('sub_screen_purpose', $sub_screen_purpose, ['class' => 'form-control']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::submit('Save Sub-Screen Details', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                </div>
            </div>
            <br/>

            <div class="row">

                <div class="col-md-4">
                    <h3> Add New Image</h3>
                    <form method="POST"
                          action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $title, $screen_uuid, $subscreen_uuid ]) }}"
                          accept-charset="UTF-8" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_image">

                        <!-- Select Image Form Input -->
                        <div class="form-group">

                            {!! Form::label('image_label', 'Image:' ) !!}
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
                    {{-- todo: add image (incl uploader?) --}}
                    <h3> Add New Text</h3>
                    <form method="POST"
                          action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $title, $screen_uuid, $subscreen_uuid ]) }}"
                          accept-charset="UTF-8">
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
                    <form method="POST"
                          action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $title, $screen_uuid, $subscreen_uuid ]) }}"
                          accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_button">

                        <div class="form-group">

                            {!! Form::submit('Create Button', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    </div>

                <div class="col-md-4">
                    <h3> Add New Constraint</h3>
                    <form method="POST"
                          action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $title, $screen_uuid, $subscreen_uuid ]) }}"
                          accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ Session::token() }}">
                        <input name="type" type="hidden" value="create_constraint">

                        <div class="form-group">

                            {!! Form::submit('Create Constraint', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </form>
                    {{--</div>--}}

                </div>

                    <div class="col-md-4">
                        <h3> Add New Style</h3>
                        <form method="POST" action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid ]) }}" accept-charset="UTF-8">
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

        <div class="col-lg-12">

            <div class="col-lg-12">

                {{-- START Sub Screen Contents Table --}}

                <h3>Sub Screen Contents</h3>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>Element Type</th>
                            <th>Purpose</th>
                            <th>Content</th>
                            <th>UUID</th>
                            <th>Image Width</th>
                            <th>Image Height</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($content as $element)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid ]) }}" accept-charset="UTF-8">
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
                                    <td class="col-md-2">{!! Form::text('purpose', $element->purpose, ['class' => 'form-control']) !!} </td>
                                    {{-- content --}}
                                    @if($element->uri)
                                        <td class="col-lg-4">{!! Form::textarea('contenty', $element->uri, ['class' => 'form-control', 'rows' => "2"]) !!} </td>
                                    @else
                                        <td class="col-lg-4">{!! Form::textarea('contenty', $element->content, ['class' => 'form-control', 'rows' => "2"]) !!} </td>
                                    @endif
                                    {{-- UUID --}}
                                    <td class="col-lg-4">{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>

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

                {{-- END Buttons Table --}}

            </div>




            <div class="col-lg-12">

                {{-- START Buttons Table --}}

                <h3>Buttons</h3>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Label</th>
                            <th>Purpose</th>
                            <th>Content</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buttons as $button)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid ]) }}" accept-charset="UTF-8">
                                    <input name="_token" type="hidden" value="{{ Session::token() }}">
                                    {{-- uuid --}}

                                    {{--<td >{!! Form::text('uuid', $element->uuid, ['class' => 'form-control']) !!} </td>--}}

                                    <input name="uuid" type="hidden" value="{{ $button->uuid }}">
                                    {{-- UUID --}}
                                    <td class="col-lg-4">{!! Form::text('uuid', $button->uuid, ['class' => 'form-control']) !!} </td>
                                    {{-- Label --}}
                                    <td class="col-md-2">{!! Form::text('label', $button->label, ['class' => 'form-control']) !!} </td>
                                    {{-- Purpose --}}
                                    <td class="col-md-2">{!! Form::text('purpose', $button->purpose, ['class' => 'form-control']) !!} </td>
                                    {{-- Content --}}
                                    <td class="col-lg-4">{!! Form::text('contenty', $button->content, ['class' => 'form-control']) !!} </td>
                                    {{-- Delete Button--}}
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-mini" name="type" value="delete_element">Delete</button>
                                    </td>
                                    {{-- Update Buttton--}}
                                    <td>
                                        <button type="submit" class="btn btn-success btn-mini" name="type" value="update_element">Update</button>
                                    </td>
                                {{ Form::close() }}

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {{-- END Buttons Table --}}

            </div>


            {{-- START Styles Table --}}
            <div class="col-lg-12">

                <h3>Subscreen's Element's Styles</h3>

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
                                <form method="POST" action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid ]) }}" accept-charset="UTF-8">
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


                <h3>Subscreen Constraints</h3>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            {{--<th>uuid</th>--}}
                            <th>Start ID</th>
                            <th>Start Side</th>
                            <th>End ID</th>
                            <th>End Side</th>
                            <th>Margin</th>
                            <th>Horizontally Center? (T/F)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($constraints as $constraint)
                            <tr>
                                <form method="POST" action="{{ route('dashboard.edit_sub_screen', [Auth::user()->username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid ]) }}" accept-charset="UTF-8">
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

                {{-- END Constraints Table --}}

            </div>



        </div>




@stop