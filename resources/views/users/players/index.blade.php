@extends('layouts.player')

@section('title', 'Player')

@section('content')
    <style>
        .timer-container {
            position: absolute;
            top: 50%; /* Atur sesuai kebutuhan */
            right: 10px; /* Atur sesuai kebutuhan */
            transform: translateY(-50%);
            text-align: center;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .time-left{
            color:black;
            margin-top:-80px;
            font-size:25px;
        }

        .video-fit {
            marquee-loop: infinite;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Menjaga proporsi video */
        }
    </style>
    <div id="main-player-fetch" class="player-container p-0 m-0">

        <section id="before-adzan" class="player-wrapper text-capitalize p-0 player-hide">
            <div class="player-wrapper__img">
                <img src="{{ $configPlayer->background_before_adzan }}" alt="">
            </div>
            <div class="player-wrapper__content">
                <div>Menjelang Adzan <span class="player-wrapper__name">Subuh</span></div>
                <div class="player-wrapper__timer" style="font-size:20vw">00</div>
            </div>
        </section>

        <section id="adzan-time" class="player-wrapper text-capitalize p-0 player-hide">
            <div class="player-wrapper__img">
                <img src="{{ $configPlayer->background_before_adzan }}" alt="">
            </div>
            <div class="player-wrapper__content">
                <div>Adzan <span class="player-wrapper__name">Subuh</span></div>
                <div class="player-wrapper__timer" style="font-size:20vw">00</div>
            </div>
            <audio id="beepAudio" src= "https://masjid.layanan-aplikasi.com/public/assets/sounds/beep-01a.mp3">
            </audio>
        </section>



        <section id="iqama-time" class="player-wrapper text-capitalize p-0 player-hide">
            <div class="player-wrapper__img">
                <img src="https://masjid.layanan-aplikasi.com/public{{ $configPlayer->background_iqama_time }} " alt="">
            </div>
            <div class="player-wrapper__content">
                <div>Menjelang Iqomah <span class="player-wrapper__name">Subuh</span></div>
                <div class="player-wrapper__timer" style="font-size:20vw">00:00</div>
            </div>
        </section>

        <section id="prayer-silent" class="player-wrapper text-capitalize p-0 player-hide">
            <div class="player-wrapper__img">
                <img src="{{ $configPlayer->background_prayer_silent }}" alt="">
            </div>
            <div class="player-wrapper__content">
                <div>Waktu Sholat <span class="player-wrapper__name">Subuh</span></div>
                <div class="player-wrapper__time time" style="font-size:20vw">00:00</div>
            </div>
        </section>

        <section id="main" class="player-wrapper p-0 player-show">
            <div class="player-header">
                <div class="player-header__date">
                    <div>{{ $date->day }}</div>
                    <div>{{ $date->georgian }}</div>
                    <div>{{ $date->hijri }}</div>
                </div>
                <div class="player-header__profile">
                    <div class="player-header__profile-logo">
                        <img src="{{ $mosque->logo }}" alt="">
                    </div>
                    <div class="player-header__profile-info">
                        <div class="player-header__profile-info__name">{{ $mosque->name }}</div>
                        <div class="player-header__profile-info__address">{{ $mosque->faddress }}</div>
                    </div>
                </div>
                <div style="vertical-align: top;display:inline-block;">
                    <div style="font-size: 5vw;vertical-align: top;display:inline-block; margin:0" class="player_header__time time">00:00</div>

                </div>
            </div>

            <div class="player-slider">
                <div class="swiper player-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide player-swiper__item">
                            <!--<img src="{{ asset($backgrounds->url)  }}" />-->
                            <?php
                            // Tanggal tujuan (misalnya awal Ramadhan)
                            $target_date_eid = "2025-03-30"; // Ubah sesuai kebutuhan
                            $target_date_sholat = "2025-03-30";
                            $target_time = "18:15"; // Waktu batas

                            // Ambil tanggal hari ini
                            $current_date = date("Y-m-d");
                            $current_time = date("H:i");

                            //$current_date = date("2025-02-28");
                            //$current_time = date("16:00");

                            $target_datetime = strtotime("$target_date_sholat $target_time");
                            $current_datetime = strtotime("$current_date $current_time");

                            $diff = (strtotime($target_date_eid) - strtotime($current_date)) / (60 * 60 * 24);


                            if ($current_datetime >= $target_datetime) {
                                $diff = $diff - 1;
                            }

                            // Jika sudah melewati tanggal
                            if($diff<=0){
                                $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/video-eid-mubarak-annur.mp4";

                            }else{
                                $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/marhaban-ramadhan-1446H.mp4";
                            }

                            //$videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/marhaban-ramadhan-1446H.mp4";

                            //var_dump($diff);

                            $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/video-islamic02.mp4";

                            ?>
                            <video class="video-fit" loop autoplay muted>
                                <!-- <source src="https://masjid.layanan-aplikasi.com/public/assets/video/video-islamic02.mp4" type="video/mp4">-->
                                <!--<source src="https://masjid.layanan-aplikasi.com/public/assets/video/video-menyambut-ramadhan-2025-<?php echo $diff;?>haritogo.mp4" type="video/mp4">-->
                                <source src="<? echo $videoname;?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>

            <div id="prayer" class="player-prayer row m-0">
                @foreach ($prayers as $prayer)
                    <div class="player-prayer_box col py-3 text-light bg-grad-transparent" data-name="{{ $prayer->name }}" data-time="{{ $prayer->time }}" data-before-adzan-interval="{{ $prayer->before_adzan_interval }}" data-iqama-interval="{{ $prayer->iqama_interval }}" data-prayer-interval="{{ $prayer->prayer_interval }}"></div>
                @endforeach
            </div>
            <div class="player-marquee m-0 row" style="display:none;">
                <div class="col-1 powered">
                    <div class="system-logo">
                        <img src="{{ asset('assets/img/illustrations/falcon.png') }}" alt="">
                    </div>
                    <div class="system-name">Motions</div>
                </div>
                <div class="col-11">
                    <marquee width="120%" direction="left" height="100%" scrollamount="1" scrolldelay="10" truespeed style="text-rendering: optimizeLegibility; line-height: 1.15;">
                        @foreach ($marquees as $marquee)
                            {{  $marquee->content  }} &nbsp;&nbsp;&nbsp;&nbsp;&starf;&nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach
                    </marquee>
                </div>
            </div>

        </section>

        <section id="lecture" class="player-wrapper player-hide">
            <div class="table table-borderless lecture-table-iner">
                <table class="demo">
                    <caption>Table Kajian</caption>
                    <thead>
                    <tr>
                        <th>Hari Tanggal</th>
                        <th>Jam</th>
                        <th>Pemateri</th>
                        <th>Materi kajian</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="transaction" class="player-wrapper player-hide">
            <div class="table table-borderless lecture-table-iner">
                <table class="demo">
                    <caption>Table Kajian</caption>
                    <thead>
                    <tr>
                        <th>Hari Tanggal</th>
                        <th>Jam</th>
                        <th>Pemateri</th>
                        <th>Materi kajian</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="video" class="player-wrapper player-hide">
            <div class="table table-borderless lecture-table-iner">
                <table class="demo">
                    <caption>Table Kajian</caption>
                    <thead>
                    <tr>
                        <th>Hari Tanggal</th>
                        <th>Jam</th>
                        <th>Pemateri</th>
                        <th>Materi kajian</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="image" class="player-wrapper player-hide p-0">
            <div class="swiper image-swiper">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                        <div class="swiper-slide player-swiper__item">
                            <img src="{{ asset($image->url)  }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>

    <div id="full-screen-modal" class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg mt-6" role="document">
            <div class="modal-content border-0">
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1 text-dark" id="staticBackdropLabel">Aktivasi Layar Penuh</h4>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <p class="text-dark">Saat ini anda belum mengaktifkan mode layar penuh pada perangkat anda. Ketentuan kami mengharuskan bahwa anda menggunakan mode layar penuh untuk menjalankan fitur player kami. Silahkan klik tombol dibawah untuk mengaktifkan mode layar penuh</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="openFullscreen(document.body)" type="button">Aktifkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var configInit = {
            'show': {
                'transaction': 0,
                'lecture': 0,
                'video': 0,
                'image': {{ $configPlayerShow->show_image }},
                'main': {{ $configPlayerShow->show_main }},
            },
            'interval': {
                'friday': {{ $configPlayerInterval->interval_friday }},
                'lecture': 0,
                'transaction': 0,
                'video': 0,
                'image': {{ $configPlayerInterval->interval_image * (count($images))}},
                'main': {{ $configPlayerInterval->interval_slider * 1 }},
                'slider': {{ $configPlayerInterval->interval_slider }},
            },
        };


        var s2 = new Swiper(".image-swiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "1",
            initialSlide : 1,
            loop: false,
            autoplay: {
                delay: minToMilisec({{ $configPlayerInterval->interval_image }}),
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 2,
                slideShadows: false,
            },
        });


        $(document).ready(function () {
            setInterval(function () {
                let now = new Date();
                now.setMilliseconds(0);
                let millisTill10 = Math.abs(new Date(now.getFullYear(), now.getMonth(), now.getDate(), 3, 0, 0, 0).getTime() - now);

                if (millisTill10 < 1000) {
                    $.get( "{{ route('player', $token) }}", function( data ) {
                        let html = $.parseHTML(data);
                        $('#main-player-fetch').parent().html($(html).find('#main-player-fetch'));
                    }).done(function () {
                        configInit = {
                            'show': {
                                'transaction': 0,
                                'lecture': 0,
                                'video': 0,
                                'image': {{ $configPlayerShow->show_image }},
                                'main': {{ $configPlayerShow->show_main }},
                            },
                            'interval': {
                                'friday': {{ $configPlayerInterval->interval_friday }},
                                'lecture': 0,
                                'transaction': 0,
                                'video': 0,
                                'image': {{ $configPlayerInterval->interval_image * (count($images))}},
                                'main': {{ $configPlayerInterval->interval_slider * 1 }},
                                'slider': {{ $configPlayerInterval->interval_slider }},
                            },
                        };


                        s2 = new Swiper(".image-swiper", {
                            effect: "coverflow",
                            grabCursor: true,
                            centeredSlides: true,
                            slidesPerView: "1",
                            initialSlide : 1,
                            loop: false,
                            autoplay: {
                                delay: minToMilisec({{ $configPlayerInterval->interval_image }}),
                                disableOnInteraction: false,
                            },
                            coverflowEffect: {
                                rotate: 0,
                                stretch: 0,
                                depth: 150,
                                modifier: 2,
                                slideShadows: false,
                            },
                        });

                        playerInit('#prayer', configInit);
                    });
                }
            }, 1000);

            //if (!document.fullscreen)
            //    $('#full-screen-modal').modal('show');

            playerInit('#prayer', configInit);

        });
    </script>
@endsection
