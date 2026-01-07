@extends('layouts.dashboard')

@section('title', 'Add')
@section('pageTitle', 'Add')
@section('endpoint', '/transaction/create')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/transaction">Transaction</a></li>
<li class="breadcrumb-item active"><a href="/transaction/create">Add</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Transaction</h3>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, perspiciatis, porro maxime numquam quibusdam doloribus repudiandae minus quae sunt asperiores ex perferendis, possimus a natus illo praesentium. Deleniti, quia minima.</p>
                </div>
            </div>
        </div>
    </div>
    <form id="transaction__form">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="transaction__card">Transaction</h5>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="form-label" for="transaction__amount">Amount</label>
                    <input type="text" class="form-control" id="transaction__amount" name="amount">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="transaction__time">Date</label>
                    <input class="form-control datetimepicker" id="transaction__time" name="time" type="text" value="{{ date('Y-m-d H:i') }}" data-options='{"enableTime":true,"dateFormat":"Y-m-d H:i","disableMobile":true}' />
                </div>
                <div class="row">
                    <div class="col-sm-6 pr-3">
                        <label class="form-label" for="transaction__transaction-type-id">Transaction Direction</label>
                        <div class="border bg-white p-3">
                            <div class="form-check">
                                <input class="form-check-input" id="direction1" type="radio" name="direction" />
                                <label class="form-check-label" for="direction1">Credit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="direction2" type="radio" name="direction" checked="" />
                                <label class="form-check-label" for="direction2">Debit</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 pr-3">
                        <label class="form-label" for="transaction__transaction-type-id">Transaction Exchange</label>
                        <div class="border bg-white p-3">
                            <div class="form-check">
                                <input class="form-check-input" id="exchange1" type="radio" name="exchange" />
                                <label class="form-check-label" for="exchange1">Monetary</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="exchange2" type="radio" name="exchange" checked="" />
                                <label class="form-check-label" for="exchange2">Non Monetary</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="transaction__description">Description</label>
                    <textarea class="form-control" id="transaction__description" name="description" rows="5"></textarea>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="row flex-end-center g-0">
                    <div class="col-auto">
                        <button id="transaction__btn" class="btn btn-outline-primary" type="button">
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
    $('#transaction__btn').on('click', function(e) {
        e.preventDefault();

        $("#transaction__form").parsley().validate();

        if ($("#transaction__form").parsley().isValid()) {
            var data = $("#transaction__form").serialize();

            sendPost('/transaction', data);
        }
    });
</script>
@endsection
