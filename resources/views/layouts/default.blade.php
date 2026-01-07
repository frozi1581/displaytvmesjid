<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ (App::isLocale('ar') ? 'rtl' : 'ltr') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>


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
    <script src="{{ asset('/assets/js/config.js') }}"></script>
    <script src="{{ asset('/vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap" rel="stylesheet">

    <link href="{{ asset('/vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/image-picker/image-picker.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/plyr/plyr.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />


    <link href="{{ asset('/assets/css/theme-rtl.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('/assets/css/theme.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('/assets/css/user-rtl.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('/assets/css/user.css') }}" rel="stylesheet" id="user-style-default">
    <link href="{{ asset('/assets/css/player.css') }}" rel="stylesheet" id="style-rtl">





    @yield('head')

    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    @yield('style')
</head>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        @yield('main-content')
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts - Vendors -->
    <!-- ===============================================-->
    <script src="{{ asset('/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('/vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('/vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('/vendors/parsley/parsley.min.js') }}"></script>
    <script src="{{ asset('/vendors/parsley/parsley.id.min.js') }}"></script>
    <script src="{{ asset('/vendors/bootstrap-toaster/bootstrap-toaster.min.js') }}"></script>
    <script src="{{ asset('/vendors/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('/vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('/vendors/lottie/lottie.min.js') }}"></script>
    <script src="{{ asset('/vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('/vendors/image-picker/image-picker.min.js') }}"></script>
    <script src="{{ asset('/vendors/plyr/plyr.polyfilled.min.js') }}"></script>
    <script src="{{ asset('/vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('/assets/js/moment.min.js') }}"></script>





    <!-- ===============================================-->
    <!--    JavaScripts - CDN -->
    <!-- ===============================================-->
    <script src=""></script>

    <!-- ===============================================-->
    <!--    JavaScripts - Custom -->
    <!-- ===============================================-->
    <script src="{{ asset('/assets/js/theme.js') }}"></script>
    <script src="{{ asset('/assets/js/form.js') }}"></script>
    <script src="{{ asset('/assets/js/request.js') }}"></script>
    <script src="{{ asset('/assets/js/helper.js') }}"></script>
    <script src="{{ asset('/assets/js/player.js') }}"></script>

    @yield('script')

</body>

</html>
