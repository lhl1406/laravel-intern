@extends('dashboard')
@section('content')
    {{-- @include('partials.form.dialogImportCSV') --}}
    <div class="wrap-content">
        <div class="content">
            @include('partials.notification.alert-measage-for-import')
            {{-- pagination --}}
            @if (count($groupList))
                <div class="pagination-wrap d-flex justify-content-end px-4 pt-4">
                    <div class="error-message-list" style="max-width: 50%; line-height: 54px; position: absolute; top: 70px; left: 260px">
                        @if ($errors->has('file'))
                            <label class="error" for="file">{{ $errors->first('file') }}</label>
                        @endif
                    </div>
                    {{ $groupList->withQueryString()->links('vendor.pagination.custom')}}
                </div>
            @endif
            <div class="table w-100 py-4">
                <div class="content-table col-12">
                    <table class="table table-striped table-hover table-bordered group-list align-middle">
                        <thead>
                            <tr>
                                <th class="align-middle" scope="col" style="width: 5%"><label>ID</label></th>
                                <th class="align-middle" scope="col" style="width: 15%"><label>Group Name</label></th>
                                <th class="align-middle" scope="col" style="width: 30%"><label>Group Note</label></th>
                                <th class="align-middle" scope="col" style="width: 15%"><label>Group Leader</label></th>
                                <th class="align-middle" scope="col" style="width: 5%"><label>Floor Number</label></th>
                                <th class="align-middle" scope="col" style="width: 10%"><label>Created Date</label></th>
                                <th class="align-middle" scope="col" style="width: 10%"><label>Updated Date</label></th>
                                <th class="align-middle" scope="col" style="width: 10%"><label>Deleted Date</label></th>
                            </tr>
                        </thead>
                        @if (count($groupList))
                            <tbody>
                                @foreach ($groupList as $group)
                                    <tr class="align-middle">
                                        <td class="align-middle"> <label >{{ $group->id }}</label></td>
                                        <td class="align-middle"> <label >{{ $group->name }}</label></td>
                                        <td class="align-middle"> <label >{{ $group->note }}</label></td>
                                        <td class="align-middle"> <label >{{ $group->user_leader?->name ?? '' }}</label></td>
                                        <td class="align-middle"> <label >{{ $group->group_floor_number }}</label></td>
                                        <td class="align-middle"> <label >{{ formatDateTime($group->created_date, 'd/m/Y') }}</label></td>
                                        <td class="align-middle"> <label >{{ formatDateTime($group->updated_date, 'd/m/Y') }}</label></td>
                                        <td class="align-middle"> <label >{{ formatDateTime( $group->deleted_date, 'd/m/Y') }}</label></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                    @if(count($groupList) == 0)
                        <div class="d-flex justify-content-center" style="font-size: 20px">
                            No Group Found
                        </div>
                    @endif
                </div>
            </div>
            <div class="action d-flex">
                    <div class="group-action">
                        <a id="btn-show-import-modal" class="btn btn-medium btn-outline-success">Import CSV</a>
                    </div>
                    <form action="{{ route('admin.group.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="form-submit" style="opacity: 0">
                        @csrf
                        <div class="form-group py-3 row mx-2">
                            <input type="file" name="file" value="" class="w-100" is-submitted ="" data-content="File">
                            <div class="error-message-list d-flex flex-column my-2">
                            </div>                     
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
@section('jquery')
<script src="{{ asset('js/admin/group/group.js') }}"></script>
    <script src="{{ asset('js/libs/form-validation/group-import.js') }}"></script>
@endsection