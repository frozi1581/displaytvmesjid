@extends('layouts.user')

@section('title', 'Edit')
@section('pageTitle', 'Edit')
@section('endpoint', '/lecture/edit')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/lecture">Transaction Type</a></li>
<li class="breadcrumb-item active"><a href="/lecture/edit">Edit</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Transaction Type</h3>
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
                        <h5 class="mb-0" data-anchor="data-anchor" id="lecture__card">Transaction Type</h5>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="form-label" for="lecture__name">Name</label>
                    <input type="text" class="form-control" id="lecture__name" name="name" value="{{ $data->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lecture__description">Description</label>
                    <textarea class="form-control" id="lecture__description" name="description" rows="5">{{ $data->description }}</textarea>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="row flex-end-center g-0">
                    <div class="col-auto">
                        <button id="lecture__btn" class="btn btn-outline-primary" type="button">
                            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Edit
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

            sendPut('/lecture/{{ $data->id }}', data);
        }
    });
</script>
@endsection
