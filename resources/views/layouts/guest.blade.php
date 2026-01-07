@extends('layouts.default')
@section('title')
    @yield('title', 'Guest')
@endsection

@section('style')
    @yield('style')
@endsection

@section('main-content')

    <div class="container-fluid">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>

        <div class="row min-vh-100 bg-100">
            <div class="col-6 d-none d-lg-block position-relative">
                <div class="bg-holder" style="background-image:url(@yield('background', asset('assets/img/generic/bg-1.jpg')));background-position: 50% 20%;"></div>
            </div>
            <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
                <div class="row justify-content-center g-0">
                    <div class="col-lg-9 col-xl-8 col-xxl-6">

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    @yield('script')
@endsection
