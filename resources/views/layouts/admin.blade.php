@extends('layouts.default')
@section('title')
    @yield('title', 'Admin')
@endsection

@section('style')
    @yield('style')
@endsection

@section('main-content')

    <div class="container" data-layout="container">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>

        @include('includes.navbars.vertical')

        <div class="content">

            @include('includes.navbars.combo')

            @yield('content')

            @include('includes.footer')

        </div>

    </div>

@endsection

@section('script')
    @yield('script')
@endsection
