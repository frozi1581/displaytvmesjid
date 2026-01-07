@extends('layouts.dashboard')
@section('title', 'Profile')

@section('style')
<link href="{{ asset('assets/vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    #upload-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .bs-popover-end > .popover-arrow::after,
    .bs-popover-auto[x-placement^="right"] > .popover-arrow::after {
        border-right-color: #fce7eb !important;
    }

    .is-invalid {
        animation: shake 300ms;
    }

    @keyframes shake {
        25% {
            transform: translateX(4px)
        }

        50% {
            transform: translateX(-4px)
        }

        75% {
            transform: translateX(4px)
        }
    }
</style>
@endsection
@section('content')
<div class="container">

    @include('dashboards.configs.intervals.prayer')

    <hr>

    @include('dashboards.configs.intervals.iqama')

    <hr>

    @include('dashboards.configs.intervals.lecture')

    <hr>

    @include('dashboards.configs.calculation-method', [
        'calculationMethods' => $calculationMethods,
    ])

</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendors/choices/choices.min.js') }}"></script>
<script>
    $(document).ready(function() {

        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#upload-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload-input").on('change', function(){
            readURL(this);
        });

        $("#upload-btn").on('click', function(e) {
            e.preventDefault();

            $("#upload-error").remove();
            $("#upload-preview").removeClass("is-invalid border border-danger");
            $("#upload-input").click();
        });
    });
</script>
@endsection
