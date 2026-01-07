@extends('layouts.default')
@section('title')
    @yield('title', 'Auth')
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

        @yield('content-container')

    </div>

@endsection

@section('script')
    @yield('script')
@endsection
