@extends('layouts.user')

@section('title', 'Index')
@section('pageTitle', 'Index')
@section('endpoint', '/user/marquee')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="/user/marquee">Teks Berjalan</a></li>
<li class="breadcrumb-item active"><a href="/user/marquee">Index</a></li>
@endsection

@section('content')
<div class="col-md-12 px-5">
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{ asset('/assets/img/icons/spot-illustrations/corner-4.png') }});">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Teks Berjalan</h3>
                    <p class="mb-0">Atur teks berjalan disini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <div>
                <p class="m-1">
                    <a href="/user/marquee/create" class="float-right btn btn-success">Tambah</a>
                </p>
            </div>
        </div>
        <div class="card-body">
            <div id="marquee__table">
                <div class="table-responsive scrollbar">
                    <table class="table table-striped">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th style="width: 10px; text-align: center">#</th>
                                <th>Konten</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 0)
                            @foreach ($data as $value)
                                <tr>
                                    <td style="width: 10px; text-align: center">{{ ++$i }}</td>
                                    <td>{{ $value->content }}</td>
                                    <td class="text-end">
                                        <div>
                                            <a class="btn p-0 ms-2" href="/user/marquee/edit/{{ $value->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span></a>
                                            <a class="btn p-0 ms-2 _delete" href="/user/marquee/{{ $value->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><span class="text-500 fas fa-trash-alt"></span></a>
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
