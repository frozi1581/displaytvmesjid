<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Calculation Method') }}</h3>
        <p>{{ __("Set your prayer time calculation methods.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('config.calculation_method') }}#calculation_method">

                    @csrf

                    <div class="mb-3">
                        <select class="form-select js-choice @error('value') is-invalid @enderror" id="value" size="1" name="value" data-options='{"removeItemButton":true,"placeholder":true}' required>
                            <option value="">Select Calculation Method...</option>
                            @foreach ($calculationMethods as $calculationMethod)
                                @if ($calculationMethod->id == Auth::user()->mosque->configurations->where('meta', 'prayer_calculation_method')->first()->value)
                                    <option selected value="{{ $calculationMethod->id }}">{{ $calculationMethod->name }}</option>
                                @else
                                    <option value="{{ $calculationMethod->id }}">{{ $calculationMethod->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('value')
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
