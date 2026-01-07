@extends('layouts.dashboard')

@section('title', 'Show')
@section('pageTitle', 'Show')
@section('endpoint', '/marquee')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/marquee">Marquee</a></li>
<li class="breadcrumb-item active"><a href="/marquee">Show</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $data->id }} | Marquee</h3>
                    <p class="mb-0">{{ $data->content }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
@endsection

@section('script')
<script>
</script>
@endsection
