{{-- <div class="container"> --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-2 header d-flex justify-content-end" style="position: relative">
        <a class="navbar-brand" href="#"></a>
        <div class="title-header" style="position: absolute; left: 50%; font-size: 20px">{{  $pageTitle ?? ''}}</div>
        <div class="collapse d-flex" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <label class="nav-item nav-link user-name-header" >{{ Auth::user()->name }} </label>
                <a class="nav-item nav-link" href="/logout">Logout</a>
            </div>
        </div>
    </nav>
{{-- </div> --}}