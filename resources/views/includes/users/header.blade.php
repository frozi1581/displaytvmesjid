<!-- Modern Professional Header - Aligned with Sidebar & Home Page -->
<style>
    /* Header Styling with Consistent Variables */
    .navbar-top {
        background: var(--bg-white);
        border-bottom: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 0.875rem 1.5rem;
        transition: all 0.3s ease;
        position: sticky;
        top: 0;
        z-index: 1030;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .navbar-top:hover {
        box-shadow: var(--shadow-md);
    }

    /* Navbar Brand in Header */
    .navbar-top .navbar-brand {
        padding: 0;
        margin: 0;
        border: none;
    }

    .navbar-top .navbar-brand span {
        font-size: 1.125rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 0.3px;
    }

    /* Toggle Button Styling */
    .navbar-toggler-humburger-icon {
        background: var(--bg-gray-50);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 0.5rem;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-toggler-humburger-icon:hover {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        border-color: var(--primary-color);
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .navbar-toggler-humburger-icon:hover .toggle-line {
        background-color: white;
    }

    .toggle-line {
        background-color: var(--text-primary);
        transition: all 0.3s ease;
    }

    /* Theme Toggle Styling */
    .theme-control-toggle {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .theme-control-toggle-input {
        display: none;
    }

    .theme-control-toggle-label {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--bg-gray-50);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .theme-control-toggle-label:hover {
        background: linear-gradient(135deg, var(--warning-color) 0%, #f59e0b 100%);
        border-color: var(--warning-color);
        color: white;
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .theme-control-toggle-label.theme-control-toggle-dark:hover {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-color: var(--primary-color);
    }

    .theme-control-toggle-label .fas {
        font-size: 1rem;
    }

    /* User Dropdown Styling */
    .navbar-nav-icons .nav-link {
        padding: 0;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .avatar:hover {
        border-color: var(--primary-color);
        transform: scale(1.05);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Dropdown Menu Styling */
    .dropdown-menu {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 0;
        margin-top: 0.5rem;
        min-width: 200px;
        animation: dropdownSlide 0.3s ease;
    }

    @keyframes dropdownSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-menu .bg-white {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        color: var(--text-primary);
        font-size: 0.9375rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: var(--radius-sm);
        margin: 0.25rem 0.5rem;
    }

    .dropdown-item:hover {
        background: var(--bg-gray-50);
        color: var(--primary-color);
        padding-left: 1.5rem;
    }

    .dropdown-item.fw-bold.text-warning {
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%);
        color: var(--warning-color) !important;
        border: 1px solid rgba(217, 119, 6, 0.2);
        margin-bottom: 0.5rem;
    }

    .dropdown-item.fw-bold.text-warning:hover {
        background: linear-gradient(135deg, var(--warning-color) 0%, #f59e0b 100%);
        color: white !important;
        transform: translateX(2px);
    }

    .dropdown-item[type="submit"] {
        border: none;
        width: 100%;
        text-align: left;
        background: transparent;
        color: var(--error-color);
        font-weight: 600;
    }

    .dropdown-item[type="submit"]:hover {
        background: rgba(220, 38, 38, 0.1);
        color: var(--error-color);
    }

    .dropdown-divider {
        margin: 0.5rem 0;
        border-top: 1px solid var(--border-color);
    }

    /* Navbar Icons Spacing */
    .navbar-nav-icons {
        gap: 0.75rem;
    }

    .navbar-nav-icons .nav-item {
        display: flex;
        align-items: center;
    }

    /* Icons in Dropdown */
    .dropdown-item .fas {
        width: 20px;
        margin-right: 0.5rem;
        color: currentColor;
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .navbar-top {
            padding: 0.75rem 1rem;
        }

        .navbar-top .navbar-brand span {
            font-size: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .navbar-top .navbar-brand {
            display: none;
        }

        .navbar-nav-icons {
            gap: 0.5rem;
        }

        .avatar {
            width: 36px;
            height: 36px;
        }

        .theme-control-toggle-label,
        .navbar-toggler-humburger-icon {
            width: 36px;
            height: 36px;
        }
    }

    /* Better Mobile Toggle */
    @media (max-width: 767.98px) {
        .navbar-toggler-humburger-icon {
            margin-right: 0.5rem !important;
        }
    }

    /* Smooth Transitions */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Focus States for Accessibility */
    .navbar-toggler-humburger-icon:focus,
    .theme-control-toggle-label:focus,
    .nav-link:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Dark Mode Support */
    [data-bs-theme="dark"] .navbar-top {
        background: rgba(26, 29, 41, 0.95);
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .navbar-toggler-humburger-icon {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .toggle-line {
        background-color: rgba(255, 255, 255, 0.9);
    }

    [data-bs-theme="dark"] .theme-control-toggle-label {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
    }

    [data-bs-theme="dark"] .avatar {
        border-color: rgba(255, 255, 255, 0.2);
    }

    [data-bs-theme="dark"] .dropdown-menu {
        background: #1a1d29;
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .dropdown-menu .bg-white {
        background: #1a1d29 !important;
    }

    [data-bs-theme="dark"] .dropdown-item {
        color: rgba(255, 255, 255, 0.9);
    }

    [data-bs-theme="dark"] .dropdown-divider {
        border-top-color: rgba(255, 255, 255, 0.1);
    }
</style>

<!-- Modern Header Navigation -->
<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg"
     data-move-target="#navbarVerticalNav"
     data-navbar-top="combo">

    <!-- Mobile Toggle Button -->
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarVerticalCollapse"
            aria-controls="navbarVerticalCollapse"
            aria-expanded="false"
            aria-label="Toggle Navigation">
        <span class="navbar-toggle-icon">
            <span class="toggle-line"></span>
        </span>
    </button>

    <!-- Brand Logo/Title -->
    <a class="navbar-brand me-1 me-sm-3" href="/">
        <div class="d-flex align-items-center">
            <span class="font-sans-serif">Aplikasi Display TV Mesjid</span>
        </div>
    </a>

    <!-- Right Side Icons -->
    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

        <!-- Theme Toggle (Light/Dark Mode) -->
        <li class="nav-item">
            <div class="theme-control-toggle fa-icon-wait px-2">
                <input class="form-check-input ms-0 theme-control-toggle-input"
                       id="themeControlToggle"
                       type="checkbox"
                       data-theme-control="theme"
                       value="dark" />
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                       for="themeControlToggle"
                       data-bs-toggle="tooltip"
                       data-bs-placement="left"
                       title="Switch to light theme">
                    <span class="fas fa-sun fs-0"></span>
                </label>
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                       for="themeControlToggle"
                       data-bs-toggle="tooltip"
                       data-bs-placement="left"
                       title="Switch to dark theme">
                    <span class="fas fa-moon fs-0"></span>
                </label>
            </div>
        </li>

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link pe-0 ps-2"
               id="navbarDropdownUser"
               role="button"
               data-bs-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle"
                         src="{{ Auth::user()->mosque->logo ?? asset('assets/img/logos/hp.png') }}"
                         alt="User Avatar" />
                </div>
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <!-- User Profile Link -->
                    <a class="dropdown-item fw-bold text-warning"
                       href="{{ Route::has('profile.index') ? route('profile.index') : '#' }}">
                        <span class="fas fa-user me-1"></span>
                        <span>{{ Auth::user()->name ?? 'Jono' }}</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <span class="fas fa-sign-out-alt me-1"></span>
                            {{ __('generic.button.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </li>

    </ul>
</nav>
