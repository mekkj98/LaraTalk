@extends('layouts.app')

@section('main')
<div class="layout-main layout-default">
    <div class="layout-head">
        <div class="layout-head-left">
            <button class="sidemenu" onclick="document.querySelector('.layout .sidebar').style.display='block'"><i class="material-icons">menu</i></button>
            <h3>Profile</h3>
        </div>
        <div class="layout-head-right">
            <div class="layout-head-options">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i></a>
            </div>
        </div>
    </div>
    <div class="layout-main-content">
        <div class="default" id="defaultStruct">
            <div class="users-list-profile" id="usersList">
                <div class="user-details">
                    <ul>
                        @if($user)
                        <li>
                            <div class="image-boc">
                                <div class="usr-image">
                                    <img src="{{ $user->avatar }}" alt="">
                                </div>
                                <div class="user-name">
                                    <h2>{{$user->name}}</h2>
                                </div>
                            </div>
                            <div class="user-details-content">
                                <table>
                                    
                                    <tr>
                                        <td>Email : </td>
                                        <td>
                                            @if($user->setting->hide_email == 0) 
                                                {{$user->email}} 
                                            @else 
                                                {{ 'Hidden' }} 
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gender : </td>
                                        <td>
                                            @if($user->setting->hide_gender == 0) 
                                                {{$user->gender}} 
                                            @else 
                                                {{ 'Hidden' }} 
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Is Online : </td>
                                        <td> <?= ($user->activity->is_online == 1) ? "Yes" : "No"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created At : </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Last Login : </td>
                                        <td>{{  $user->activity->updated_at->diffForHumans() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </li>
                        @else
                        <li>No Such User Exists</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
