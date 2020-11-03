@extends('templates.default')

@section('content')

    @include('templates.partials.sidebar')


    <div id="meat-and-potatoes" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="padding-left: 245px" >
        <div class="row">
            <div id="app" class="col-md-8" style="border: solid 1px blue">

                <div class="row">
                    <button-test-component v-on:testing-click="productionClick('{{$screen_uuid}}')" id="loader">Load Screen</button-test-component>
                                    <button-test-component v-on:testing-click="updateConstraints" id="constrainter" style="margin-left: 10px; margin-right: 10px">Create new constraints</button-test-component>
{{--

                                    <button-test-component v-on:testing-click="updateTextStyles" id="text_styler">Create new text styles</button-test-component>

                                    <button-test-component v-on:testing-click="updateButtonStyles" id="button_styler">Create new button styles</button-test-component>
--}}

                                    <button-test-component v-on:testing-click="updateElements" id="elementer" style="margin-left: 10px">Update Element Content</button-test-component>

                    <button-test-component v-on:testing-click="updateAllScreenProperties('{{$screen_uuid}}')" id="masterUpdater" style="margin-left: 10px">Save Changes</button-test-component>

                    <button-test-component v-on:testing-click="applyConstraints" id="moveStuff" style="margin-left: 10px">Apply Constraints</button-test-component>
                    <button-test-component v-on:testing-click="applyStyles" id="styler" style="margin-left: 10px">Apply Styles</button-test-component>


                </div>
                {{--
                            <div class="row">
                                <iframe id="app-screen" class="live-demo2" style="display:none"></iframe>
                                <iframe id="screen2" class="live-demo"></iframe>
                            </div>
                --}}
                <div class="row">
                    <div class="keyvisual">
                        <div class="keyvisual-inner">
                            <div class="keyvisual-left" >
                                <div class="keyvisual-switch">
                                    <a class="trigger" onClick="switchKeyVisualFrame()"></a>
                                </div>
                                <div class="keyvisual-image">
                                    <div id="keyvisual_ios" class="keyvisual-ios-container">
                                        <div id="keyvisual_frame_img_ios" class="keyvisual-image-frame keyvisual-image-frame-ios">
                                        </div>
                                        <iframe id="keyvisual_frame_content_ios" marginheight="100px" class="keyvisual-image-content-ios" scrolling="no" class="lazy-hidden"></iframe>
                                    </div>
                                    <div id="keyvisual_android" class="keyvisual-android-container">
                                        <div id="keyvisual_frame_img_android" class="keyvisual-image-frame keyvisual-image-frame-android">
                                        </div>
                                        <iframe id="keyvisual_frame_content_android" marginheight="100px" class="keyvisual-image-content-android" scrolling="no" class="lazy-hidden"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <div id="app4" class="col-md-4" style="border: solid 1px red">

                <h1> Control Panel</h1>
                <p>Here's where you can set up your app as you like.</p>

                {{--<button-test-component>Create Text</button-test-component>--}}

                <accordion-test></accordion-test>

            </div>
        </div>
        <div class="row">

        </div>
    </div>