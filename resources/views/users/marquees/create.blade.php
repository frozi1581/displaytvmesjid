@extends('layouts.user')

@section('title', 'Add')
@section('pageTitle', 'Add')
@section('endpoint', '/user/marquee/create')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/user/marquee">Teks Berjalan</a></li>
<li class="breadcrumb-item active"><a href="/user/marquee/create">Add</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Teks Berjalan</h3>
                    <p class="mb-0">Modul untuk merubah teks berjalan pada aplikasi anda.</p>
                </div>
            </div>
        </div>
    </div>
    <form id="marquee__form">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="marquee__card">Running Text</h5>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="form-label" for="marquee__content">Content</label>
                    <textarea class="form-control" id="marquee__content" name="content" rows="5"></textarea>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="row flex-end-center g-0">
                    <div class="col-auto">
                        <button id="marquee__btn" class="btn btn-outline-primary" type="button">
                            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('style')
@endsection

@section('script')
<script>
    $('#marquee__btn').on('click', function(e) {
        e.preventDefault();

        $("#marquee__form").parsley().validate();

        if ($("#marquee__form").parsley().isValid()) {
            var data = $("#marquee__form").serialize();

            sendPost('/user/marquee', data);
        }
    });
</script>
@endsection
