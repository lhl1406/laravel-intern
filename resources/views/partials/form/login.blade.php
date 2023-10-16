@extends('index')
@section('form')
<div class=" my-3 col-5 justify-content-center d-flex align-items-center" style="margin: auto; height: 100vh"> 
    <form method="POST" action={{ route('checkLogin') }} id="login-form" style="width: 100%; position: relative;" class="border border-light py-3 px-3 form-submit">
        @csrf
        <span class="login-tiltle">{{$pageTitle}}</span>
        <x-form.group-input >
                <x-slot:div class="mb-3">
                </x-slot:div>
                <x-slot:label>
                    Email:
                </x-slot:label>
                <x-slot:input 
                    value="{{ old('email') }}" 
                    name="email" 
                >
                </x-slot:input>
        </x-form.group-input>
        <x-form.group-input >
            <x-slot:div class="mb-3">
            </x-slot:div>
            <x-slot:label >
                Password:
            </x-slot:label>
            <x-slot:input 
                type="password" 
                value="{{ old('password') }}" 
                name="password" 
                >
            </x-slot:input>
        </x-form.group-input>
        <button type="submit" class="btn btn-primary">Login</button>
        @error('errorMessage')
            @include('partials.notification.alert-meassage')
        @enderror
    </form>
@endsection
@section('jquery')
    <script src="{{ asset('js/libs/form-validation/login.js') }}"></script>
@endsection
