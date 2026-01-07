@extends('layouts.dashboard')

@section('title', 'Index')
@section('pageTitle', 'Index')
@section('endpoint', '/image')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/image">Image</a></li>
<li class="breadcrumb-item active"><a href="/image">Index</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Image</h3>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, perspiciatis, porro maxime numquam quibusdam doloribus repudiandae minus quae sunt asperiores ex perferendis, possimus a natus illo praesentium. Deleniti, quia minima.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <div>
                <p class="m-1">
                    <a href="/image/create" class="float-right btn btn-success">Add</a>
                    <a href="/image/all" class="float-right btn btn-danger _delete">Truncate</a>
                </p>
            </div>
        </div>
        <div class="card-body">
            <div class="row mx-n1">

                @foreach ($data as $value)
                    <div class="col-4 p-1">
                        <div class="hoverbox rounded-3 text-center">
                            <img class="img-fluid" style="object-fit: cover; max-height: 300px; min-height: 300px;" src="{{ $value->url }}" alt="" />
                            <div class="light hoverbox-content bg-dark p-5 flex-center">
                            <div>
                                <a class="post1 btn btn-light btn-sm mt-1" href="{{ $value->url }}" data-gallery="gallery-1"><i class="fas fa-expand-arrows-alt"></i></a>
                                <a class="btn btn-light btn-sm mt-1 _delete" href="/image/{{ $value->id }}"><i class="fas fa-trash"></i></a>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
