<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master - Santri Tahsin & Tahfiz</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .dashboard-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .card-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 20px;
            color: white;
        }
        .icon-program { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .icon-ustadz { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); }
        .icon-kelas { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); }
        .icon-donatur { background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%); }
        .icon-tromol { background: linear-gradient(135deg, #607D8B 0%, #455A64 100%); }
        .btn-dashboard {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .feature-card {
            height: 100%;
            padding: 30px;
        }
    </style>
</head>
<body>
<section class="dashboard-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-database me-3"></i>
                Data Master
            </h1>
            <p class="lead">
                Kelola data master program Tahsin & Tahfiz dengan mudah dan terstruktur
            </p>
        </div>

        <div class="row g-4">
            <!-- Program Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon icon-program">
                        <i class="fas fa-book-quran"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Program</h4>
                    <p class="text-muted mb-4">
                        Kelola program Tahsin dan Tahfiz untuk berbagai kategori usia dan tingkatan
                    </p>
                    <a href="<?= base_url('data-master/program') ?>" class="btn btn-dashboard">
                        <i class="fas fa-cog me-2"></i>
                        Kelola Program
                    </a>
                </div>
            </div>

            <!-- Ustadz Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon icon-ustadz">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Ustadz</h4>
                    <p class="text-muted mb-4">
                        Kelola data pengajar dengan spesialisasi Tahsin, Tahfiz, atau keduanya
                    </p>
                    <a href="<?= base_url('data-master/ustadz') ?>" class="btn btn-dashboard">
                        <i class="fas fa-users me-2"></i>
                        Kelola Ustadz
                    </a>
                </div>
            </div>

            <!-- Kelas Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon icon-kelas">
                        <i class="fas fa-school"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Kelas</h4>
                    <p class="text-muted mb-4">
                        Atur jadwal kelas, kapasitas, ruangan, dan assignment ustadz pengajar
                    </p>
                    <a href="<?= base_url('data-master/kelas') ?>" class="btn btn-dashboard">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Kelola Kelas
                    </a>
                </div>
            </div>

            <!-- Donatur Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon icon-donatur">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Donatur</h4>
                    <p class="text-muted mb-4">
                        Kelola data donatur tetap dan tidak tetap beserta komitmen donasi
                    </p>
                    <a href="<?= base_url('data-master/donatur') ?>" class="btn btn-dashboard">
                        <i class="fas fa-heart me-2"></i>
                        Kelola Donatur
                    </a>
                </div>
            </div>

            <!-- Lokasi Tromol Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon icon-tromol">
                        <i class="fas fa-box"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Lokasi Tromol</h4>
                    <p class="text-muted mb-4">
                        Kelola lokasi penempatan tromol sedekah dan jadwal pengambilannya
                    </p>
                    <a href="<?= base_url('data-master/lokasi-tromol') ?>" class="btn btn-dashboard">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Kelola Tromol
                    </a>
                </div>
            </div>

            <!-- Quick Links Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card text-center">
                    <div class="card-icon" style="background: linear-gradient(135deg, #E91E63 0%, #C2185B 100%);">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    <h4 class="card-title text-dark mb-3">Quick Links</h4>
                    <p class="text-muted mb-4">
                        Akses cepat ke form pendaftaran dan fitur lainnya
                    </p>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>
                            Form Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Row -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark mb-4">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Cepat
                        </h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="border-end">
                                    <h3 class="text-success mb-1">
                                        <i class="fas fa-book-quran"></i>
                                    </h3>
                                    <p class="text-muted mb-0">Program Aktif</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="border-end">
                                    <h3 class="text-primary mb-1">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </h3>
                                    <p class="text-muted mb-0">Ustadz Terdaftar</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="border-end">
                                    <h3 class="text-warning mb-1">
                                        <i class="fas fa-school"></i>
                                    </h3>
                                    <p class="text-muted mb-0">Kelas Tersedia</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <h3 class="text-info mb-1">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </h3>
                                <p class="text-muted mb-0">Donatur Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
