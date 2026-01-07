@extends('layouts.auth')
@section('title')
    @yield('title', 'User')
@endsection

@section('style')
    @yield('style')
@endsection

@section('content-container')


    @include('includes.users.sidebar')

    <div class="content">

        @include('includes.users.header')

        <div class="col-md-12 py-3 px-5">
            <nav style="--falcon-breadcrumb-divider: '»';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="col-md-12 py-3 px-5">
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')

        @include('includes.footer')

        @if (session('error'))
            <div class="toast show m-2 position-fixed end-0 bottom-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Error</strong>
                    <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        @endif

    </div>

@endsection

@section('script')
    @yield('script')
@endsection
