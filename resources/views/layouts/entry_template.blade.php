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
        <link href="{{ URL::to('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::to('css/entry.css') }}" rel="stylesheet" type="text/css">

    </head>
    <body>
        @include('includes.entry_header')
        @include('includes.notice_box')
        <div class="container">
            <div class="entry-main">
                @yield('content')
            </div>
        </div>
        @include('includes.entry_footer')


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ URL::to('js/jquery-3.1.1.min.js') }}"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ URL::to('js/bootstrap.min.js') }} "></script>
        <script src="{{ URL::to('js/custom.js') }} "></script>
        <script type="text/javascript">
            var baseUrl = "{{ URL::to('/') }}";
        </script>
        @yield('scripts')
    </body>
</html>