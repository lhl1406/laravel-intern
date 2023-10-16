@extends('dashboard')
@section('content')
    @if(! is_null(session('success'))) 
        @include('partials.notification.alert-meassage', [
            'type' => session('success') ? 'success' : 'danger',
            'message' => session('message'),
        ])
    @endif
    @php
        $conditionSearch = request()->session()->get('conditionSearch') ?? [];   
    @endphp
    <div class="wrap-content">
        <div class="content">
            <div class="search py-5">
                <div class="form">
                    <form action="{{ route('admin.user.index') }}" id="user-list-search-form" method="GET" class="form-submit"> 
                          <div class="form-row d-flex justify-content-between align-items-start">
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
                                        value="{{ old('name', $conditionSearch['name'] ?? '')}}"
                                    >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                            <div class="form-group col-6">
                            </div>
                          </div> 
                          <div class="form-row d-flex justify-content-between align-items-start">
                            <div class="form-group col-6 d-flex align-items-start flex-column group-input-user-list">
                                <x-form.group-input >
                                    <x-slot:div class="d-flex justify-content-between w-100 align-items-center">
                                    </x-slot:div> 
                                    <x-slot:label
                                    >
                                        Started Date From
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="started_date_from"
                                        value="{{ old('started_date_from', $conditionSearch['started_date_from'] ?? '')}}"
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
                                        Started Date To
                                    </x-slot:label>
                                    <x-slot:input
                                        appendClass="flex-grow-1"
                                        name="started_date_to"
                                        value="{{  old('started_date_to' , $conditionSearch['started_date_to'] ?? '')}}"
                                        >
                                    </x-slot:input>
                                </x-form.group-input>
                            </div>
                          </div> 
                          <div class="form-row">
                            <div class="form-group row col-6">
                            </div>
                            <div class="form-group row col-6 ">
                                <div class="group-btn my-2">
                                    <a class="btn btn-medium btn-outline-secondary" id="btn-clear-condition-search">
                                        Clear
                                    </a>
                                    <button class="btn btn-medium btn-outline-info">Search</button>
                                </div>
                            </div>
                        </div>
                      </form>
                </div>
            </div>
          
            @if (session('isSearch'))
                @if (count($userList))
                    <div class="pagination-wrap d-flex justify-content-end px-4">
                        {{ $userList->withQueryString()->links('vendor.pagination.custom')}}
                    </div>
                    <div class="table w-100 ">
                        {{-- pagination --}}
                        <div class="content-table col-12">
                            <table class="table table-striped table-hover table-bordered user-list">
                                <thead>
                                <tr>
                                    <th scope="col"><label>User Name</label></th>
                                    <th scope="col"><label>Email</label></th>
                                    <th scope="col"><label>Group Name</label></th>
                                    <th scope="col"><label>Started Date</label></th>
                                    <th scope="col"><label>Position</label></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userList as $user)
                                        <tr>
                                            @if(Auth::user()->position_id == getUserFlag('DIRECTOR'))
                                                <td><a href="{{ route('admin.user.edit', [$user]) }}" class="text-info">{{ $user->name }}</a></td>
                                            @else
                                                <td><label class="label-name">{{ $user->name }}</label></td>                                
                                            @endif
                                            <td> <label >{{ $user->email }}</label></td>
                                            <td> <label >{{ $user->group?->name ?? '' }}</label></td>
                                            <td> <label >{{ formatDateTime($user->started_date) }}</label></td>
                                            <td> <label >{{ getUserFlagLabel($user->position_id) }}</label></td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center" style="font-size: 20px">
                        No User Found
                    </div>
                @endif
            @endif
            @if(Auth::user()->position_id == getUserFlag('DIRECTOR'))
                <div class="action">
                    <div class="group-action">
                        <a href="{{ route('admin.user.add') }}" class="btn btn-medium btn-outline-primary btn-export-csv" >
                            Add New
                        </a> 
                        {{-- display if 0 record --}}
                        @if(count($userList) && session('isSearch'))
                        <a href="{{ route('admin.user.exportCSVFile') }}" class="btn btn-medium btn-outline-success btn-export-csv" >
                            Export CSV
                        </a> 
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('jquery')
    <script src="{{ asset('js/libs/form-validation/user-list-search.js') }}"></script>
    <script src="{{ asset('js/admin/user-list/clear-condition-search.js') }}"></script>
@endsection