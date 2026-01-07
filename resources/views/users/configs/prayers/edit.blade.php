@extends('layouts.user')
@section('title', 'Profile')

@section('style')
<style>
    .gradient {
        width: 115px;
        height: 115px;
        border-radius: .5vw;
        transition: all .5s ease;
        cursor: pointer;
    }

    .gradient:hover {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        filter: brightness(80%);
    }

    @keyframes shake {
        25% {
            transform: translateX(4px)
        }

        50% {
            transform: translateX(-4px)
        }

        75% {
            transform: translateX(4px)
        }
    }
</style>
@endsection
@section('content')
<div class="container">


    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __('config.prayer.'. $configPrayer->name .'.title') }}</h3>
            <p>{{ __('config.prayer.'. $configPrayer->name .'.description') }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">

                    <form method="POST" action="{{ Route::has('config.prayer.update') ? route('config.prayer.update', ['configPrayer' => $configPrayer->id]) : '#' }}#{{ $configPrayer->name }}">

                        @csrf

                        <input type="hidden" name="name" value="{{ $configPrayer->name }}">

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="name">{{ __('config.prayer.time_adjustment.title') }}</label>
                            <div class="input-group mb-3">
                                <input id="{{ $configPrayer->name }}" class="form-control @error('time_adjustment') is-invalid @enderror" id="time_adjustment" type="number" name="time_adjustment" value="{{ $configPrayer->time_adjustment }}" aria-describedby="time_adjustment-addon" min="-100" max="100" required autocomplete="time_adjustment">
                                <span class="input-group-text" id="time_adjustment-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="name">{{ __('config.prayer.before_adzan_interval.title') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('before_adzan_interval') is-invalid @enderror" id="before_adzan_interval" type="number" name="before_adzan_interval" value="{{ $configPrayer->before_adzan_interval }}" aria-describedby="before_adzan_interval-addon" min="1" max="100" required autocomplete="before_adzan_interval">
                                <span class="input-group-text" id="before_adzan_interval-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="name">{{ __('config.prayer.iqama_interval.title') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('iqama_interval') is-invalid @enderror" id="iqama_interval" type="number" name="iqama_interval" value="{{ $configPrayer->iqama_interval }}" aria-describedby="iqama_interval-addon" min="1" max="100" required autocomplete="iqama_interval">
                                <span class="input-group-text" id="iqama_interval-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="name">{{ __('config.prayer.prayer_interval.title') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('prayer_interval') is-invalid @enderror" id="prayer_interval" type="number" name="prayer_interval" value="{{ $configPrayer->prayer_interval }}" aria-describedby="prayer_interval-addon" min="1" max="100" required autocomplete="prayer_interval">
                                <span class="input-group-text" id="prayer_interval-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3" style="display:none;">
                            <label class="form-label" for="name">{{ __('config.prayer.box_background_class.title') }}</label>

                            <div class="row gy-5" >
                                @foreach ($boxBackgroundClasses as $boxBackgroundClass)
                                    @if ($boxBackgroundClass === $configPrayer->box_background_class)
                                        <div class="col-lg-3 d-flex justify-content-center">
                                            <div class="gradient {{ $boxBackgroundClass }} border border-5 border-primary">
                                                <input type="radio" checked name="box_background_class" value="{{ $boxBackgroundClass }}" class="d-none">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-3 d-flex justify-content-center">
                                            <div class="gradient {{ $boxBackgroundClass }} border border-5 border-400">
                                                <input type="radio" name="box_background_class" value="{{ $boxBackgroundClass }}" class="d-none">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendors/choices/choices.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.gradient').on('click', function(e) {
            $(this).parent().siblings().each(function() {
                console.log($(this));
                $(this).find('.gradient').removeClass('border-primary').addClass('border-400');
            });

            let radio = $(this).find('input');
            radio.prop("checked", !radio.prop("checked"));
            $(this).addClass('border-primary').removeClass('border-400');
        });
    });
</script>
@endsection
