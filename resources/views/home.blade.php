@extends('layouts.user')

@section('title', 'Dashboard')

@section('style')
    <style>
        /* Modern CSS Variables - Consistent with Login */
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

        /* Dashboard Container */
        .dashboard-container {
            padding: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-2xl);
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0 0 1rem;
        }

        .welcome-time {
            font-size: 0.95rem;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .stat-icon.primary { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); }
        .stat-icon.success { background: linear-gradient(135deg, var(--success-color), #10b981); }
        .stat-icon.warning { background: linear-gradient(135deg, var(--warning-color), #f59e0b); }
        .stat-icon.info { background: linear-gradient(135deg, var(--info-color), #06b6d4); }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin: 0.25rem 0 0;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .stat-change.positive { color: var(--success-color); }
        .stat-change.negative { color: var(--error-color); }

        /* Quick Actions */
        .quick-actions {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg-gray-50);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-lg);
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .action-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            text-decoration: none;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .action-btn:hover .action-icon {
            background: white;
            color: var(--primary-color);
        }

        /* Recent Activity */
        .recent-activity {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: var(--text-primary);
            margin: 0 0 0.25rem;
        }

        .activity-time {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Status Indicator */
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .status-indicator.online {
            background: var(--success-color);
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
            animation: pulse 2s infinite;
        }

        .status-indicator.offline {
            background: var(--error-color);
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.4);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(5, 150, 105, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(5, 150, 105, 0);
            }
        }
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .welcome-section {
                padding: 1.5rem;
                text-align: center;
            }

            .welcome-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions,
            .recent-activity {
                padding: 1.25rem;
            }

            .section-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 0.75rem;
            }

            .welcome-section {
                padding: 1.25rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.75rem;
            }

            .action-btn {
                padding: 0.875rem;
                gap: 0.5rem;
            }

            .action-icon {
                width: 36px;
                height: 36px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-container > * {
            animation: fadeInUp 0.6s ease-out;
        }

        .dashboard-container > *:nth-child(2) { animation-delay: 0.1s; }
        .dashboard-container > *:nth-child(3) { animation-delay: 0.2s; }
        .dashboard-container > *:nth-child(4) { animation-delay: 0.3s; }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus styles for accessibility */
        .action-btn:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-content">
                <h1 class="welcome-title">
                    <i class="fas fa-hand-peace"></i>
                    {{ __('Selamat Datang, ' . auth()->user()->name) }}
                </h1>
                <p class="welcome-subtitle">
                    {{ __('Kelola konten display TV masjid dengan mudah') }}
                </p>
                <div class="welcome-time">
                    <i class="fas fa-clock"></i>
                    <span id="currentTime"></span>
                </div>
            </div>
        </div>

        <!-- Display Status Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <h3 class="stat-value">
                            <span class="status-indicator online"></span>
                            Online
                        </h3>
                        <p class="stat-label">{{ __('Status Display TV') }}</p>
                        <div class="stat-change positive">
                            <i class="fas fa-signal"></i>
                            <span>Stabil</span>
                        </div>
                    </div>
                    <div class="stat-icon success">
                        <i class="fas fa-tv"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <h3 class="stat-value">3</h3>
                        <p class="stat-label">{{ __('Running Text Aktif') }}</p>
                        <div class="stat-change positive">
                            <i class="fas fa-play"></i>
                            <span>Berjalan</span>
                        </div>
                    </div>
                    <div class="stat-icon primary">
                        <i class="fas fa-scroll"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <h3 class="stat-value">5</h3>
                        <p class="stat-label">{{ __('Pengumuman Aktif') }}</p>
                        <div class="stat-change positive">
                            <i class="fas fa-eye"></i>
                            <span>Tampil</span>
                        </div>
                    </div>
                    <div class="stat-icon warning">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <h3 class="stat-value">Maghrib</h3>
                        <p class="stat-label">{{ __('Sholat Berikutnya') }}</p>
                        <div class="stat-change">
                            <i class="fas fa-clock"></i>
                            <span>18:05</span>
                        </div>
                    </div>
                    <div class="stat-icon info">
                        <i class="fas fa-mosque"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Controls -->
        <div class="quick-actions">
            <h2 class="section-title">
                <i class="fas fa-sliders-h"></i>
                {{ __('Kontrol Display') }}
            </h2>
            <div class="actions-grid">
                <a href="{{ route('config.prayer.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span>{{ __('Jadwal Sholat') }}</span>
                </a>
                <a href="{{ route('marquee.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-scroll"></i>
                    </div>
                    <span>{{ __('Running Text') }}</span>
                </a>
                <a href="{{ route('transaction.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <span>{{ __('Pengumuman') }}</span>
                </a>
                <a href="{{ route('file.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <span>{{ __('Background/Video') }}</span>
                </a>
                <a href="{{ route('lecture.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-volume-up"></i>
                    </div>
                    <span>{{ __('Audio/Adzan') }}</span>
                </a>
                <a href="{{ route('template.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <span>{{ __('Tema Display') }}</span>
                </a>
                <a href="{{ route('config.player.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-tv"></i>
                    </div>
                    <span>{{ __('Preview Display') }}</span>
                </a>
                <a href="{{ route('config.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span>{{ __('Pengaturan TV') }}</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                {{ __('Log Aktivitas Display') }}
            </h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-scroll"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ __('Running text "Kajian Malam Jumat" ditambahkan') }}</p>
                        <p class="activity-time">{{ __('15 menit yang lalu') }}</p>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ __('Jadwal sholat diperbarui untuk bulan ini') }}</p>
                        <p class="activity-time">{{ __('1 jam yang lalu') }}</p>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ __('Background display diganti ke tema Ramadan') }}</p>
                        <p class="activity-time">{{ __('2 jam yang lalu') }}</p>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ __('Pengumuman "Sholat Idul Fitri" dipublikasikan') }}</p>
                        <p class="activity-time">{{ __('3 jam yang lalu') }}</p>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-tv"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title">{{ __('Display TV berhasil terhubung kembali') }}</p>
                        <p class="activity-time">{{ __('4 jam yang lalu') }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Real-time clock
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Jakarta'
            };

            const timeString = now.toLocaleDateString('id-ID', options);
            const timeElement = document.getElementById('currentTime');

            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update time immediately and then every second
        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);
        });

        // Add interactive hover effects to stat cards
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');

            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(-2px)';
                });
            });
        });

        // Smooth scroll for action buttons (if they link to sections on the same page)
        document.addEventListener('DOMContentLoaded', function() {
            const actionBtns = document.querySelectorAll('.action-btn');

            actionBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Add click animation
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });

        // Optional: Add greeting based on time of day
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeTitle = document.querySelector('.welcome-title');
            const hour = new Date().getHours();
            let greeting = '';

            if (hour < 4) greeting = 'Selamat Malam';
            else if (hour < 10) greeting = 'Selamat Pagi';
            else if (hour < 15) greeting = 'Selamat Siang';
            else if (hour < 19) greeting = 'Selamat Sore';
            else greeting = 'Selamat Malam';

            // You can uncomment this to replace the static greeting
            // welcomeTitle.innerHTML = `<i class="fas fa-hand-peace"></i>${greeting}, {{ auth()->user()->name }}`;
        });
    </script>
@endsection
