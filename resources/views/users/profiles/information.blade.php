<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Profile Information') }}</h3>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('profile.information') }}#logo_url" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="upload-section">{{ __('Logo') }}</label>
                        <div id="upload-section" class="d-flex flex-col gap-4">
                            <input type="text" name="logo_url" class="d-none" value="{{ str_contains(Auth::user()->mosque->logo, 'ui-avatars.com') ? null : Auth::user()->mosque->logo }}">
                            <input id="upload-input" type="file" name="logo" class="d-none">
                            <img id="upload-preview" class="img-fluid rounded-circle shadow-sm @error('logo') is-invalid border border-danger @enderror" src="{{ Auth::user()->mosque->logo }}" alt="" width="100">
                            <div class="d-flex align-items-center" aria-describedby="popover-error">
                                <button id="upload-btn" class="btn btn-outline-info">{{ __('Select A New Photo') }}</button>
                            </div>
                            @error('logo')
                                <div class="d-flex align-items-center">
                                    <div id="upload-error" class="is-invalid popover fade show bs-popover-end position-relative border-0" role="tooltip">
                                        <div class="popover-arrow m-0" style="position: absolute; transform: translate(0px, 19px); top: 0px;"></div>
                                        <div class="popover-body bg-soft-danger rounded"><strong>{{ $message }}</strong></div>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">{{ __('Nama Masjid') }}</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('Email Address') }}</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                        @error('email')
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
