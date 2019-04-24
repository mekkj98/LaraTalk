@extends('layouts.app')

@section('main')
<div class="layout-main layout-default">
    <div class="layout-head">
        <div class="layout-head-left">
            <button class="sidemenu" onclick="document.querySelector('.layout .sidebar').style.display='block'"><i class="material-icons">menu</i></button>
            <h3>Friends</h3>
        </div>
        <div class="layout-head-right">
            <div class="layout-head-options">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
            </div>
        </div>
    </div>
    <div class="layout-main-content">
        <div class="default" id="defaultStruct">
            <div class="users-list" id="usersList">
                <ul>
                    @if($friends)
                        @foreach($friends as $user)
                        <li data-key="">
                            <div class="user-list-avatar">
                                <img src="{{$user->avatar}}" alt="user img" />
                            </div>
                            <div class="user-list-info">
                                <a href="/profile/{{$user->id}}">{{$user->name}}</a>
                                <button class="remove-friend" data-thisuser="{{ $currentid }}" data-seconduser="{{ $user->id }}"><span>Remove</span> <i class="material-icons">person_add</i></button>
                            </div>
                        </li>
                        @endforeach
                    @else
                        <li style="width:100%;padding: 30px 50px;font-size:30px;text-align:left;background:none">No Friends Yet</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
