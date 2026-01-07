<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Additional Information') }}</h3>
        <p>{{ __("Update your account's additional information.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('profile.additional') }}#additional">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="phone">{{ __('Phone') }}</label>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ Auth::user()->mosque->phone }}" required autocomplete="phone">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="manager">{{ __('Manager') }}</label>
                        <input class="form-control @error('manager') is-invalid @enderror" id="manager" type="text" name="manager" value="{{ Auth::user()->mosque->manager }}" required autocomplete="manager">

                        @error('manager')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">{{ __('Address') }}</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" type="text" name="address" required autocomplete="address">{{ Auth::user()->mosque->address }}</textarea>

                        @error('address')
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
