@extends('layouts.app')
@section('main')
<div class="layout-main layout-chat">
    <div class="layout-head">
        <div class="layout-head-left">
            <button class="sidemenu" onclick="document.querySelector('.layout .sidebar').style.display='block'"><i class="material-icons">menu</i></button>
            <h3>Chat</h3>
        </div>
        <div class="layout-head-right">
            <div class="layout-head-options">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
            </div>
        </div>
    </div>
    <div class="layout-main-content">
        <div class="chat" id="chatStruct">
            <div class="chat">
                @include('pages.Chat.partials.chatlist')
                @include('pages.Chat.partials.single')    
            </div>
        </div>
    </div>
</div>
@endsection
