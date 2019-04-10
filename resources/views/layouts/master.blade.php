<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Stylesheets -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::to('css/main.css') }}" rel="stylesheet" type="text/css">
        @yield('styles')
    </head>
    <body>
        @include('includes.header')
        <div class="main">
            <div class="container">
                @yield('content')
            </div>
        </div>
        @yield('scripts')
    </body>
</html>
