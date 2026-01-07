@extends('layouts.user')
@section('title', 'Config Player Kajian')

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

    <div class="row my-4 d-none">
        <div class="col-md-4">
            <h3>{{ __("Fitur Infromasi Kajian") }}</h3>
            <p>{{ __("Pengaturan fitur informasi kajian.") }}</p>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('config.player.lecture.update', ['show']) }}" method="post">
                        @csrf

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="show_lecture" name="show_lecture" type="checkbox" {{ $configPlayerShow->show_lecture ? 'checked' : '' }} value="1" />
                            <label class="form-check-label" for="show_lecture">{{ __('Aktifkan fitur ini') }}</label>

                            @error('show_lecture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="mb-3">
                                <button class="btn btn-primary mt-3 float-end" type="submit" name="submit">{{ __('generic.button.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="{{ !$configPlayerShow->show_lecture ? 'd-none' : '' }}">

        <div class="row my-4">
            <div class="col-md-4">
                <h3>{{ __("Pengaturan Interval") }}</h3>
                <p>{{ __("Pengaturan fitur interval.") }}</p>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <form action="{{ route('config.player.lecture.update', ['interval']) }}" method="post">
                            @csrf

                            <div class="col-sm-5 col-lg-4 col-xl-3 mb-3">
                                <label class="form-label" for="interval_lecture">{{ __('config.prayer.interval_lecture.title') }}</label>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('interval_lecture') is-invalid @enderror" id="interval_lecture" type="number" name="interval_lecture" value="{{ $configPlayerInterval->interval_lecture }}" aria-describedby="interval_lecture-addon" min="1" max="100" {{ !$configPlayerShow->show_lecture ? 'disabled' : '' }} autocomplete="interval_lecture">
                                    <span class="input-group-text" id="interval_lecture-addon">{{ __('generic.time') }}</span>
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
                <h3>{{ __("Pengaturan Background") }}</h3>
                <p>{{ __("Pengaturan fitur background.") }}</p>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4 ratio ratio-16x9">
                        <img src="{{ $configPlayer->background_lecture }}" alt="">
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button class="upload-btn btn btn-primary btn-block" data-url="{{ route('config.player.upload', ['key' => 'background_lecture']) }}">{{ __('Upload Baru') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

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
                        <span class="drop-zone__prompt"><img class="me-2" src="{{ asset('assets/img/icons/cloud-upload.svg') }}" width="25" alt="" />Klik atau Jatuhkan Gambar untuk Upload</span>
                        <input type="file" name="background_lecture" class="drop-zone__input">
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
