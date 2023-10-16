@extends('dashboard')
@section('content')
    @isset($user) 
        @include('partials.form.delete-confirmation')
    @endisset
    <div class="wrap-content wrap-use-add-edit-delete">
        <div class="content">
            <div class="search py-4">
                <div class="form">
                    @php
                        $actions = explode('.', Route::current()->getName());
                        if($actions[2] == 'add') {
                            $route = 'admin.user.store';
                        } else if($actions[2] == 'edit') {
                            $route = 'admin.user.update';
                        }
                        if(isset($user)) {
                            if(Auth::id() == $user['id'] && Auth::user()->position_id != getUserFlag('DIRECTOR')) {
                                $route = 'admin.user.updatePassword';
                            }
                        }
                    @endphp
                    <form action="{{ route($route) }}" id="user-add-edit-delete-form" method="POST" class="form-submit"> 
                        @csrf
                          <div class="form-row d-flex justify-content-between align-items-start">
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label
                                    >
                                        ID
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1" 
                                        name="id"
                                        value="{{ $user['id'] ?? old('id') ?? '' }}"
                                        readonly="true"
                                        {{-- hidden="true" --}}
                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label
                                    >
                                        User Name
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1" 
                                        name="name"
                                        value="{!! old('name', $user['name'] ?? '') !!}"                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                          </div> 
                          <div class="form-row d-flex justify-content-between align-items-start">
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label>
                                        Email
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="email"
                                        value="{{ old('email', $user['email'] ?? '') }}"
                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <label for="group_id" class="form-label">Group</label>
                                    <div class="form-control flex-grow-1" style="position: relative; border: none;">
                                        <div class="container">
                                            <div class="option-default {{ isset($user) && Auth::user()->position_id != getUserFlag('DIRECTOR') ? 'disiabled' : '' }} " id="option-first">
                                                <span class="option-selected " id="option-selected">
                                                </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </div>
                                            <input type="text" name="group_id" id="group_id" value="" style="width: 100%; top: -14px; position: absolute; left: 0; z-index: -2" data-content="Group">
                                            <div class="option-list-wrap">
                                                <ul class="option-list">
                                                    <li value="null"  class="option-item {{ old('group_id') == 'null' ? 'active' : '' }}"  ></li>
                                                    @foreach ($groupList as $group)
                                                    <li data-group_id="{{ $group['id'] }}" class="option-item 
                                                    {{ 
                                                        isset($user['group_id']) && old('group_id') == null ? 
                                                            $group['id']  == $user['group_id']  ? 'active' : ''
                                                            : '' 
                                                    }}
                                                    {{ old('group_id') == $group['id']  ? 'active' : ''}} 
                                                    ">{{ $group['name'] }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="error-div error-group_id">
                                    @if ($errors->has('group_id'))
                                        <label id="group_id-error" class="error" for="group_id">{{ $errors->first('group_id') }}</label>
                                    @endif
                                </div>
                            </div>
                          </div> 
                          <div class="form-row d-flex justify-content-between align-items-start">
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label>
                                        Started Date
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="started_date"
                                        value="{{ old('started_date', isset($user) ? formatDateTime($user['started_date']) : '') }}"
                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <label for="group_id" class="form-label">Position</label>
                                    <select  
                                        class="form-control flex-grow-1"
                                        name="position_id" 
                                        id="position_id"
                                        data-content="Position"
                                    >
                                    <option value="null" {{ old('position_id') == 'null' ? 'selected' : '' }} ></option>
                                    @foreach ($positionList as $position)
                                        <option value="{{ $position['id'] }}" 
                                    {{ 
                                        isset($user['position_id']) && old('position_id') == null  ? 
                                            $position['id']  == $user['position_id']  ? 'selected' : ''
                                            :''
                                    }}
                                    {{ old('position_id') == $position['id'] && old('position_id') != null ? 'selected' : ''}} 
                                    >
                                    {{ $position['name'] }}
                                    </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="error-div error-position_id">
                                    @if ($errors->has('position_id'))
                                        <label id="position_id-error" class="error" for="position_id">{{ $errors->first('position_id') }}</label>
                                    @endif
                                </div>
                            </div>
                          </div> 
                          <div class="form-row d-flex justify-content-between align-items-start">
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label>
                                        Password
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="password"
                                        value="{{ $user[''] ?? old('password') ?? '' }}"
                                        type="password"
                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label>
                                        Password Confirmation
                                    </x-slot:label> 
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="password_confirmation"
                                        value="{{ $user[''] ?? old('password__confirmation') ?? '' }}"
                                        type="password"
                                        >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                          </div> 
                          <div class="d-flex">
                            <div class="w-100">
                                <div class="group-btn my-2 d-flex justify-content-between align-items-center">
                                    @if (isset($checkForAdd))
                                        <button class='btn btn-medium btn-outline-primary'>Register</button>
                                    @else
                                        <button class="btn btn-medium btn-outline-info">Update</button>
                                        @if(Auth::id() != $user['id']) 
                                            <a class="btn btn-medium btn-outline-danger btn-delete">Delete</a>
                                        @endif
                                    @endif
                                    <a href="{{ route('admin.user.index')}}" class="btn btn-medium btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                        <input type="text" hidden value="{{ $checkForAdd ?? ''}}" id='checkForAdd'>
                        <input type="text" hidden value="{{ $user['id'] ?? old('id') ?? '' }}" id="userID" name="userID">
                      </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jquery')
    {{-- Validate form--}}
    <script src="{{ asset('js/libs/form-validation/user-add-edit-delete.js') }}"></script>
    {{-- Disable inputs for edit --}}
    <script src="{{ asset('js/libs/form-validation/disiable-inputs-for-edit-user.js') }}"></script>
    <script>
        setReadonlyForInputForEdit("{{Auth::user()->position_id}}", "{{Route::current()->getName()}}");
        </script>

    <script src="{{ asset('js/admin/user-list/select-option-group-list.js') }}"></script>
@endsection