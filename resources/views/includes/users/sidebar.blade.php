<!-- ---- navbar-vertical starts------------ -->
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl py-3">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation">
                <span class="navbar-toggle-icon">
                    <span class="toggle-line"></span>
                </span>
            </button>
        </div>
        <a class="navbar-brand" href="/">
            <div class="d-flex align-items-center py-5">
                <span class="font-sans-serif">Aplikasi Display TV Mesjid</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3 p-2" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-chart-pie"></span>
                            </span>
                            <span class="nav-link-text ps-1">{{ __('dashboard.title') }}</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ Route::has('home') ? route('home') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('home.title') }}</span>
                                </div>
                            </a>
                        </li>
                        <!--li class="nav-item">
                            <a class="nav-link {{ Route::is('template*') ? 'active' : '' }}" href="{{ Route::has('template.index') ? route('template.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('template.title') }}</span>
                                </div>
                            </a>
                        </li-->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('file*') ? 'active' : '' }}" href="{{ Route::has('file.index') ? route('file.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('file.title') }}</span>
                                </div>
                            </a>
                        </li>

                        <!--li class="nav-item">
                            <a class="nav-link {{ Route::is('transaction*') ? 'active' : '' }}" href="{{ Route::has('transaction.index') ? route('transaction.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('transaction.title') }}</span>
                                </div>
                            </a>
                        </li-->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('marquee*') ? 'active' : '' }}" href="{{ Route::has('marquee.index') ? route('marquee.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('marquee.title') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('kas*') ? 'active' : '' }}" href="{{ Route::has('kas.index') ? route('kas.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('kas.title') }}</span>
                                </div>
                            </a>
                        </li>
                        <!--li class="nav-item">
                            <a class="nav-link {{ Route::is('lecture*') ? 'active' : '' }}" href="{{ Route::has('lecture.index') ? route('lecture.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('lecture.title') }}</span>
                                </div>
                            </a>
                        </li-->
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#setting" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="setting">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-cog"></span>
                            </span>
                            <span class="nav-link-text ps-1">{{ __('setting.title') }}</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="setting">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route::has('config.index') ? route('config.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('config.title') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Route::has('profile.index') ? route('profile.index') : '#' }}" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('profile.title') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ----- navbar-vertical end -------------- -->
