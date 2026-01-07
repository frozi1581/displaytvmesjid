<!-- ---- navbar-vertical starts------------ -->
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
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
            <div class="d-flex align-items-center py-3">
                <span class="font-sans-serif">Aplikasi Display TV Mesjid</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3 p-2" id="navbarVerticalNav">
                <!-- Dashboard Section -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-chart-pie"></span>
                            </span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Home') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Content Management Section -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#content" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="content">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-desktop"></span>
                            </span>
                            <span class="nav-link-text ps-1">Konten Display</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="content">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marquee.*') ? 'active' : '' }}" href="{{ route('marquee.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Running Text') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transaction.*') ? 'active' : '' }}" href="{{ route('transaction.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Pengumuman') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('lecture.*') ? 'active' : '' }}" href="{{ route('lecture.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Audio/Kajian') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('file.*') ? 'active' : '' }}" href="{{ route('file.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Media/Background') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Templates Section -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#templates" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="templates">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-palette"></span>
                            </span>
                            <span class="nav-link-text ps-1">Tema & Template</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="templates">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('template.*') ? 'active' : '' }}" href="{{ route('template.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Template Display') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Configuration Section -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#configuration" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="configuration">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-cog"></span>
                            </span>
                            <span class="nav-link-text ps-1">Konfigurasi</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="configuration">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('config.prayer.*') ? 'active' : '' }}" href="{{ route('config.prayer.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Jadwal Sholat') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('config.player.*') ? 'active' : '' }}" href="{{ route('config.player.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Player/Display') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('config.index') ? 'active' : '' }}" href="{{ route('config.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Pengaturan Umum') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Profile Section -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#profile" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="profile">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-user"></span>
                            </span>
                            <span class="nav-link-text ps-1">Akun</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="profile">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Profil Saya') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('Logout') }}</span>
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- ----- navbar-vertical end -------------- -->
