<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? ''}}</title>
    {{-- Boostrap link css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    {{-- Google Font: Source Sans Pro --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{-- css jquery ui--}}
    <link rel="stylesheet" href="{{ asset('css/admin/jquery/jquery-ui/jquery-ui.min.css') }}">
    {{-- css variable --}}
    <link rel="stylesheet" href="{{ asset('css/admin/variable.css')}}">
    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/user-list.css')}}">
</head>
<body>
    @include('layouts.admin.header')
    <div class="d-flex dashboard-content">
        @include('layouts.admin.sidebar')
        @yield('content')
    </div>
    @include('layouts.admin.footer')
    @include('includes.scripts')
    @yield('jquery')
</body>
</html>