<div class="sidebar">
    <div class="wrap p-0">
        <div class="content">
            <div class="menu-list">
                <div class="menu-item">
                    <a class="{{ (request()->is('admin/user*')) ? 'active' : '' }}" href="{{route('admin.user.index')}}">User List</a>
                </div>
                @if(Auth::user()->position_id == getUserFlag('DIRECTOR'))
                    <div class="menu-item ">
                        <a class="{{ (request()->is('admin/group*')) ? 'active' : '' }}" href="{{route('admin.group.index')}}">Group List</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
