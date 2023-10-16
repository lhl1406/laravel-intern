{{-- <div class="container"> --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-2 header" >
        <a class="navbar-brand" href="#">Intern training</a>
        <div class="collapse d-flex" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            @if(Auth::check())
                <a class="nav-item nav-link " href="/">Home </a>
            @else
                <a class="nav-item nav-link " href="#">{{Auth::user()->name }} </a>
                <a class="nav-item nav-link" href="/logout">Logout</a>
            @endif
        </div>
        </div>
    </nav>
{{-- </div> --}}