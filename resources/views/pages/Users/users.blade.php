@extends('layouts.app')

@section('main')
<div class="layout-main layout-default">
    <div class="layout-head">
        <div class="layout-head-left">
            <button class="sidemenu" onclick="document.querySelector('.layout .sidebar').style.display='block'"><i class="material-icons">menu</i></button>
            <h3>Users</h3>
        </div>
        <div class="layout-head-right">
            <div class="layout-head-options">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
            </div>
        </div>
    </div>
    <div class="layout-main-content">
        <div class="default" id="defaultStruct">
            <div class="default-top">
                <div class="search-container">
                    <i class="material-icons">search</i>
                    <input id="search" type="search" placeholder="Search for user's"></input>
                    <script>
                        var searchBox = document.getElementById("search");
                        searchBox.onkeydown = function(e) {
                            if (e.keyCode == 13) window.location.href= window.location.protocol+ "//" + window.location.hostname + window.location.pathname+ "?search="+ searchBox.value;
                        }
                    </script>
                </div>
            </div>
            <div class="users-list" id="usersList">
                <ul>
                    @if($users->count() != 0)
                        @foreach($users as $user)
                        <li data-key="{{$user->id}}">
                            <div class="user-list-avatar">
                                <img src="{{$user->avatar}}" alt="user img" />
                            </div>
                            <div class="user-list-info">
                                <a href="/profile/{{$user->id}}">{{$user->name}}</a>
                                <?php $matchedIn = 0; ?>
                                @foreach($friends as $f)
                                    @if($user->id == $f->id)
                                        @if($f->pivot->status == 1)
                                            <button class="remove-friend" data-thisuser="{{ $currentid }}" data-seconduser="{{ $f->id }}"><span>Remove</span> <i class="material-icons">person_add</i></button>
                                        @elseif($f->status == 0)
                                            @if($f->pivot->sender == $currentid)
                                                <button class="back-request" data-thisuser="{{ $currentid }}" data-seconduser="{{ $f->id }}"><span>Cancel request</span> <i class="material-icons">close</i></button>
                                            @elseif($f->pivot->reciver == $currentid)
                                                <button class="accept-request" data-thisuser="{{ $currentid }}" data-seconduser="{{ $f->id }}" ><span>Accept</span> <i class="material-icons">person_add</i></button>
                                                <button class="reject-request" data-thisuser="{{ $currentid }}" data-seconduser="{{ $f->id }}"><span>Reject</span> <i class="material-icons">close</i></button>
                                            @endif
                                        @endif
                                        <?php $matchedIn = 1; ?>
                                    @endif
                                @endforeach
                                @if($matchedIn == 0)
                                    <button class="add-friend" data-thisuser="{{ $currentid }}" data-seconduser="{{ $user->id }}"><span>Add</span> <i class="material-icons">person_add</i></button>
                                @endif
                                </div>
                        </li>
                        @endforeach
                    @else
                        <li>No user found</li>
                    @endif
                </ul>
            </div>

            <div class="pagination">
                @if($users) {{ $users->appends(request()->input())->links() }} @endif
            </div>
        </div>
    </div>
</div>
@endsection
