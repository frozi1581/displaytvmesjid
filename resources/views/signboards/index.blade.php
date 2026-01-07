@extends('layouts.signboard')

@section('title', 'Index')

@section('content')
        <section class="time-iqmomah hiden">
            <div class="time-iqmomah_img">
                <img src="{{ asset('assets/vendors/signboard/images/bg-islamic.jpeg') }}" alt="">
            </div>
            <div class="time-iqmomah_content">
                <div>Menjelang Iqomah <span class="name-iqomah">Subuh</span></div>
                <div class="time-iqmomah_time">00:00</div>
            </div>
        </section>
        <section class="time-silent hiden">
            <div class="time-silent_img">
                <img src="{{ asset('assets/vendors/signboard/images/bg-sholat.jpg') }}" alt="">
            </div>
            <div class="time-silent_content">
                <div>Waktu Sholat</div>
                <div class="name-sholat"><span class="saat-sholat"> Subuh</span></div>
                <div class="time-silent_time">00:00</div>
            </div>
        </section>
        <section style="max-height: 100vh;" class="jasma-main">
            <div style="z-index: 100;" class="jasma-main_head">
                <div>
                    <div>{{ $date["day"] }}</div>
                    <div>{{ $date["georgian"] }}</div>
                    <div>{{ $date["hijri"] }}</div>
                </div>
                <div>
                    <div class="nama_masjid">{{ $mosque->name }}</div>
                    <div class="alamat_masjid" style="max-width: 1000px;">{{ $mosque->address }}</div>
                    <div> DKM : {{ $mosque->phone }}</div>
                </div>
                <div>
                    <div class="waktu-berjalan-main">00:00</div>
                </div>
            </div>
            <div class="jasma-main_slider">
                <div class="swiper jasma-main_swiper">
                    <div class="swiper-wrapper">
                        @foreach ($images as $image)
                            <div class="swiper-slide item">
                                <img src="{{ $image->url }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="table-kajian hiden card" style="max-width:">
                <div class="card-body table-kajian-iner">
                    <table class="table table-striped">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th style="width: 10px; text-align: center">#</th>
                                <th>Time</th>
                                <th>Topic</th>
                                <th>Speaker</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 0)
                            @foreach ($lectures as $lecture)
                                <tr>
                                    <td style="width: 10px; text-align: center">{{ ++$i }}</td>
                                    <td>{{ $lecture->time }}</td>
                                    <td>{{ $lecture->topic }}</td>
                                    <td>{{ $lecture->speaker }}</td>
                                    <td>{{ $lecture->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="jasma-main_jadwal">
                <div>
                    <div class="name-pray-0">Imsak</div>
                    <div class="time-pray-0">04:20</div>
                </div>
                <div>
                    <div class="name-pray-1">Subh</div>
                    <div class="time-pray-1">20:23</div>
                </div>
                <div>
                    <div class="name-pray-2">Dhuhur</div>
                    <div class="time-pray-2">18:20</div>
                </div>
                <div>
                    <div class="name-pray-3">Ashr</div>
                    <div class="time-pray-3">00:30</div>
                </div>
                <div>
                    <div class="name-pray-4">Maghrib</div>
                    <div class="time-pray-4">04:00</div>
                </div>
                <div>
                    <div class="name-pray-5">Isya</div>
                    <div class="time-pray-5">05:00</div>
                </div>
            </div>
            <marquee width="100%" direction="left" height="50px" style="background: black; color:white; padding: 5px; font-size:25px; line-height: 1.5; text-rendering: optimizeLegibility;">
                @foreach ($runningTexts as $runningText)
                    {{  $runningText->content  }} &nbsp;&nbsp;&nbsp;&nbsp;&starf;&nbsp;&nbsp;&nbsp;&nbsp;
                @endforeach
            </marquee>
        </section>
        <div class="screen-will-adzan hiden">
            <div>
                <div>Menjelang Adzan <span class="menjelang-adzan">Subuh</span></div>
                <div class="timer-countdown-adzan">00</div>
            </div>
        </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection
