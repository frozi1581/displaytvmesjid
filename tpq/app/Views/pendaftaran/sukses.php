<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - Santri Tahsin & Tahfiz</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .success-section {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 80px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 20px;
        }
        .info-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .status-badge {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
        }
    </style>
</head>
<body>
<section class="success-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card">
                    <div class="success-header">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h1 class="mb-3">Pendaftaran Berhasil!</h1>
                        <p class="lead mb-0">Terima kasih telah mendaftar program Tahsin & Tahfiz</p>
                    </div>

                    <div class="p-4">
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
                                    <strong>Nama Santri:</strong><br>
                                    <?= $pendaftaran['nama_lengkap'] ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Tanggal Daftar:</strong><br>
                                    <?= date('d M Y', strtotime($pendaftaran['tanggal_daftar'])) ?>
                                </div>
                            </div>
                        </div>

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

                        <div class="text-center mb-4">
                            <div class="status-badge">
                                <i class="fas fa-hourglass-half me-2"></i>
                                Status: Menunggu Verifikasi
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Langkah Selanjutnya:
                            </h6>
                            <ul class="mb-0">
                                <li>Simpan nomor pendaftaran ini untuk referensi</li>
                                <li>Tunggu konfirmasi dari admin dalam 1-3 hari kerja</li>
                                <li>Anda akan dihubungi melalui nomor HP yang terdaftar</li>
                                <li>Cek status pendaftaran secara berkala</li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <a href="<?= base_url('pendaftaran/cek-status') ?>" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-search me-2"></i>
                                Cek Status Pendaftaran
                            </a>
                            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Daftar Lagi
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
