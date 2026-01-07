<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Update Password') }}</h3>
        <p>{{ __("Ensure your account is using a long, random password to stay secure.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('profile.password') }}#current_password">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="current_password">{{ __('Old Password') }}</label>
                        <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" type="password" name="current_password" value="{{ old('current_password') }}" required autocomplete="current-password" autofocus>

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">{{ __('New Password') }}</label>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password-confirm">{{ __('New Password Confirmation') }}</label>
                        </div>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
