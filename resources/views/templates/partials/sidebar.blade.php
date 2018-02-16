
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="{{ route('dashboard.index', ['username' => Auth::user()->username]) }}">Overview</a></li>
                <li><a href="{{route('dashboard.create_app', ['username' => Auth::user()->username]) }}">Create New App</a></li>
            </ul>



            @foreach($apps as $app)

            <ul class="nav nav-sidebar">
                <li><a href="{{ route('dashboard.edit_app', ['username' => Auth::user()->username, 'app_name' => $app->app_name]) }}"><h4>{{ $app->app_name }}</h4></a></li>

               @foreach($app->screens as $screen)
                    @if(!$screen->screen_name)
                        <li><a href="{{ route('dashboard.edit_screen', ['username' => Auth::user()->username, 'app_name' => $app->app_name, 'screen_name' => 'New-Screen', 'screen_uuid' => $screen->uuid]) }}">First Screen</a></li>
                    @else
                        <li><a href="{{ route('dashboard.edit_screen', ['username' => Auth::user()->username, 'app_name' => $app->app_name, 'screen_name' => $screen->screen_name, 'screen_uuid' => $screen->uuid ]) }}">{{ $screen->screen_name }}</a></li>

                        @foreach($screen->buttons_sub_screens as $button_sub_screen)
                            <li style="padding-left: 20px"><a href="{{ route('dashboard.edit_sub_screen', ['username' => Auth::user()->username, 'app_name' => $app->app_name, 'screen_name' => $screen->screen_name, 'screen_uuid' => $screen->uuid, 'subscreen_uuid' =>$button_sub_screen->uuid ]) }}"> - {{ $button_sub_screen->title }}</a></li>
                        @endforeach

                    @endif
                @endforeach
            </ul>

            @endforeach

        </div>
