<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Interval Lecture') }}</h3>
        <p>{{ __("Set your signboard image slider to lecture table looping time.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('config.lecture') }}#lecture">

                    @csrf

                    <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                        <div class="input-group mb-3">
                            <input class="form-control @error('interval_lecture') is-invalid @enderror" id="interval_lecture" type="number" name="value" value="{{ Auth::user()->mosque->configurations->where('meta', 'interval_lecture')->first()->value }}" aria-describedby="interval_lecture-addon" min="1" max="100" required autocomplete="interval_lecture">
                            <span class="input-group-text" id="interval_lecture-addon">Minute</span>
                        </div>

                        @error('interval_lecture')
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
