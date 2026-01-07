@extends('layouts.user')

@section('title', __('file.title'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">{{ __('dashboard.title') }}</a></li>
    <li class="breadcrumb-item active"><a href="/file">{{ __('file.title') }}</a></li>
@endsection

@section('style')
    <style>
        /* Modern CSS Variables */
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

        /* Page Container */
        .media-container {
            padding: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-2xl);
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
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

        .header-content {
            position: relative;
            z-index: 2;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-description {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Navigation Tabs */
        .nav-tabs-modern {
            border: none;
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 0.5rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            display: flex;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .nav-tabs-modern::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs-modern .nav-item {
            flex: 1;
            min-width: 120px;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.875rem 1.5rem;
            text-align: center;
            border-radius: var(--radius-lg);
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
        }

        .nav-tabs-modern .nav-link:hover {
            color: var(--primary-color);
            background: var(--bg-gray-50);
        }

        .nav-tabs-modern .nav-link.active {
            background: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-md);
        }

        /* Upload Section */
        .upload-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-lg);
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .upload-zone:hover {
            border-color: var(--primary-color);
            background: var(--bg-gray-50);
        }

        .upload-zone.dragover {
            border-color: var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
        }

        .upload-zone.has-file {
            border-color: var(--success-color);
            background: rgba(5, 150, 105, 0.05);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .upload-text {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .upload-subtext {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .file-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: var(--radius-lg);
            margin: 1rem auto;
            object-fit: cover;
        }

        /* Schedule Form */
        .schedule-form {
            background: var(--bg-gray-50);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
            transition: all 0.2s ease;
            background: var(--bg-white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-upload {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-upload:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-upload:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Media Grid */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        /* Media Card */
        .media-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
        }

        .media-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .media-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: var(--bg-gray-100);
            position: relative;
        }

        .media-type-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-md);
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-md);
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-badge.active {
            background: var(--success-color);
            color: white;
        }

        .status-badge.scheduled {
            background: var(--warning-color);
            color: white;
        }

        .status-badge.expired {
            background: var(--error-color);
            color: white;
        }

        .status-badge.archived {
            background: var(--text-light);
            color: white;
        }

        .media-content {
            padding: 1.5rem;
        }

        .media-info {
            margin-bottom: 1rem;
        }

        .media-filename {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            word-break: break-all;
        }

        .media-schedule {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .media-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            flex: 1;
            min-width: 80px;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background: #ea580c;
        }

        .btn-danger {
            background: var(--error-color);
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            background: var(--text-light);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--text-secondary);
        }

        /* Video Player */
        .video-preview {
            width: 100%;
            height: 200px;
            background: #000;
            border-radius: var(--radius-md);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .media-container {
                padding: 0.75rem;
            }

            .page-header {
                padding: 1.5rem;
                text-align: center;
            }

            .page-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .nav-tabs-modern {
                padding: 0.25rem;
            }

            .nav-tabs-modern .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .upload-card {
                padding: 1.25rem;
            }

            .upload-zone {
                padding: 2rem 1rem;
            }

            .upload-icon {
                font-size: 2.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .media-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .media-content {
                padding: 1.25rem;
            }

            .media-actions {
                flex-direction: column;
            }

            .btn-action {
                flex: none;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.5rem;
            }

            .upload-zone {
                padding: 1.5rem 0.75rem;
            }

            .media-actions {
                gap: 0.375rem;
            }

            .btn-action {
                padding: 0.625rem 0.875rem;
                font-size: 0.8rem;
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

        .media-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Drag and Drop */
        .upload-zone.dragover {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        /* Loading State */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error States */
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 0.5rem;
        }

        /* Success States */
        .success-message {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }

        .success-message i {
            margin-right: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="media-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="fas fa-photo-video"></i>
                    {{ __('Media Manager') }}
                </h1>
                <p class="page-description">
                    {{ __('Kelola background, gambar, dan video untuk display TV masjid') }}
                </p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs-modern" id="mediaTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="background-tab" data-bs-toggle="tab" data-bs-target="#background-pane" type="button" role="tab">
                    <i class="fas fa-image me-2"></i>Background
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-pane" type="button" role="tab">
                    <i class="fas fa-images me-2"></i>Gambar
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-pane" type="button" role="tab">
                    <i class="fas fa-video me-2"></i>Video
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="archive-tab" data-bs-toggle="tab" data-bs-target="#archive-pane" type="button" role="tab">
                    <i class="fas fa-archive me-2"></i>Arsip
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="mediaTabContent">

            <!-- Background Tab -->
            <div class="tab-pane fade show active" id="background-pane" role="tabpanel">
                <!-- Upload Section -->
                <div class="upload-card">
                    <h3 class="mb-4">
                        <i class="fas fa-cloud-upload-alt me-2"></i>
                        Upload Background Baru
                    </h3>

                    <form method="POST" action="{{ Route::has('file.store') ? route('file.store') : '#' }}" enctype="multipart/form-data" id="background-form">
                        @csrf
                        <input type="hidden" name="type" value="background">
                        <input type="hidden" name="is_template" value="0">

                        <div class="upload-zone" id="background-dropzone">
                            <input type="file" id="background-input" name="file" accept="image/*" class="d-none">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div class="upload-text">Klik atau drag file ke sini</div>
                                <div class="upload-subtext">Maksimal 10MB • JPG, PNG, GIF</div>
                            </div>
                            <img id="background-preview" class="file-preview d-none" />
                        </div>

                        <div class="schedule-form">
                            <h4 class="mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Jadwal Tampil
                            </h4>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="start_date">Tanggal Mulai</label>
                                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="end_date">Tanggal Selesai</label>
                                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn-upload" disabled>
                                <i class="fas fa-upload me-2"></i>
                                Upload Background
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Media Grid -->
                <div class="media-grid">
                    @forelse ($backgrounds ?? [] as $background)
                        <div class="media-card">
                            <div class="media-preview">
                                <img src="{{ asset('storage/' . $background->path . $background->name) }}" alt="Background" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="media-type-badge">Background</div>
                                <div class="status-badge {{ $background->status == '1' ? 'active' : ($background->status == '2' ? 'scheduled' : 'expired') }}">
                                    {{ $background->status == '1' ? 'Aktif' : ($background->status == '2' ? 'Terjadwal' : 'Kadaluarsa') }}
                                </div>
                            </div>
                            <div class="media-content">
                                <div class="media-info">
                                    <div class="media-filename">{{ $background->name ?? 'background.jpg' }}</div>
                                    <div class="media-schedule">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($background->start_date ?? now())->format('d/m/Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($background->end_date ?? now())->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="media-actions">
                                    <button class="btn-action btn-primary" onclick="editSchedule({{ $background->id ?? 0 }})">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn-action btn-warning" onclick="previewMedia('{{ asset('storage/' . $background->path . $background->name) }}')">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <button class="btn-action btn-secondary" onclick="archiveMedia({{ $background->id ?? 0 }})">
                                        <i class="fas fa-archive me-1"></i>Arsip
                                    </button>
                                    <button class="btn-action btn-danger" onclick="deleteMedia({{ $background->id ?? 0 }})">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-image empty-icon"></i>
                            <h3 class="empty-title">Belum Ada Background</h3>
                            <p class="empty-description">Upload background pertama untuk display TV masjid</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Image Tab -->
            <div class="tab-pane fade" id="image-pane" role="tabpanel">
                <!-- Upload Section -->
                <div class="upload-card">
                    <h3 class="mb-4">
                        <i class="fas fa-cloud-upload-alt me-2"></i>
                        Upload Gambar Baru
                    </h3>

                    <form method="POST" action="{{ Route::has('file.store') ? route('file.store') : '#' }}" enctype="multipart/form-data" id="image-form">
                        @csrf
                        <input type="hidden" name="type" value="image">
                        <input type="hidden" name="is_template" value="0">

                        <div class="upload-zone" id="image-dropzone">
                            <input type="file" id="image-input" name="file" accept="image/*" class="d-none">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div class="upload-text">Klik atau drag file ke sini</div>
                                <div class="upload-subtext">Maksimal 10MB • JPG, PNG, GIF</div>
                            </div>
                            <img id="image-preview" class="file-preview d-none" />
                        </div>

                        <div class="schedule-form">
                            <h4 class="mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Jadwal Tampil
                            </h4>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="image_start_date">Tanggal Mulai</label>
                                    <input type="datetime-local" id="image_start_date" name="start_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="image_end_date">Tanggal Selesai</label>
                                    <input type="datetime-local" id="image_end_date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn-upload" disabled>
                                <i class="fas fa-upload me-2"></i>
                                Upload Gambar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Media Grid -->
                <div class="media-grid">
                    @forelse ($images ?? [] as $image)
                        <div class="media-card">
                            <div class="media-preview">
                                <img src="{{ asset('storage/' . $image->path . $image->name) }}" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="media-type-badge">Gambar</div>
                                <div class="status-badge {{ $image->status == '1' ? 'active' : ($image->status == '2' ? 'scheduled' : 'expired') }}">
                                    {{ $image->status == '1' ? 'Aktif' : ($image->status == '2' ? 'Terjadwal' : 'Kadaluarsa') }}
                                </div>
                            </div>
                            <div class="media-content">
                                <div class="media-info">
                                    <div class="media-filename">{{ $image->name ?? 'image.jpg' }}</div>
                                    <div class="media-schedule">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($image->start_date ?? now())->format('d/m/Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($image->end_date ?? now())->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="media-actions">
                                    <button class="btn-action btn-primary" onclick="editSchedule({{ $image->id ?? 0 }})">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn-action btn-warning" onclick="previewMedia('{{ asset('storage/' . $image->path . $image->name) }}')">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <button class="btn-action btn-secondary" onclick="archiveMedia({{ $image->id ?? 0 }})">
                                        <i class="fas fa-archive me-1"></i>Arsip
                                    </button>
                                    <button class="btn-action btn-danger" onclick="deleteMedia({{ $image->id ?? 0 }})">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-images empty-icon"></i>
                            <h3 class="empty-title">Belum Ada Gambar</h3>
                            <p class="empty-description">Upload gambar pertama untuk display TV masjid</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Video Tab -->
            <div class="tab-pane fade" id="video-pane" role="tabpanel">
                <!-- Upload Section -->
                <div class="upload-card">
                    <h3 class="mb-4">
                        <i class="fas fa-cloud-upload-alt me-2"></i>
                        Upload Video Baru
                    </h3>

                    <form method="POST" action="{{ Route::has('file.store') ? route('file.store') : '#' }}" enctype="multipart/form-data" id="video-form">
                        @csrf
                        <input type="hidden" name="type" value="video">
                        <input type="hidden" name="is_template" value="0">

                        <div class="upload-zone" id="video-dropzone">
                            <input type="file" id="video-input" name="file" accept="video/*" class="d-none">
                            <div class="upload-content">
                                <i class="fas fa-video upload-icon"></i>
                                <div class="upload-text">Klik atau drag file video ke sini</div>
                                <div class="upload-subtext">Maksimal 100MB • MP4, AVI, MOV, WebM</div>
                            </div>
                            <video id="video-preview" class="file-preview d-none" controls>
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <div class="schedule-form">
                            <h4 class="mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Jadwal Tampil
                            </h4>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="video_start_date">Tanggal Mulai</label>
                                    <input type="datetime-local" id="video_start_date" name="start_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="video_end_date">Tanggal Selesai</label>
                                    <input type="datetime-local" id="video_end_date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn-upload" disabled>
                                <i class="fas fa-upload me-2"></i>
                                Upload Video
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Media Grid -->
                <div class="media-grid">
                    @forelse ($videos ?? [] as $video)
                        <div class="media-card">
                            <div class="media-preview">
                                @if($video->type == 'video')
                                    <video style="width: 100%; height: 100%; object-fit: cover;" muted>
                                        <source src="{{ asset('storage/' . $video->path . $video->name) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('storage/' . $video->path . $video->name) }}" alt="Video" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                                <div class="media-type-badge">Video</div>
                                <div class="status-badge {{ $video->status == '1' ? 'active' : ($video->status == '2' ? 'scheduled' : 'expired') }}">
                                    {{ $video->status == '1' ? 'Aktif' : ($video->status == '2' ? 'Terjadwal' : 'Kadaluarsa') }}
                                </div>
                            </div>
                            <div class="media-content">
                                <div class="media-info">
                                    <div class="media-filename">{{ $video->name ?? 'video.mp4' }}</div>
                                    <div class="media-schedule">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($video->start_date ?? now())->format('d/m/Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($video->end_date ?? now())->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="media-actions">
                                    <button class="btn-action btn-primary" onclick="editSchedule({{ $video->id ?? 0 }})">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn-action btn-warning" onclick="previewVideo('{{ asset('storage/' . $video->path . $video->name) }}')">
                                        <i class="fas fa-play me-1"></i>Play
                                    </button>
                                    <button class="btn-action btn-secondary" onclick="archiveMedia({{ $video->id ?? 0 }})">
                                        <i class="fas fa-archive me-1"></i>Arsip
                                    </button>
                                    <button class="btn-action btn-danger" onclick="deleteMedia({{ $video->id ?? 0 }})">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-video empty-icon"></i>
                            <h3 class="empty-title">Belum Ada Video</h3>
                            <p class="empty-description">Upload video pertama untuk display TV masjid</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Archive Tab -->
            <div class="tab-pane fade" id="archive-pane" role="tabpanel">
                <div class="media-grid">
                    @forelse ($archived ?? [] as $item)
                        <div class="media-card">
                            <div class="media-preview">
                                @if($item->type == 'video')
                                    <video style="width: 100%; height: 100%; object-fit: cover;" muted>
                                        <source src="{{ asset('storage/' . $item->path . $item->name) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('storage/' . $item->path . $item->name) }}" alt="{{ $item->type }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                                <div class="media-type-badge">{{ ucfirst($item->type ?? 'File') }}</div>
                                <div class="status-badge archived">Diarsipkan</div>
                            </div>
                            <div class="media-content">
                                <div class="media-info">
                                    <div class="media-filename">{{ $item->name ?? 'file' }}</div>
                                    <div class="media-schedule">
                                        <i class="fas fa-archive me-1"></i>
                                        Diarsipkan pada {{ \Carbon\Carbon::parse($item->updated_at ?? now())->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="media-actions">
                                    <button class="btn-action btn-primary" onclick="restoreMedia({{ $item->id ?? 0 }})">
                                        <i class="fas fa-undo me-1"></i>Pulihkan
                                    </button>
                                    <button class="btn-action btn-danger" onclick="deleteMedia({{ $item->id ?? 0 }})">
                                        <i class="fas fa-trash me-1"></i>Hapus Permanen
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-archive empty-icon"></i>
                            <h3 class="empty-title">Arsip Kosong</h3>
                            <p class="empty-description">Belum ada file yang diarsipkan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Schedule -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editScheduleForm">
                        <input type="hidden" id="edit_media_id">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="edit_start_date">Tanggal Mulai</label>
                                <input type="datetime-local" id="edit_start_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_end_date">Tanggal Selesai</label>
                                <input type="datetime-local" id="edit_end_date" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveSchedule()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" class="img-fluid d-none" style="max-height: 70vh;">
                    <video id="previewVideo" class="d-none" style="max-width: 100%; max-height: 70vh;" controls>
                        <source src="" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // ===== DEFINE API ROUTES USING LARAVEL ROUTE HELPERS =====
        const API_ROUTES = {
            updateSchedule: @json(route('file.ajax.update-schedule')),
            getSchedule: '{{ route("file.schedule.show", ":id") }}',  // Will replace :id with actual ID
            archive: @json(route('file.ajax.archive')),
            restore: @json(route('file.ajax.restore')),
            delete: @json(route('file.ajax.delete')),
            bulkArchive: @json(route('file.ajax.bulk.archive')),
            bulkRestore: @json(route('file.ajax.bulk.restore')),
            bulkDelete: @json(route('file.ajax.bulk.delete')),
            stats: @json(route('file.ajax.stats')),
            statusCheck: @json(route('file.status.check'))
        };

        // Helper function for dynamic routes (like schedule with ID)
        function getRoute(routeName, params = {}) {
            let url = API_ROUTES[routeName];
            Object.keys(params).forEach(key => {
                url = url.replace(`:${key}`, params[key]);
            });
            return url;
        }

        // Helper function for all AJAX calls with consistent error handling
        function makeApiRequest(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            };

            return fetch(url, { ...defaultOptions, ...options })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('API request failed:', error);
                    showMessage('Terjadi kesalahan koneksi', 'error');
                    throw error;
                });
        }

        $(document).ready(function() {
            // Initialize drag and drop for all upload zones
            initializeDragDrop();

            // Initialize file input handlers
            initializeFileInputs();

            // Set default dates (current time + 1 hour for start, + 1 day for end)
            setDefaultDates();

            // Add date validation listeners
            initializeDateValidation();
        });

        // Add date validation
        function initializeDateValidation() {
            document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
                input.addEventListener('change', function() {
                    validateDates(this.closest('form'));
                });
            });
        }

        function validateDates(form) {
            const startDateInput = form.querySelector('input[name="start_date"]');
            const endDateInput = form.querySelector('input[name="end_date"]');
            const submitBtn = form.querySelector('.btn-upload');

            if (startDateInput && endDateInput) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate >= endDate) {
                    showMessage('Tanggal selesai harus lebih besar dari tanggal mulai', 'error');
                    submitBtn.disabled = true;
                } else {
                    // Check if file is also selected
                    const fileInput = form.querySelector('input[name="file"]');
                    if (fileInput && fileInput.files && fileInput.files.length > 0) {
                        submitBtn.disabled = false;
                    }
                }
            }
        }

        function initializeDragDrop() {
            const dropzones = document.querySelectorAll('.upload-zone');

            dropzones.forEach(dropzone => {
                const input = dropzone.querySelector('input[type="file"]');

                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.classList.add('dragover');
                });

                dropzone.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                });

                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        input.files = files;
                        handleFileSelect(input);
                    }
                });

                dropzone.addEventListener('click', () => {
                    input.click();
                });
            });
        }

        function initializeFileInputs() {
            const fileInputs = document.querySelectorAll('input[type="file"]');

            fileInputs.forEach(input => {
                input.addEventListener('change', () => {
                    handleFileSelect(input);
                });
            });
        }

        function handleFileSelect(input) {
            const file = input.files[0];
            const dropzone = input.closest('.upload-zone');
            const preview = dropzone.querySelector('.file-preview');
            const content = dropzone.querySelector('.upload-content');
            const form = input.closest('form');
            const submitBtn = form.querySelector('.btn-upload');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (file.type.startsWith('video/')) {
                        if (preview.tagName === 'VIDEO') {
                            preview.src = e.target.result;
                            preview.classList.remove('d-none');
                            content.style.display = 'none';
                        }
                    } else {
                        if (preview.tagName === 'IMG') {
                            preview.src = e.target.result;
                            preview.classList.remove('d-none');
                            content.style.display = 'none';
                        }
                    }

                    dropzone.classList.add('has-file');

                    // Enable submit button only if dates are also filled
                    const startDate = form.querySelector('input[name="start_date"]');
                    const endDate = form.querySelector('input[name="end_date"]');

                    if (startDate && endDate && startDate.value && endDate.value) {
                        submitBtn.disabled = false;
                    } else {
                        // Ensure dates are set
                        setDefaultDatesForForm(form);
                        submitBtn.disabled = false;
                    }
                };

                reader.readAsDataURL(file);

                // Show success message
                showMessage('File berhasil dipilih: ' + file.name, 'success');
            } else {
                // Reset preview
                preview.classList.add('d-none');
                content.style.display = 'block';
                dropzone.classList.remove('has-file');
                submitBtn.disabled = true;
            }
        }

        // Helper function to set default dates for specific form
        function setDefaultDatesForForm(form) {
            const now = new Date();
            const startDate = new Date(now.getTime() + 60 * 60 * 1000); // +1 hour
            const endDate = new Date(now.getTime() + 24 * 60 * 60 * 1000); // +1 day

            const startString = startDate.toISOString().slice(0, 16);
            const endString = endDate.toISOString().slice(0, 16);

            const startInput = form.querySelector('input[name="start_date"]');
            const endInput = form.querySelector('input[name="end_date"]');

            if (startInput && !startInput.value) {
                startInput.value = startString;
            }
            if (endInput && !endInput.value) {
                endInput.value = endString;
            }
        }

        function setDefaultDates() {
            const now = new Date();
            const startDate = new Date(now.getTime() + 60 * 60 * 1000); // +1 hour
            const endDate = new Date(now.getTime() + 24 * 60 * 60 * 1000); // +1 day

            const startString = startDate.toISOString().slice(0, 16);
            const endString = endDate.toISOString().slice(0, 16);

            // Set for all datetime-local inputs with specific IDs
            const dateInputs = [
                'start_date', 'image_start_date', 'video_start_date',
                'end_date', 'image_end_date', 'video_end_date'
            ];

            dateInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    if (inputId.includes('start')) {
                        input.value = startString;
                    } else if (inputId.includes('end')) {
                        input.value = endString;
                    }
                }
            });
        }

        // ===== MAIN API FUNCTIONS WITH IMPROVED ERROR HANDLING =====

        async function editSchedule(mediaId) {
            try {
                // Set media ID
                document.getElementById('edit_media_id').value = mediaId;

                // Load current schedule data from server using the helper function
                const data = await makeApiRequest(getRoute('getSchedule', {id: mediaId}), {
                    method: 'GET'
                });

                if (data.success) {
                    // Convert UTC to local datetime format
                    const startDate = new Date(data.data.start_date);
                    const endDate = new Date(data.data.end_date);

                    document.getElementById('edit_start_date').value = formatDateTimeLocal(startDate);
                    document.getElementById('edit_end_date').value = formatDateTimeLocal(endDate);
                } else {
                    // Set default values if no data
                    const now = new Date();
                    document.getElementById('edit_start_date').value = formatDateTimeLocal(now);
                    document.getElementById('edit_end_date').value = formatDateTimeLocal(new Date(now.getTime() + 24 * 60 * 60 * 1000));
                }

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
                modal.show();

            } catch (error) {
                console.error('Error loading schedule:', error);
                // Set default values on error
                const now = new Date();
                document.getElementById('edit_start_date').value = formatDateTimeLocal(now);
                document.getElementById('edit_end_date').value = formatDateTimeLocal(new Date(now.getTime() + 24 * 60 * 60 * 1000));

                // Still show modal even if loading failed
                const modal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
                modal.show();
            }
        }

        async function saveSchedule() {
            const mediaId = document.getElementById('edit_media_id').value;
            const startDate = document.getElementById('edit_start_date').value;
            const endDate = document.getElementById('edit_end_date').value;

            // Validate dates
            if (!startDate || !endDate) {
                showMessage('Tanggal mulai dan selesai harus diisi', 'error');
                return;
            }

            if (new Date(startDate) >= new Date(endDate)) {
                showMessage('Tanggal selesai harus lebih besar dari tanggal mulai', 'error');
                return;
            }

            // Show loading state
            const saveBtn = document.querySelector('#editScheduleModal .btn-primary');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<div class="spinner"></div>Menyimpan...';
            saveBtn.disabled = true;

            try {
                const data = await makeApiRequest(API_ROUTES.updateSchedule, {
                    method: 'POST',
                    body: JSON.stringify({
                        id: mediaId,
                        start_date: startDate,
                        end_date: endDate
                    })
                });

                if (data.success) {
                    showMessage('Jadwal berhasil diperbarui', 'success');
                    // Close modal first
                    bootstrap.Modal.getInstance(document.getElementById('editScheduleModal')).hide();
                    // Then reload after a short delay
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    showMessage('Gagal memperbarui jadwal: ' + (data.message || data.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                console.error('Error updating schedule:', error);
                showMessage('Terjadi kesalahan saat memperbarui jadwal', 'error');
            } finally {
                // Reset button state
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        }

        async function archiveMedia(mediaId) {
            if (confirm('Apakah Anda yakin ingin mengarsipkan file ini?')) {
                try {
                    const data = await makeApiRequest(API_ROUTES.archive, {
                        method: 'POST',
                        body: JSON.stringify({ id: mediaId })
                    });

                    if (data.success) {
                        showMessage('File berhasil diarsipkan', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal mengarsipkan file: ' + (data.message || data.error || 'Unknown error'), 'error');
                    }
                } catch (error) {
                    console.error('Error archiving file:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        async function restoreMedia(mediaId) {
            if (confirm('Apakah Anda yakin ingin memulihkan file ini?')) {
                try {
                    const data = await makeApiRequest(API_ROUTES.restore, {
                        method: 'POST',
                        body: JSON.stringify({ id: mediaId })
                    });

                    if (data.success) {
                        showMessage('File berhasil dipulihkan', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal memulihkan file: ' + (data.message || data.error || 'Unknown error'), 'error');
                    }
                } catch (error) {
                    console.error('Error restoring file:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        async function deleteMedia(mediaId) {
            if (confirm('Apakah Anda yakin ingin menghapus file ini secara permanen?')) {
                try {
                    const data = await makeApiRequest(API_ROUTES.delete, {
                        method: 'DELETE',
                        body: JSON.stringify({ id: mediaId })
                    });

                    if (data.success) {
                        showMessage('File berhasil dihapus', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal menghapus file: ' + (data.message || data.error || 'Unknown error'), 'error');
                    }
                } catch (error) {
                    console.error('Error deleting file:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        // ===== BULK OPERATIONS =====

        async function bulkArchive(ids) {
            if (confirm(`Apakah Anda yakin ingin mengarsipkan ${ids.length} file?`)) {
                try {
                    const data = await makeApiRequest(API_ROUTES.bulkArchive, {
                        method: 'POST',
                        body: JSON.stringify({ ids: ids })
                    });

                    if (data.success) {
                        showMessage('Files berhasil diarsipkan', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal mengarsipkan files', 'error');
                    }
                } catch (error) {
                    console.error('Error bulk archiving:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        async function bulkRestore(ids) {
            if (confirm(`Apakah Anda yakin ingin memulihkan ${ids.length} file?`)) {
                try {
                    const data = await makeApiRequest(API_ROUTES.bulkRestore, {
                        method: 'POST',
                        body: JSON.stringify({ ids: ids })
                    });

                    if (data.success) {
                        showMessage('Files berhasil dipulihkan', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal memulihkan files', 'error');
                    }
                } catch (error) {
                    console.error('Error bulk restoring:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        async function bulkDelete(ids) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} file secara permanen?`)) {
                try {
                    const data = await makeApiRequest(API_ROUTES.bulkDelete, {
                        method: 'DELETE',
                        body: JSON.stringify({ ids: ids })
                    });

                    if (data.success) {
                        showMessage('Files berhasil dihapus', 'success');
                        location.reload();
                    } else {
                        showMessage('Gagal menghapus files', 'error');
                    }
                } catch (error) {
                    console.error('Error bulk deleting:', error);
                    showMessage('Terjadi kesalahan', 'error');
                }
            }
        }

        // ===== UTILITY FUNCTIONS =====

        // Helper function to format date for datetime-local input
        function formatDateTimeLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function showMessage(message, type) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;

            document.body.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }

        // Function to get file statistics
        async function loadFileStats() {
            try {
                const data = await makeApiRequest(API_ROUTES.stats, {
                    method: 'GET'
                });

                if (data.success) {
                    // Update UI with stats if needed
                    console.log('File stats:', data.data);
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Auto-refresh status check every 5 minutes
        setInterval(async () => {
            try {
                const data = await makeApiRequest(API_ROUTES.statusCheck, {
                    method: 'GET'
                });

                if (data.success) {
                    console.log('File statuses updated automatically');
                    // Optionally refresh the page if status changes detected
                    // location.reload();
                }
            } catch (error) {
                console.error('Error checking statuses:', error);
            }
        }

        // Handle form submissions with loading states and validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-upload');
            if (submitBtn) {
            // Validate required fields
            const startDateInput = this.querySelector('input[name="start_date"]');
            const endDateInput = this.querySelector('input[name="end_date"]');
            const fileInput = this.querySelector('input[name="file"]');

            if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            showMessage('Silakan pilih file terlebih dahulu', 'error');
            return;
            }

            if (!startDateInput.value || !endDateInput.value) {
            e.preventDefault();
            showMessage('Tanggal mulai dan selesai harus diisi', 'error');
            return;
            }

            if (new Date(startDateInput.value) >= new Date(endDateInput.value)) {
            e.preventDefault();
            showMessage('Tanggal selesai harus lebih besar dari tanggal mulai', 'error');
            return;
            }

            // Show loading state
            submitBtn.innerHTML = '<div class="spinner"></div>Uploading...';
            submitBtn.disabled = true;
            }
            });
        });

        // Preview functions for media (implement these as needed)
        function previewMedia(url) {
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            const img = document.getElementById('previewImage');
            const video = document.getElementById('previewVideo');

            // Hide both elements first
            img.classList.add('d-none');
            video.classList.add('d-none');

            // Show image
            img.src = url;
            img.classList.remove('d-none');

            modal.show();
        }

        function previewVideo(url) {
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            const img = document.getElementById('previewImage');
            const video = document.getElementById('previewVideo');

            // Hide both elements first
            img.classList.add('d-none');
            video.classList.add('d-none');

            // Show video
            video.src = url;
            video.classList.remove('d-none');

            modal.show();
        }

        // Auto-refresh to check for expired files every 5 minutes
        setInterval(() => {
        // You could implement auto-refresh logic here
        // or check file statuses via AJAX
        }, 5 * 60 * 1000);

    </script>
@endsection // 5 minutes
