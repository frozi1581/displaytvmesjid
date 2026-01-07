@extends('layouts.user')
@section('title', 'Konfugrasi Fitur')

@section('style')
@endsection
@section('content')
<div class="container">


    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __('config.player.title') }}</h3>
            <p>{{ __('config.player.description') }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    @foreach ($players as $player)
                        <a href="{{ Route::has('config.player.' . $player) ? route('config.player.' . $player) : '#' }}" class="card mb-3 text-decoration-none border border-primary">
                            <div class="card-body p-2">
                                <div class="row align-items-sm-center">
                                    <div class="col-auto">
                                        <img src="{{ asset('assets/img/icons/connect-circle.png') }}" alt="" height="30">
                                    </div>
                                    <div class="col">
                                        <div class="row align-items-center">
                                            <div class="col col-lg-8"><h5 class="mb-3 mb-sm-0 text-secondary">Pengaturan Fitur {{ (($player === 'main') ? 'Slider' : Str::title($player)) }}</h5></div>
                                            <div class="col-12 col-sm-auto ms-auto">
                                                <span class="fas fa-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __('config.prayer.title') }}</h3>
            <p>{{ __('config.prayer.description') }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    @foreach ($prayers as $prayer)
                        <a href="{{ Route::has('config.prayer.edit') ? route('config.prayer.edit', ['prayer' => $prayer]) : '#' }}" class="card mb-3 text-decoration-none border border-primary">
                            <div class="card-body p-2">
                                <div class="row align-items-sm-center">
                                    <div class="col-auto">
                                        <img src="{{ asset('assets/img/icons/connect-circle.png') }}" alt="" height="30">
                                    </div>
                                    <div class="col">
                                        <div class="row align-items-center">
                                            <div class="col col-lg-8"><h5 class="mb-3 mb-sm-0 text-secondary">Pengaturan Waktu Sholat {{ Str::title($prayer) }}</h5></div>
                                            <div class="col-12 col-sm-auto ms-auto">
                                                <span class="fas fa-chevron-right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
</script>
@endsection
