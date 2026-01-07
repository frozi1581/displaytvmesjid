<!-- Modern Professional Sidebar - Aligned with Home Page -->
<style>
    /* Import CSS Variables from Home Page */
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #3b82f6;
        --success-color: #059669;
        --error-color: #dc2626;
        --warning-color: #d97706;
        --info-color: #0891b2;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-light: #9ca3af;
        --border-color: #e5e7eb;
        --border-focus: #3b82f6;
        --bg-light: #f9fafb;
        --bg-white: #ffffff;
        --bg-gray-50: #f8fafc;
        --bg-gray-100: #f1f5f9;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
    }

    /* Modern Sidebar Styling */
    .navbar-vertical {
        background: var(--bg-white);
        box-shadow: var(--shadow-md);
        border-right: 1px solid var(--border-color);
        width: 280px;
        transition: all 0.3s ease;
    }

    /* Navbar Brand */
    .navbar-brand {
        padding: 1.5rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    }

    .navbar-brand span {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
        letter-spacing: 0.3px;
        line-height: 1.5;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Navbar Toggle Button */
    .navbar-toggler-humburger-icon {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--radius-md);
        padding: 0.5rem;
        transition: all 0.3s ease;
    }

    .navbar-toggler-humburger-icon:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
        transform: scale(1.05);
    }

    .toggle-line {
        background-color: white;
    }

    /* Scrollbar Styling */
    .navbar-vertical-content::-webkit-scrollbar {
        width: 6px;
    }

    .navbar-vertical-content::-webkit-scrollbar-track {
        background: var(--bg-gray-50);
    }

    .navbar-vertical-content::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }

    .navbar-vertical-content::-webkit-scrollbar-thumb:hover {
        background: var(--text-light);
    }

    /* Main Menu Items */
    .navbar-nav {
        padding: 0.75rem !important;
    }

    .nav-item {
        margin-bottom: 0.375rem;
    }

    /* Dropdown Indicator (Parent Menu) */
    .nav-link.dropdown-indicator {
        color: var(--text-primary);
        padding: 0.875rem 1rem;
        border-radius: var(--radius-lg);
        font-size: 0.9375rem;
        font-weight: 600;
        letter-spacing: 0.2px;
        transition: all 0.3s ease;
        background: var(--bg-gray-50);
        border: 1px solid var(--border-color);
        margin-bottom: 0.5rem;
    }

    .nav-link.dropdown-indicator:hover {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: white;
        border-color: var(--primary-color);
        transform: translateX(3px);
        box-shadow: var(--shadow-md);
    }

    .nav-link.dropdown-indicator:hover .nav-link-icon {
        background: white;
        color: var(--primary-color);
    }

    .nav-link.dropdown-indicator:hover .nav-link-icon span {
        color: var(--primary-color);
    }

    .nav-link.dropdown-indicator .nav-link-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        border-radius: var(--radius-md);
        margin-right: 0.75rem;
        transition: all 0.3s ease;
    }

    .nav-link.dropdown-indicator .nav-link-icon span {
        font-size: 1rem;
        color: white;
    }

    /* Sub Menu Items */
    .nav.collapse {
        padding-left: 0.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .nav.collapse .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav.collapse .nav-link {
        color: var(--text-secondary);
        padding: 0.75rem 1rem 0.75rem 3.5rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }

    /* Hover Effect for Sub Menu */
    .nav.collapse .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-light) 100%);
        border-radius: 0 3px 3px 0;
        transition: all 0.3s ease;
    }

    .nav.collapse .nav-link:hover {
        background: var(--bg-gray-50);
        color: var(--primary-color);
        border-color: var(--border-color);
        padding-left: 3.75rem;
        font-weight: 600;
    }

    .nav.collapse .nav-link:hover::before {
        height: 60%;
    }

    /* Active State */
    .nav.collapse .nav-link.active {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
        color: var(--primary-color);
        font-weight: 600;
        border: 1px solid rgba(37, 99, 235, 0.3);
        padding-left: 3.5rem;
        box-shadow: var(--shadow-sm);
    }

    .nav.collapse .nav-link.active::before {
        height: 100%;
        width: 3px;
        background: var(--primary-color);
    }

    .nav.collapse .nav-link.active::after {
        content: '';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: var(--primary-color);
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(37, 99, 235, 0.6);
    }

    /* Responsive Design */
    @media (max-width: 1199.98px) {
        .navbar-vertical {
            width: 260px;
        }

        .navbar-brand span {
            font-size: 1rem;
        }

        .nav-link.dropdown-indicator {
            padding: 0.75rem 0.875rem;
            font-size: 0.875rem;
        }

        .nav-link.dropdown-indicator .nav-link-icon {
            width: 36px;
            height: 36px;
        }

        .nav.collapse .nav-link {
            padding: 0.65rem 0.875rem 0.65rem 3rem;
            font-size: 0.8125rem;
        }
    }

    @media (max-width: 767.98px) {
        .navbar-vertical {
            width: 100%;
        }
    }

    /* Animation for Collapse */
    .collapse {
        transition: all 0.3s ease;
    }

    .collapsing {
        transition: height 0.3s ease;
    }

    /* Better Typography */
    .nav-link-text {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        letter-spacing: 0.2px;
    }

    /* Better spacing for nested items */
    #dashboard, #setting {
        margin-top: 0.25rem;
        margin-bottom: 0.5rem;
    }

    /* Smooth transitions */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Icon colors for different menu items */
    .fa-chart-pie,
    .fa-cog {
        color: white;
    }

    /* Enhanced focus states for accessibility */
    .nav-link:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Additional polish */
    .navbar-vertical-content {
        padding-bottom: 2rem;
    }
