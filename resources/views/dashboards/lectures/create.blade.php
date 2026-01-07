@extends('layouts.dashboard')

@section('title', 'Add')
@section('pageTitle', 'Add')
@section('endpoint', '/lecture/create')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/lecture">Lecture</a></li>
<li class="breadcrumb-item active"><a href="/lecture/create">Add</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Lecture</h3>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, perspiciatis, porro maxime numquam quibusdam doloribus repudiandae minus quae sunt asperiores ex perferendis, possimus a natus illo praesentium. Deleniti, quia minima.</p>
                </div>
            </div>
        </div>
    </div>
    <form id="lecture__form">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="lecture__card">Lecture</h5>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="form-label" for="lecture__topic">Topic</label>
                    <input type="text" class="form-control" id="lecture__topic" name="topic">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lecture__speaker">Speaker</label>
                    <input type="text" class="form-control" id="lecture__speaker" name="speaker">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lecture__time">Date</label>
                    <input class="form-control datetimepicker" id="lecture__time" name="time" type="text" value="{{ date('Y-m-d H:i') }}" data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lecture__description">Description</label>
                    <textarea class="form-control" id="lecture__description" name="description" rows="5"></textarea>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="row flex-end-center g-0">
                    <div class="col-auto">
                        <button id="lecture__btn" class="btn btn-outline-primary" type="button">
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
    $('#lecture__btn').on('click', function(e) {
        e.preventDefault();

        $("#lecture__form").parsley().validate();

        if ($("#lecture__form").parsley().isValid()) {
            var data = $("#lecture__form").serialize();

            sendPost('/lecture', data);
        }
    });
</script>
@endsection
