@extends('layouts.user')
@section('title', 'Profile')

@section('style')
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

    @include('users.profiles.information')

    <hr>

    @include('users.profiles.security')

    <hr>

    @include('users.profiles.additional')

    <hr>

    @include('users.profiles.password')

</div>
@endsection

@section('script')
<script>
    function copyPlayerLink() {
        var copyText = document.getElementById("player_token");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        alert("Link berhasil di salin: " + copyText.value);
    }
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
