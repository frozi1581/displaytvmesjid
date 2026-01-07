@extends('layouts.player')

@section('title', 'Player')

@section('content')
    <style>
        .timer-container {
            position: absolute;
            top: 50%;
            right: 10px;
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
            object-fit: cover;
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
                            <?php
                            // Video selection logic
                            $target_date_eid = "2025-03-30";
                            $target_date_sholat = "2025-03-30";
                            $target_time = "18:15";

                            $current_date = date("Y-m-d");
                            $current_time = date("H:i");

                            $target_datetime = strtotime("$target_date_sholat $target_time");
                            $current_datetime = strtotime("$current_date $current_time");

                            $diff = (strtotime($target_date_eid) - strtotime($current_date)) / (60 * 60 * 24);

                            if ($current_datetime >= $target_datetime) {
                                $diff = $diff - 1;
                            }

                            if($diff<=0){
                                $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/video-eid-mubarak-annur.mp4";
                            }else{
                                $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/marhaban-ramadhan-1446H.mp4";
                            }

                            $videoname = "https://masjid.layanan-aplikasi.com/public/assets/video/video-islamic02.mp4";
                            ?>
                            <video class="video-fit" loop autoplay muted>
                                <source src="<?php echo $videoname; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>

            <div id="prayer" class="player-prayer row m-0">
                @foreach ($prayers as $prayer)
                    <div class="player-prayer_box col py-3 text-light bg-grad-transparent"
                         data-name="{{ $prayer->name }}"
                         data-time="{{ $prayer->time }}"
                         data-before-adzan-interval="{{ $prayer->before_adzan_interval }}"
                         data-iqama-interval="{{ $prayer->iqama_interval }}"
                         data-prayer-interval="{{ $prayer->prayer_interval }}"></div>
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
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="transaction" class="player-wrapper player-hide">
            <div class="table table-borderless lecture-table-iner">
                <table class="demo">
                    <caption>Table Transaksi</caption>
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="video" class="player-wrapper player-hide">
            <div class="table table-borderless lecture-table-iner">
                <table class="demo">
                    <caption>Video Section</caption>
                    <thead>
                    <tr>
                        <th>Content</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
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
    <script src="{{ asset('path/to/playerdev.js') }}"></script>
    <script>
        // Monthly Prayer Data Integration Script
        (function() {
            'use strict';

            // Global application state manager
            window.MasjidPlayer = window.MasjidPlayer || {
                timers: {
                    dataCheck: null,
                    main: null
                },
                instances: {
                    swiper: null,
                    player: null
                },
                state: {
                    isInitialized: false,
                    isUpdating: false,
                    lastDataCheck: null
                },
                config: null,
                prayerData: {
                    monthly: @json($prayerTimes),
                    status: @json($dataStatus),
                    prayers: @json($prayers->toArray())
                }
            };

            // Configuration from Laravel blade
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

            // Store config globally
            window.MasjidPlayer.config = configInit;

            // Utility functions
            function log(message, type = 'info') {
                const timestamp = new Date().toISOString();
                console[type](`[MasjidPlayer ${timestamp}] ${message}`);
            }

            function minToMilisec(interval) {
                return Math.max(0, interval * 1000 * 60);
            }

            // Get today's date key
            function getTodayKey() {
                const today = new Date();
                return today.getFullYear() + '-' +
                    String(today.getMonth() + 1).padStart(2, '0') + '-' +
                    String(today.getDate()).padStart(2, '0');
            }

            // Update prayer times display
            function updatePrayerTimesDisplay() {
                try {
                    const todayKey = getTodayKey();
                    const todayTimes = window.MasjidPlayer.prayerData.monthly[todayKey];

                    if (!todayTimes) {
                        log('No prayer times found for today: ' + todayKey, 'warn');
                        return;
                    }

                    // Update each prayer box
                    window.MasjidPlayer.prayerData.prayers.forEach(prayer => {
                        const prayerElement = $(`[data-name="${prayer.name}"]`);
                        if (prayerElement.length > 0 && todayTimes[prayer.name]) {
                            // Calculate adjusted time
                            const baseTime = todayTimes[prayer.name];
                            const adjustedTime = new Date(`2000-01-01 ${baseTime}`);
                            adjustedTime.setMinutes(adjustedTime.getMinutes() + (prayer.time_adjustment || 0));

                            const timeStr = adjustedTime.toTimeString().substring(0, 5);
                            prayerElement.attr('data-time', timeStr);

                            // Update display
                            $(`#dvboxtime-${prayer.name}`).text(timeStr);
                        }
                    });

                    log('Prayer times display updated for ' + todayKey);

                } catch (error) {
                    log('Error updating prayer times display: ' + error.message, 'error');
                }
            }

            // Check for data updates from server
            function checkDataUpdates() {
                if (window.MasjidPlayer.state.isUpdating) {
                    log('Data update already in progress, skipping...');
                    return;
                }

                $.get("{{ url('api/player/' . $token . '/check-status') }}")
                    .done(function(response) {
                        if (response.status === 'success') {
                            const serverStatus = response.data;
                            const currentStatus = window.MasjidPlayer.prayerData.status;

                            // Check if data needs update
                            const needsUpdate =
                                serverStatus.last_updated > currentStatus.last_updated ||
                                serverStatus.cache_version > currentStatus.cache_version ||
                                serverStatus.current_month !== currentStatus.current_month;

                            if (needsUpdate) {
                                log('Data update needed, fetching new prayer times...');
                                fetchUpdatedPrayerData();
                            } else {
                                log('Prayer data is up to date');
                            }

                            window.MasjidPlayer.state.lastDataCheck = Date.now();
                        }
                    })
                    .fail(function(xhr, status, error) {
                        log('Failed to check data status: ' + error, 'error');
                    });
            }

            // Fetch updated prayer data
            function fetchUpdatedPrayerData() {
                window.MasjidPlayer.state.isUpdating = true;

                $.get("{{ url('api/player/' . $token . '/prayer-times') }}")
                    .done(function(response) {
                        if (response.status === 'success') {
                            // Update stored data
                            window.MasjidPlayer.prayerData.monthly = response.data.prayer_times;
                            window.MasjidPlayer.prayerData.status.last_updated = response.data.last_updated;
                            window.MasjidPlayer.prayerData.status.cache_version = response.data.cache_version;

                            // Update display
                            updatePrayerTimesDisplay();

                            // Reinitialize player with new data
                            if (typeof window.playerInit === 'function') {
                                window.playerInit('#prayer', window.MasjidPlayer.config);
                            }

                            log('Prayer data updated successfully');
                        }
                    })
                    .fail(function(xhr, status, error) {
                        log('Failed to fetch updated prayer data: ' + error, 'error');
                    })
                    .always(function() {
                        window.MasjidPlayer.state.isUpdating = false;
                    });
            }

            // Setup periodic data checking
            function setupDataChecking() {
                // Clear existing timer
                if (window.MasjidPlayer.timers.dataCheck) {
                    clearInterval(window.MasjidPlayer.timers.dataCheck);
                }

                // Check every minute
                window.MasjidPlayer.timers.dataCheck = setInterval(function() {
                    try {
                        checkDataUpdates();
                    } catch (error) {
                        log('Error in data check timer: ' + error.message, 'error');
                    }
                }, 60000); // 1 minute

                log('Data checking timer setup completed');
            }

            // Cleanup function
            function cleanup() {
                log('Starting cleanup process...');

                try {
                    // Clear data check timer
                    if (window.MasjidPlayer.timers.dataCheck) {
                        clearInterval(window.MasjidPlayer.timers.dataCheck);
                        window.MasjidPlayer.timers.dataCheck = null;
                        log('Data check timer cleared');
                    }

                    // Cleanup TimerManager from playerdev.js
                    if (window.TimerManager && typeof window.TimerManager.clearAll === 'function') {
                        window.TimerManager.clearAll();
                        log('Player timers cleared via TimerManager');
                    }

                    // Cleanup DOMCache from playerdev.js
                    if (window.DOMCache && typeof window.DOMCache.clear === 'function') {
                        window.DOMCache.clear();
                        log('DOM cache cleared');
                    }

                    // Destroy Swiper instance
                    if (window.MasjidPlayer.instances.swiper) {
                        try {
                            if (typeof window.MasjidPlayer.instances.swiper.destroy === 'function') {
                                window.MasjidPlayer.instances.swiper.destroy(true, true);
                                log('Swiper instance destroyed');
                            }
                        } catch (e) {
                            log('Error destroying swiper: ' + e.message, 'warn');
                        }
                        window.MasjidPlayer.instances.swiper = null;
                    }

                    // Reset state
                    window.MasjidPlayer.state.isInitialized = false;
                    window.MasjidPlayer.state.isUpdating = false;

                    log('Cleanup completed successfully');

                } catch (error) {
                    log('Error during cleanup: ' + error.message, 'error');
                }
            }

            // Initialize Swiper
            function initializeSwiper() {
                try {
                    if (window.MasjidPlayer.instances.swiper) {
                        window.MasjidPlayer.instances.swiper.destroy(true, true);
                    }

                    window.MasjidPlayer.instances.swiper = new Swiper(".image-swiper", {
                        effect: "coverflow",
                        grabCursor: true,
                        centeredSlides: true,
                        slidesPerView: "1",
                        initialSlide: 1,
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
                        on: {
                            init: function() {
                                log('Swiper initialized successfully');
                            },
                            destroy: function() {
                                log('Swiper destroyed');
                            }
                        }
                    });

                    return true;
                } catch (error) {
                    log('Error initializing swiper: ' + error.message, 'error');
                    return false;
                }
            }

            // Initialize player
            function initializePlayer() {
                try {
                    if (typeof window.playerInit !== 'function') {
                        log('playerInit function not found', 'error');
                        return false;
                    }

                    // Update prayer times before initializing
                    updatePrayerTimesDisplay();

                    // Initialize player
                    window.playerInit('#prayer', window.MasjidPlayer.config);
                    window.MasjidPlayer.instances.player = true;

                    log('Player initialized successfully');
                    return true;

                } catch (error) {
                    log('Error initializing player: ' + error.message, 'error');
                    return false;
                }
            }

            // Main initialization
            function initialize() {
                if (window.MasjidPlayer.state.isInitialized) {
                    log('Already initialized, skipping...');
                    return;
                }

                log('Starting initialization...');

                try {
                    const swiperSuccess = initializeSwiper();
                    const playerSuccess = initializePlayer();

                    if (swiperSuccess && playerSuccess) {
                        window.MasjidPlayer.state.isInitialized = true;
                        log('All components initialized successfully');
                    } else {
                        log('Some components failed to initialize', 'warn');
                    }

                } catch (error) {
                    log('Error during initialization: ' + error.message, 'error');
                }
            }

            // Event handlers
            function handleVisibilityChange() {
                if (document.hidden) {
                    log('Page hidden, pausing data checking');
                    if (window.MasjidPlayer.timers.dataCheck) {
                        clearInterval(window.MasjidPlayer.timers.dataCheck);
                        window.MasjidPlayer.timers.dataCheck = null;
                    }
                } else {
                    log('Page visible, resuming data checking');
                    setupDataChecking();
                }
            }

            function handleBeforeUnload() {
                log('Page unloading, cleaning up...');
                cleanup();
            }

            function handleGlobalError(event) {
                log('Global error caught: ' + event.error.message, 'error');
            }

            // Main function
            function main() {
                log('Starting main initialization...');

                try {
                    // Set up event listeners
                    document.addEventListener('visibilitychange', handleVisibilityChange);
                    window.addEventListener('beforeunload', handleBeforeUnload);
                    window.addEventListener('error', handleGlobalError);

                    // Initialize components
                    initialize();

                    // Setup data checking
                    setupDataChecking();

                    log('Main initialization completed');

                } catch (error) {
                    log('Error in main initialization: ' + error.message, 'error');
                }
            }

            // Start when DOM is ready
            $(document).ready(function() {
                log('DOM ready, starting application...');
                setTimeout(main, 100);
            });

            // Expose cleanup function globally for debugging
            window.MasjidPlayerCleanup = cleanup;
            window.MasjidPlayerUpdatePrayerTimes = updatePrayerTimesDisplay;

        })();
    </script>
@endsection