</style>

<!-- Navbar Vertical Starts -->
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl py-3">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>

    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="Toggle Navigation">
                <span class="navbar-toggle-icon">
                    <span class="toggle-line"></span>
                </span>
            </button>
        </div>
        <a class="navbar-brand" href="/">
            <div class="d-flex align-items-center">
                <span class="font-sans-serif">Aplikasi Display<br>TV Mesjid</span>
            </div>
        </a>
    </div>

    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3 p-2" id="navbarVerticalNav">

                <!-- Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator"
                       href="#dashboard"
                       role="button"
                       data-bs-toggle="collapse"
                       aria-expanded="true"
                       aria-controls="dashboard">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-chart-pie"></span>
                            </span>
                            <span class="nav-link-text ps-1">{{ __('dashboard.title') }}</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="dashboard">
                        <!-- Home -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}"
                               href="{{ Route::has('home') ? route('home') : '#' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('home.title') }}</span>
                                </div>
                            </a>
                        </li>

                        <!-- File -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('file*') ? 'active' : '' }}"
                               href="{{ Route::has('file.index') ? route('file.index') : '#' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('file.title') }}</span>
                                </div>
                            </a>
                        </li>

                        <!-- Teks Berjalan (Marquee) -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('marquee*') ? 'active' : '' }}"
                               href="{{ Route::has('marquee.index') ? route('marquee.index') : '#' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('marquee.title') }}</span>
                                </div>
                            </a>
                        </li>

                        <!-- Kas -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('kas*') ? 'active' : '' }}"
                               href="{{ Route::has('kas.index') ? route('kas.index') : '#' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('kas.title') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings Menu -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator"
                       href="#setting"
                       role="button"
                       data-bs-toggle="collapse"
                       aria-expanded="true"
                       aria-controls="setting">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-cog"></span>
                            </span>
                            <span class="nav-link-text ps-1">{{ __('setting.title') }}</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="setting">
                        <!-- Pengaturan -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('config*') ? 'active' : '' }}"
                               href="{{ Route::has('config.index') ? route('config.index') : '#' }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ __('config.title') }}</span>
                                </div>
                            </a>
                        </li>

                        <!-- Profil -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('profile*') ? 'active' : '' }}"
                               href="{{ Route::has('profile.index') ? route('profile.index') : '#' }}">
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
<!-- Navbar Vertical Ends -->
