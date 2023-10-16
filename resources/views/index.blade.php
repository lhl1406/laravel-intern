<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pageTitle ?? ''}}</title>
    {{-- Boostrap link css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    {{-- Google Font: Source Sans Pro --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>
<body>
    @hasSection('form')
        @yield('form')
    @else
        @include('layouts.user.header')
        <div class="container row">
                @include('layouts.user.sidebar')
                @yield('content')
        </div>
        @include('layouts.user.footer')
    @endif
    @include('includes.scripts')
    @yield('jquery')
</body>
</html>