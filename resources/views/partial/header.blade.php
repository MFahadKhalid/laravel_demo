<nav class="navbar navbar-light bg-light justify-content-between">
    <div class="container">
        <a href="#" class="navbar-brand">{{ env('APP_NAME') }}</a>
        <div class="form-inline">
            @auth
            <div class="dropdown">
                <a class="dropdown-toggle btn btn-primary text-light mr-4" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if (auth()->user()->role_id == '1')
                        <a class="dropdown-item" href="{{ route('category.index') }}"><i class="fa fa-th-large"></i> Category</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('blog.index') }}"><i class="fa fa-file-o"></i> Blog</a>
                    <a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            @endauth
            @guest
                <a class="text-dark" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a> &nbsp;|&nbsp;
                <a class="text-dark" href="{{ route('register') }}"><i class="fa fa-registered"></i> Register</a>
            @endguest
        </div>
    </div>
</nav>