@extends('layouts.guest')
@section('title', 'Register')
@section('background', asset('assets/img/generic/14.jpg'))

@section('content')
<div class="card">
    <div class="card-header bg-circle-shape bg-shape text-center p-2">
        <a class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light"
            href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div class="card-body p-4">
        <div class="row flex-between-center">
            <div class="col-auto">
                <h3>{{ __('Register') }}</h3>
            </div>
            <div class="col-auto fs--1 text-600">
                <span class="mb-0 fw-semi-bold">{{ __('Already User?') }}</span>
                <span>
                    <a href="{{ Route::has('login') ? route('login') : '#' }}">{{ __('Login') }}</a>
                </span>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ Route::has('register') ? route('register') : '#' }}">
        @csrf

        <div class="card-body p-0">
            <div class="card theme-wizard h-100">
                <div class="card-header bg-light pt-3 pb-2">
                    <ul class="nav justify-content-between nav-wizard">
                        <li class="nav-item">
                            <a class="nav-link active fw-semi-bold" href="#account" data-bs-toggle="tab" data-wizard-step="data-wizard-step">
                                <span class="nav-item-circle-parent">
                                    <span class="nav-item-circle">
                                        <span class="fas fa-lock"></span>
                                    </span>
                                </span>
                                <span class="d-none d-md-block mt-1 fs--1">Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semi-bold" href="#personal" data-bs-toggle="tab" data-wizard-step="data-wizard-step">
                                <span class="nav-item-circle-parent">
                                    <span class="nav-item-circle">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </span>
                                <span class="d-none d-md-block mt-1 fs--1">Personal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semi-bold" href="#address" data-bs-toggle="tab" data-wizard-step="data-wizard-step">
                                <span class="nav-item-circle-parent">
                                    <span class="nav-item-circle">
                                        <span class="fas fa-address-card"></span>
                                    </span>
                                </span>
                                <span class="d-none d-md-block mt-1 fs--1">Address</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semi-bold" href="#done" data-bs-toggle="tab" data-wizard-step="data-wizard-step">
                                <span class="nav-item-circle-parent">
                                    <span class="nav-item-circle">
                                        <span class="fas fa-thumbs-up"></span>
                                    </span>
                                </span>
                                <span class="d-none d-md-block mt-1 fs--1">Done</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body py-4" id="wizard-controller">
                    <div class="tab-content">

                        <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="account" id="account">
                            <div class="needs-validation" novalidate="novalidate">
                                <div class="mb-3">
                                    <label class="form-label" for="name">{{ __('Name') }}</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <div class="invalid-feedback">You must add name</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                    <input class="form-control" pattern="^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$" data-wizard-validate-email="true" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <div class="invalid-feedback">You must add email</div>
                                </div>
                                <div class="row g-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="password">{{ __('Password') }}</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="new-password" data-wizard-validate-password="true" >
                                        <div class="invalid-feedback">You must add password</div>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="password-confirm">{{ __('Password Confirm') }}</label>
                                        <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" data-wizard-validate-confirm-password="true" >
                                        <div class="invalid-feedback">You must add password confirmation</div>
                                    </div>
                                </div>
                                <div class="form-check d-none">
                                    <input class="form-check-input disabled" disabled type="checkbox" name="terms" required="required" checked="checked" id="bootstrap-wizard-validation-wizard-checkbox" />
                                    <label class="form-check-label disabled" disabled for="bootstrap-wizard-validation-wizard-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="personal" id="personal">
                            <div>
                                <div class="mb-3">
                                    <label class="form-label" for="manager">{{ __('Manager') }}</label>
                                    <input class="form-control @error('manager') is-invalid @enderror" id="manager" type="text" name="manager" value="{{ old('manager') }}" required autocomplete="manager" autofocus>
                                    <div class="invalid-feedback">You must add manager</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">{{ __('Phone') }}</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                    <div class="invalid-feedback">You must add phone</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="address" id="address">
                            <div class="form-validation">
                                <div class="mb-3">
                                    <label class="form-label" for="address">{{ __('Address') }}</label>
                                    <input class="form-control @error('address') is-invalid @enderror" id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                                    <div class="invalid-feedback">You must add address</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="city">{{ __('City') }}</label>
                                    <input class="form-control @error('city') is-invalid @enderror" id="city" type="text" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                    <div class="invalid-feedback">You must add city</div>
                                </div>
                                <div class="row g-2">
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="province">{{ __('Province') }}</label>
                                        <input class="form-control @error('province') is-invalid @enderror" id="province" type="text" name="province" value="{{ old('province') }}" required autocomplete="province" autofocus>
                                        <div class="invalid-feedback">You must add province</div>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label class="form-label" for="postal_code">{{ __('Postal Code') }}</label>
                                        <input class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" required autocomplete="postal_code" autofocus>
                                        <div class="invalid-feedback">You must add postal code</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="done" id="done">
                            <div class="wizard-lottie-wrapper">
                                <div class="lottie wizard-lottie mx-auto my-3" data-options='{"path":"{{ asset('assets/img/animated-icons/celebration.json') }}"}'></div>
                            </div>
                            <h4 class="mb-1">Your account is all set!</h4>
                            <p>Now you can access to your account</p>
                            <button class="btn btn-primary px-5 my-3" type="submit">Save</button>
                            <button class="btn btn-danger px-5 my-3" onclick="window.reload()">Start Over</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="px-sm-3 px-md-5">
                        <ul class="pager wizard list-inline mb-0">
                            <li class="previous">
                                <button class="btn btn-link ps-0" type="button"><span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span>Prev</button>
                            </li>
                            <li class="next">
                                <button class="btn btn-primary px-5 px-sm-6" type="button">Next<span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
