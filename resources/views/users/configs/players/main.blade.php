@extends('layouts.user')
@section('title', 'Config Player Main')

@section('style')
<style>
    .drop-zone {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: 500;
        font-size: 20px;
        cursor: pointer;
        color: #333;
        border: 3px dashed #aaa;
    }

    .drop-zone--over {
        border-style: solid;
    }

    .drop-zone__input {
        display: none;
    }

    .drop-zone__thumb {
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: #fff;
        background-size: contain;
        background-repeat: no-repeat;
        position: relative;
    }

    .drop-zone__thumb::after {
        content: attr(data-label);
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 5px 0;
        color: #fff;
        background: rgba(0, 0, 0, 0.75);
        text-align: center;
        font-size: 14px;
    }
</style>
@endsection
@section('content')
<div class="container">

    <!--div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Fitur Utama") }}</h3>
            <p>{{ __("Pengaturan fitur utama.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <div class="col-sm-5 col-lg-4 col-xl-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="show" type="checkbox" {{ $configPlayerShow->show_main ? 'checked' : '' }} disabled="" />
                            <label class="form-check-label" for="show">{{ __('Aktifkan fitur ini') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr-->

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Fitur Player Gambar") }}</h3>
            <p>{{ __("Pengaturan fitur player gambar.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('config.player.update', ['image']) }}#show_image" method="post">
                        @csrf

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="show_image" name="show_image" type="checkbox" {{ $configPlayerShow->show_image ? 'checked' : '' }} value="1" />
                            <label class="form-check-label" for="show_image">{{ __('Aktifkan fitur ini') }}</label>

                            @error('show_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="{{ !$configPlayerShow->show_image ? 'd-none' : '' }}">
                            <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                                <label class="form-label" for="interval_image">{{ __('config.prayer.interval_image.title') }}</label>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('interval_image') is-invalid @enderror" id="interval_image" type="number" name="interval_image" value="{{ $configPlayerInterval->interval_image }}" aria-describedby="interval_image-addon" min="1" max="100" {{ !$configPlayerShow->show_image ? 'disabled' : '' }} autocomplete="interval_image">
                                    <span class="input-group-text" id="interval_image-addon">{{ __('generic.time') }}</span>
                                </div>

                                @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row my-4 d-none">
        <div class="col-md-4">
            <h3>{{ __("Fitur Player Video") }}</h3>
            <p>{{ __("Pengaturan fitur video.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('config.player.update', ['video']) }}#show_video" method="post">
                        @csrf

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="show_video" name="show_video" type="checkbox" {{ $configPlayerShow->show_video ? 'checked' : '' }} value="1" />
                            <label class="form-check-label" for="show_video">{{ __('Aktifkan fitur ini') }}</label>

                            @error('show_video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="{{ !$configPlayerShow->show_video ? 'd-none' : '' }}">
                            <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                                <label class="form-label" for="interval_video">{{ __('config.prayer.interval_video.title') }}</label>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('interval_video') is-invalid @enderror" id="interval_video" type="number" name="interval_video" value="{{ $configPlayerInterval->interval_video }}" aria-describedby="interval_video-addon" min="1" max="100" {{ !$configPlayerShow->show_video ? 'disabled' : '' }} autocomplete="interval_video">
                                    <span class="input-group-text" id="interval_video-addon">{{ __('generic.time') }}</span>
                                </div>

                                @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Tampilan") }}</h3>
            <p>{{ __("Pengaturan tampilan.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('config.player.update', ['main']) }}#interval_friday" method="post">
                        @csrf

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="interval_friday">{{ __('config.prayer.interval_friday.title') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('interval_friday') is-invalid @enderror" id="interval_friday" type="number" name="interval_friday" value="{{ $configPlayerInterval->interval_friday }}" aria-describedby="interval_friday-addon" min="1" max="100" autocomplete="interval_friday">
                                <span class="input-group-text" id="interval_friday-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                            <label class="form-label" for="interval_slider">{{ __('config.prayer.interval_slider.title') }}</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('interval_slider') is-invalid @enderror" id="interval_slider" type="number" name="interval_slider" value="{{ $configPlayerInterval->interval_slider }}" aria-describedby="interval_slider-addon" min="0.01" max='0.90' step="any"  autocomplete="interval_slider">
                                <span class="input-group-text" id="interval_slider-addon">{{ __('generic.time') }}</span>
                            </div>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Background Saat Adzan") }}</h3>
            <p>{{ __("Pengaturan bacground waktu adzan.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div id="background_before_adzan" class="card-body p-4 ratio ratio-16x9" style="object-fit: contain">
                    <img src="{{ asset($configPlayer->background_before_adzan) }}" alt="">
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="upload-btn btn btn-primary btn-block" data-url="{{ route('config.player.upload', ['key' => 'background_before_adzan']) }}#background_before_adzan" data-name="background_before_adzan">{{ __('Upload Baru') }}</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Background Saat Iqama") }}</h3>
            <p>{{ __("Pengaturan background waktu iqama.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div id="background_iqama_time" class="card-body p-4 ratio ratio-16x9" style="object-fit: contain">
                    <img src="{{ asset($configPlayer->background_iqama_time) }}" alt="">
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="upload-btn btn btn-primary btn-block" data-url="{{ route('config.player.upload', ['key' => 'background_iqama_time']) }}#background_iqama_time" data-name="background_iqama_time">{{ __('Upload Baru') }}</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row my-4">
        <div class="col-md-4">
            <h3>{{ __("Background Saat Sholat") }}</h3>
            <p>{{ __("Pengaturan background saat sholat.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div id="background_prayer_silent" class="card-body p-4 ratio ratio-16x9" style="object-fit: contain">
                    <img src="{{ asset($configPlayer->background_prayer_silent) }}" alt="">
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button class="upload-btn btn btn-primary btn-block" data-url="{{ route('config.player.upload', ['key' => 'background_prayer_silent']) }}#background_prayer_silent" data-name="background_prayer_silent">{{ __('Upload Baru') }}</button>
                </div>
            </div>
        </div>
    </div>

    <hr>
</div>
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content position-relative">
            <form method="POST" enctype="multipart/form-data">
                @csrf

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 ratio ratio-16x9">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt"><img class="me-2" src="{{ asset('assets/img/icons/cloud-upload.svg') }}" width="25" alt="" />Drop file here or click to upload</span>
                        <input type="file" name="" class="drop-zone__input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $(".upload-btn").on('click', function(e) {
            e.preventDefault();
            let modal = $("#upload-modal");
            let form = modal.find('form');
            let input = form.find('input[type=file]');

            form.attr('action', $(this).data('url'));
            input.attr('name', $(this).data('name'));
            modal.modal('show');
        });

        $('#show_image').on('change', function () {
            $('#interval_image').parent().parent().parent().toggleClass('d-none');
            $('#interval_image').prop('disabled', (i, v) => !v);
        });

        $('#show_video').on('change', function () {
            $('#interval_video').parent().parent().parent().toggleClass('d-none');
            $('#interval_video').prop('disabled', (i, v) => !v);
        });
    });
</script>
<script>
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        dropZoneElement.addEventListener("click", (event) => {
            inputElement.click(); /*clicking on input element whenever the dropzone is clicked so file browser is opened*/
        });

        inputElement.addEventListener("change", (event) => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (event) => {
            event.preventDefault(); /*this along with prevDef in drop event prevent browser from opening file in a new tab*/
            dropZoneElement.classList.add("drop-zone--over");
        });
        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (event) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });
        dropZoneElement.addEventListener("drop", (event) => {
            event.preventDefault();
            console.log(
                event.dataTransfer.files
            ); /*if you console.log only event and check the same data location, you won't see the file due to a chrome bug!*/
            if (event.dataTransfer.files.length) {
                inputElement.files =
                    event.dataTransfer.files; /*asigns dragged file to inputElement*/

                updateThumbnail(
                    dropZoneElement,
                    event.dataTransfer.files[0]
                ); /*thumbnail will only show first file if multiple files are selected*/
            }
            dropZoneElement.classList.remove("drop-zone--over");
        });

        console.log(inputElement);
    });

    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(
            ".drop-zone__thumb"
        );
        /*remove text prompt*/
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").remove();
        }

        /*first time there won't be a thumbnailElement so it has to be created*/
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }
        thumbnailElement.dataset.label =
            file.name; /*takes file name and sets it as dataset label so css can display it*/

        /*show thumbnail for images*/
        if (file.type.startsWith("image/")) {
            const reader = new FileReader(); /*lets us read files to data URL*/
            reader.readAsDataURL(file); /*base 64 format*/
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`; /*asynchronous call. This function runs once reader is done reading file. reader.result is the base 64 format*/
                thumbnailElement.style.backgroundPosition = "center";
            };
        } else {
            thumbnailElement.style.backgroundImage = null; /*plain background for non image type files*/
        }
    }
</script>
@endsection
