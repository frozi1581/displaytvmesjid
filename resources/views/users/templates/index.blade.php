@extends('layouts.user')

@section('title', __('template.title'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}">{{ __('dashboard.title') }}</a></li>
<li class="breadcrumb-item active"><a href="{{ Route::has('template') ? route('template') : '#' }}">{{ __('template.title') }}</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-5">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ __('template.title') }}</h3>
                    <p class="mb-0">{{ __('template.description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <p class="m-0">
        <button id="template-btn" class="btn btn-success d-none">{{ __('template.save') }}</button>
    </p>

    <div class="overflow-hidden mt-4">
        <ul class="nav nav-tabs nav-justified" id="template-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="background-tab" data-bs-toggle="tab" href="#tab-background" role="tab" aria-controls="tab-background" aria-selected="false">{{ __('template.background.title') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="image-tab" data-bs-toggle="tab" href="#tab-image" role="tab" aria-controls="tab-image" aria-selected="true">{{ __('template.image.title') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="video-tab" data-bs-toggle="tab" href="#tab-video" role="tab" aria-controls="tab-video" aria-selected="false">{{ __('template.video.title') }}</a>
            </li>
        </ul>
        <form id="template-form" action="{{ Route::has('template.pick') ? route('template.pick') : '#' }}" method="POST">
            @csrf
            <div class="tab-content" id="template-tab-content">
                <div class="tab-pane fade show active" id="tab-background" role="tabpanel" aria-labelledby="background-tab">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="row g-2">
                                @foreach ($data as $value)
                                    <div class="col p-1">
                                        <div class="hoverbox rounded-3 text-center w-100 h-100 border border-5">
                                            <img class="w-100 h-100" style="max-width: 100%; max-height: 450px;" src="{{ $value->url }}" />
                                            <div class="light hoverbox-content p-5 flex-center" style="background: rgba(0, 5, 10, .7);">
                                                <input name="templates[]" class="file-check form-check-input m-1" style="position: absolute; top: 0; left: 0; border-radius: 100%;" type="checkbox" value="" />
                                                <div>
                                                    <a class="post1 btn btn-light btn-sm mt-1" href="{{ $value->url }}" data-gallery="gallery-1"><i class="fas fa-expand-arrows-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-image" role="tabpanel" aria-labelledby="image-tab">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="row g-2">
                                @foreach ($data as $value)
                                    <div class="col p-1">
                                        <div class="hoverbox rounded-3 text-center w-100 h-100 border border-5">
                                            <img class="w-100 h-100" style="max-width: 100%; max-height: 450px;" src="{{ $value->url }}" />
                                            <div class="light hoverbox-content p-5 flex-center" style="background: rgba(0, 5, 10, .7);">
                                                <input name="templates[]" class="file-check form-check-input m-1" style="position: absolute; top: 0; left: 0; border-radius: 100%;" type="checkbox" value="" />
                                                <div>
                                                    <a class="post1 btn btn-light btn-sm mt-1" href="{{ $value->url }}" data-gallery="gallery-1"><i class="fas fa-expand-arrows-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-video" role="tabpanel" aria-labelledby="video-tab">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="row g-2">
                                @foreach ($data as $value)
                                    <div class="col p-1">
                                        <div class="hoverbox rounded-3 text-center w-100 h-100 border border-5">
                                            <img class="w-100 h-100" style="max-width: 100%; max-height: 450px;" src="{{ $value->url }}" />
                                            <div class="light hoverbox-content p-5 flex-center" style="background: rgba(0, 5, 10, .7);">
                                                <input name="templates[]" class="file-check form-check-input m-1" style="position: absolute; top: 0; left: 0; border-radius: 100%;" type="checkbox" value="{{ $value->id }}" />
                                                <div>
                                                    <a class="post1 btn btn-circle btn-sm text-light mt-1" href="https://www.sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4" data-gallery="gallery-1"><i class="fas fa-play-circle fa-3x"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="template-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('template.selected') }}</h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('generic.button.close') }}</button>
                <button id="template-save-btn" class="btn btn-primary" type="button">{{ __('generic.button.save') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .file-check {
        pointer-events: none;
    }

    .file-check,
    .hoverbox-content {
        cursor: pointer;
    }

    .post1,
    .hoverbox,
    #template-btn {
        transition: all .5s ease;
    }

    .post1:hover {
        filter: brightness(50%);
        transform: scale(1.1);
    }

</style>
@endsection

@section('script')
<script>
    function checker(checkElem) {
        checkElem.parent().parent().toggleClass('border-primary');
        $('#template-btn').removeClass('d-none');

        if ($('.file-check:checked').length < 1)
            $('#template-btn').addClass('d-none');
    }

    $(document).ready(function() {
        $('.hoverbox-content').on('click', function(e) {
            let checkbox = $(this).find('.file-check');
            console.log(checkbox);
            checkbox.prop("checked", !checkbox.prop("checked"));
            checker(checkbox);
        });

        $('.post1').on('click', function (e) {
            e.stopPropagation();
        });

        $('#template-btn').on('click', function (e) {
            let templateRow = $('#template-modal .row');
            $('.file-check:checked').each(function() {
                templateRow.append($(this).parent().parent().parent());
            });
            $('#template-modal').modal('show');
        });

        $('#template-save-btn').on('click', function (e) {
            $('#template-form').submit();
        });
    });
</script>
@endsection
