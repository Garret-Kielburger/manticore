<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">Manticore</a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())

                <ul class="nav navbar-nav">
                    <li><a href="{{ route('dashboard.index', ['username' => Auth::user()->username]) }}">Dashboard</a></li>
                    {{--<li><a href="#">Friends</a></li>--}}
                </ul>
                <form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Search apps...">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    {{--<li><a href="#">Spanky</a></li>--}}
                    {{--<li><a href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">{{ Auth::user()->getNameOrUsername() }}</a></li>--}}
                    <li><a href="{{ route('profile.edit', ['username' => Auth::user()->username]) }}">Update profile</a></li>
                    <li><a href="{{ route('auth.signout') }}">Sign Out</a></li>
                @else
                    {{--<li><a href="{{ route('auth.signup') }}">Sign up</a></li>--}}
                    <li><a href="{{ route('auth.signin') }}">Sign in</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>