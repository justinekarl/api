<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/dist/css/skins/_all-skins.min.css">

    <style>
        body {
                background-image: url("{{ asset('css/images/background_light.png') }}");
        } 
    </style>

        @yield('css')

    </head>
    <body class="text-center pagination-centered">
    @yield('content')

    <!-- jQuery 3 -->
    <script src="{{$templatePlugin->rootLocation()}}/provider/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{$templatePlugin->rootLocation()}}/provider/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{$templatePlugin->rootLocation()}}/provider/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>




    @yield('javascript')

    </body>
</html>
