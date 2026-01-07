@extends('layouts.user')

@section('title', 'Index')
@section('pageTitle', 'Index')
@section('endpoint', '/transaction')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/transaction">Transaction</a></li>
<li class="breadcrumb-item active"><a href="/transaction">Index</a></li>
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

    <div class="card mb-3">
        <div class="card-header">
            <div>
                <p class="m-1">
                    <a href="/transaction/create" class="float-right btn btn-success">Add</a>
                    <a href="/transaction/all" class="float-right btn btn-danger _delete">Truncate</a>
                </p>
            </div>
        </div>
        <div class="card-body">
            <div id="transaction__table">
                <div class="table-responsive scrollbar">
                    <table class="table table-striped">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th style="width: 10px; text-align: center">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 0)
                            @foreach ($data as $value)
                                <tr>
                                    <td style="width: 10px; text-align: center">{{ ++$i }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td class="text-end">
                                        <div>
                                            <a class="btn p-0" href="/transaction/{{ $value->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><span class="text-500 fas fa-eye"></span></a>
                                            <a class="btn p-0 ms-2" href="/transaction/edit/{{ $value->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></a>
                                            <a class="btn p-0 ms-2 _delete" href="/transaction/{{ $value->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
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
