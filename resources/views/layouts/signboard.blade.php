<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Motions | Player</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('/assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous">
    <link href="{{ asset('/assets/vendors/signboard/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/vendors/signboard/css/Includes/home.css') }}" rel="stylesheet" />

    @section('style')

    @show
</head>
<body style="overflow: hidden;" onload="openFullscreen()">

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    @section('content')
    @show

    <input type="hidden" id="user-token" value="{{ base64_encode(Auth::user()->email) }}">
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!--**********************************
        Scripts
    ***********************************-->

    <script src="{{ asset('/assets/vendors/signboard/js/app.js') }}"></script>
    <script src="{{ asset('/assets/vendors/signboard/js/Includes/home.js') }}"></script>

    <script>
        var elem = document.documentElement;

        /* View in fullscreen */
        function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }
    </script>

    @section('script')

    @show
</body>
</html>
