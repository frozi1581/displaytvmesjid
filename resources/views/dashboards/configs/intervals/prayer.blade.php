<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Interval Prayer') }}</h3>
        <p>{{ __("Set your signboard silent duration while prayer start.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('config.prayer') }}#prayer">

                    @csrf

                    <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                        <div class="input-group mb-3">
                            <input class="form-control @error('interval_prayer') is-invalid @enderror" id="interval_prayer" type="number" name="value" value="{{ Auth::user()->mosque->configurations->where('meta', 'interval_prayer')->first()->value }}" aria-describedby="interval_prayer-addon" min="1" max="100" required autocomplete="interval_prayer">
                            <span class="input-group-text" id="interval_prayer-addon">Minute</span>
                        </div>

                        @error('interval_prayer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary mt-3" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
