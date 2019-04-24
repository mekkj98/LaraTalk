@extends('layouts.app')

@section('main')
<div class="layout-main layout-default">
    <div class="layout-head">
        <div class="layout-head-left">
            <button class="sidemenu" onclick="document.querySelector('.layout .sidebar').style.display='block'"><i class="material-icons">menu</i></button>
            <h3>Settings</h3>
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
                        <li>
                            <div class="image-boc">
                                <div class="usr-image">
                                    <img src="{{ $user->avatar }}" alt="">
                                </div>
                                <div class="user-name">
                                    <h2>{{ $user->name }}</h2>
                                </div>
                            </div>
                            <div class="user-details-content">
                                <form onsubmit="return false;">
                                    <table>
                                        <tr>
                                            <td>Email : </td>
                                            <td> {{ $user->email }} </td>
                                        </tr>
                                        <tr>
                                            <td>Created At : </td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hide Gender : </td>
                                            <td>
                                                <select name="hide_gender" id="hideGender">
                                                    <option value="1">Default</option>
                                                    <option value="1" @if($user->setting->hide_gender == 1) selected @endif>Yes</option>
                                                    <option value="0" @if($user->setting->hide_gender == 0) selected @endif>NO</option>
                                               </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hide Email : </td>
                                            <td>
                                                <select name="hide_email" id="hideEmail">
                                                    <option value="1">Default</option>
                                                    <option value="1" @if($user->setting->hide_email == 1) selected @endif>Yes</option>
                                                    <option value="0" @if($user->setting->hide_email == 0) selected @endif>NO</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" value="Update Settings" id="settingSubmit">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
