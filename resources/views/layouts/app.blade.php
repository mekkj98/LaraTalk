<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth<meta name="user-data" content='<?php echo Auth::user()->toJson(); ?>'>@endauth

    <title>LetsTalk</title>
    <base href="/">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset( 'assets/styles/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div id="app">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        <div class="layout">
            @include('components.sidebar')
            <div class="layout-child content">
                @yield('main')
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="{{ asset('assets/scripts/socket.js') }}"></script>
    <script src="{{ asset('assets/scripts/app.js') }}"></script>
    <script src="{{ asset('assets/scripts/friendship.js') }}"></script>
    <script src="{{ asset('assets/scripts/chat.js') }}"></script>
</body>

</html>
