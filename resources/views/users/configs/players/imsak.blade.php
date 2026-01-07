@extends('layouts.user')
@section('title', 'Config Player Imsak')

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
            <h3>{{ __("Fitur Imsak") }}</h3>
            <p>{{ __("Pengaturan fitur imsak.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('config.player.imsak.update', ['show']) }}" method="POST">
                        @csrf

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="with_imsak" name="with_imsak" type="checkbox" {{ $configPlayer->with_imsak ? 'checked' : '' }} value="1"/>
                            <label class="form-check-label" for="with_imsak">{{ __('Aktifkan fitur ini') }}</label>

                            @error('with_imsak')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="mb-3">
                                <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="{{ !$configPlayer->with_imsak ? 'd-none' : '' }}">

        <div class="row my-4">
            <div class="col-md-4">
                <h3>{{ __('config.prayer.'. $configPrayer->name .'.title') }}</h3>
                <p>{{ __('config.prayer.'. $configPrayer->name .'.description') }}</p>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">

                        <form method="POST" action="{{ Route::has('config.player.imsak.update') ? route('config.player.imsak.update', ['key' => 'prayer']) : '#' }}#{{ $configPrayer->name }}">

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

                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('config.prayer.box_background_class.title') }}</label>

                                <div class="row gy-5">
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

</div>
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content position-relative">
            <form method="POST" action="">
                @csrf

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 ratio ratio-16x9">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt"><img class="me-2" src="{{ asset('assets/img/icons/cloud-upload.svg') }}" width="25" alt="" />Drop file here or click to upload</span>
                        <input type="file" name="" class="drop-zone__input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.gradient').on('click', function(e) {
        $(this).parent().siblings().each(function() {
            console.log($(this));
            $(this).find('.gradient').removeClass('border-primary').addClass('border-400');
        });

        let radio = $(this).find('input');
        radio.prop("checked", !radio.prop("checked"));
        $(this).addClass('border-primary').removeClass('border-400');
    });
</script>
@endsection
