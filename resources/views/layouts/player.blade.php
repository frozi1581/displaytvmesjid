@extends('layouts.default')
@section('title')
    @yield('title', 'Guest')
@endsection

@section('head')
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

        <div class="row">

            @yield('content')

        </div>

    </div>

@endsection

@section('script')
    @yield('script')
@endsection
