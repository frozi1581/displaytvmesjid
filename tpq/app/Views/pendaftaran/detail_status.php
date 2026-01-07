<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran - <?= $pendaftaran['nama_lengkap'] ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-section {
            background: linear-gradient(135deg, #673AB7 0%, #512DA8 100%);
            color: white;
            padding: 60px 0;
            min-height: 100vh;
        }
        .status-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .status-header {
            background: linear-gradient(135deg, #673AB7 0%, #512DA8 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .info-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .status-pending { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
        .status-diterima { background: #d1edff; color: #0c5460; border-left: 4px solid #0dcaf0; }
        .status-ditolak { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .status-waiting { background: #e2e3e5; color: #383d41; border-left: 4px solid #6c757d; }
    </style>
</head>
<body>
<section class="status-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="status-card">
                    <div class="status-header">
                        <h1 class="mb-3">
                            <i class="fas fa-user-graduate me-2"></i>
                            Status Pendaftaran
                        </h1>
                        <p class="lead mb-0"><?= $pendaftaran['nama_lengkap'] ?></p>
                    </div>

                    <div class="p-4">
                        <!-- Status Badge -->
                        <div class="text-center mb-4">
                            <div class="status-<?= $pendaftaran['status_pendaftaran'] ?> p-3 rounded-3 d-inline-block">
                                <h4 class="mb-0">
                                    <?php
                                    $icons = [
                                        'pending' => 'fas fa-hourglass-half',
                                        'diterima' => 'fas fa-check-circle',
                                        'ditolak' => 'fas fa-times-circle',
                                        'waiting_list' => 'fas fa-clock'
                                    ];
                                    ?>
                                    <i class="<?= $icons[$pendaftaran['status_pendaftaran']] ?> me-2"></i>
                                    <?= $pendaftaran['status_text'] ?>
                                </h4>
                            </div>
                        </div>

                        <!-- Info Pendaftaran -->
                        <div class="info-card">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-id-card me-2"></i>
                                Informasi Pendaftaran
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Nomor Pendaftaran:</strong><br>
                                    <span class="text-primary fs-5"><?= $pendaftaran['nomor_pendaftaran'] ?></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Nomor Induk Santri:</strong><br>
                                    <span class="text-primary fs-5"><?= $pendaftaran['nomor_induk'] ?></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Tanggal Daftar:</strong><br>
                                    <?= date('d M Y', strtotime($pendaftaran['tanggal_daftar'])) ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Kategori:</strong><br>
                                    <?= ucfirst($pendaftaran['kategori_usia']) ?>
                                    (<?= $pendaftaran['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>)
                                </div>
                            </div>
                        </div>

                        <!-- Info Program & Kelas -->
                        <div class="info-card">
                            <h5 class="text-success mb-3">
                                <i class="fas fa-book-quran me-2"></i>
                                Program & Kelas
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong>Program:</strong><br>
                                    <?= $pendaftaran['nama_program'] ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Kelas:</strong><br>
                                    <?= $pendaftaran['nama_kelas'] ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Jadwal:</strong><br>
                                    <?= $pendaftaran['hari_belajar'] ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Waktu:</strong><br>
                                    <?= date('H:i', strtotime($pendaftaran['waktu_mulai'])) ?> -
                                    <?= date('H:i', strtotime($pendaftaran['waktu_selesai'])) ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Ruangan:</strong><br>
                                    <?= $pendaftaran['ruangan'] ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Ustadz:</strong><br>
                                    <?= $pendaftaran['nama_ustadz'] ?>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information -->
                        <?php if ($pendaftaran['status_pendaftaran'] == 'diterima' && $pendaftaran['tanggal_mulai_belajar']): ?>
                            <div class="alert alert-success">
                                <h6 class="alert-heading">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Selamat! Pendaftaran Anda Diterima
                                </h6>
                                <p class="mb-0">
                                    Kelas akan dimulai pada:
                                    <strong><?= date('d M Y', strtotime($pendaftaran['tanggal_mulai_belajar'])) ?></strong>
                                </p>
                            </div>
                        <?php elseif ($pendaftaran['status_pendaftaran'] == 'ditolak'): ?>
                            <div class="alert alert-danger">
                                <h6 class="alert-heading">
                                    <i class="fas fa-times-circle me-2"></i>
                                    Pendaftaran Ditolak
                                </h6>
                                <p class="mb-0">
                                    Mohon maaf, pendaftaran Anda tidak dapat diproses.
                                    Silakan hubungi admin untuk informasi lebih lanjut.
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="text-center">
                            <a href="<?= base_url('pendaftaran/cek-status') ?>" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-search me-2"></i>
                                Cek Status Lain
                            </a>
                            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-home me-2"></i>
                                Halaman Utama
                            </a>
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
