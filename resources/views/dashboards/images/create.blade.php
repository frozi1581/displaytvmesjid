@extends('layouts.dashboard')

@section('title', 'Add')
@section('pageTitle', 'Add')
@section('endpoint', '/image/create')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/image">Image</a></li>
<li class="breadcrumb-item active"><a href="/image/create">Add</a></li>
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
    <form id="image__form" enctype="multipart/form-data">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="image__card">Image</h5>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content position-relative">
                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="file-loading">
                                    <input type="file" id="image" name="image" class="file" data-overwrite-initial="false" data-min-file-count="1">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
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
    var input;
    var thumbnail;

    $(".modal-btn").on('click', function() {
        input = $(this).data('inputTarget');
        thumbnail = $(this).data('thumbnailTarget');
    });

    $("#image").fileinput({
        theme: 'fas',
        uploadUrl: '/image',
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
        overwriteInitial: false,
        maxFileSize:20000,
        maxFilesNum: 1,
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Ambil Gambar",
        browseIcon: "<i class=\"bi-file-image\"></i> ",
        removeClass: "btn btn-danger",
        removeLabel: "Hapus",
        removeIcon: "<i class=\"bi-trash\"></i> ",
        uploadClass: "btn btn-info",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"bi-upload\"></i> ",
        ajaxSettings : {
            'headers': {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')},
        },
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    }).on('fileuploaded', function(event, data, previewId, index) {
        location.reload(true);
    });
</script>
@endsection
