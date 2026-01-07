@extends('layouts.guest')
@section('title', 'Login')
@section('background', asset('assets/img/generic/14.jpg'))

@section('content')

<div class="card">
    <div class="card-header bg-circle-shape bg-shape text-center p-2">
        <a class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light" href="{{ url('/') }}">Aplikasi Masjid</a>
    </div>
    <div class="card-body p-4">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h3>{{ __('Login') }}</h3>
            </div>
            <div class="col-auto fs--1 text-600">
                <span class="mb-0 fw-semi-bold">{{ __('New User?') }}</span>
                <span>
                    <a href="{{ route('register') }}">{{ __('Create account') }}</a>
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="mb-3">
                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                </div>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row flex-between-center">
                <div class="col-auto">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label mb-0" for="remember">{{ __('Remember Me') }}</label>
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <div class="col-auto">
                        <a class="fs--1" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                @endif

            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">{{ __('Login') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
