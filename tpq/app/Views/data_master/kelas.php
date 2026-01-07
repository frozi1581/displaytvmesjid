<?php
// ================================================================
// app/Views/data_master/kelas.php
// ================================================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas - Data Master</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .header-section {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            padding: 40px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #FF9800;
            box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
        }
        .btn-warning {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #F57C00 0%, #E65100 100%);
            color: white;
        }
        .badge-anak {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
        }
        .badge-dewasa {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
        }
        .badge-semua {
            background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
        }
        .progress-capacity {
            height: 10px;
            border-radius: 5px;
            background-color: #e9ecef;
        }
        .progress-bar-capacity {
            border-radius: 5px;
            transition: width 0.6s ease;
        }
        .kelas-card {
            border-left: 5px solid #FF9800;
            transition: all 0.3s ease;
        }
        .kelas-card:hover {
            border-left-color: #F57C00;
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.2);
        }
        .time-badge {
            background: rgba(255, 152, 0, 0.1);
            color: #FF9800;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .capacity-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }
        .status-available { background-color: #4CAF50; }
        .status-medium { background-color: #FF9800; }
        .status-full { background-color: #F44336; }
        .section-divider {
            border-top: 3px solid #FF9800;
            margin: 30px 0;
            opacity: 0.3;
        }
        .info-icon {
            color: #FF9800;
            font-size: 1.2em;
        }
        .table th {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        .stats-card {
            background: linear-gradient(135deg, rgba(255, 152, 0, 0.1) 0%, rgba(245, 124, 0, 0.1) 100%);
            border: 2px solid rgba(255, 152, 0, 0.2);
            border-radius: 15px;
        }
    </style>
</head>
<body>
<!-- Header Section -->
<section class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-3">
                    <i class="fas fa-school me-3"></i>
                    Kelola Kelas
                </h1>
                <p class="lead mb-0">Atur jadwal kelas, kapasitas, dan assignment ustadz pengajar</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= base_url('data-master') ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <!-- Success/Error Messages -->
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card stats-card">
                <div class="card-body">
                    <h5 class="card-title text-warning mb-3">
                        <i class="fas fa-chart-bar me-2"></i>
                        Ringkasan Kelas
                    </h5>
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h3 class="text-warning mb-1"><?= count($kelas) ?></h3>
                                <p class="text-muted mb-0">Total Kelas</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <?php
                                $total_kapasitas = array_sum(array_column($kelas, 'kapasitas_maksimal'));
                                ?>
                                <h3 class="text-primary mb-1"><?= $total_kapasitas ?></h3>
                                <p class="text-muted mb-0">Total Kapasitas</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <?php
                                $total_peserta = array_sum(array_column($kelas, 'peserta_terdaftar'));
                                ?>
                                <h3 class="text-success mb-1"><?= $total_peserta ?></h3>
                                <p class="text-muted mb-0">Peserta Terdaftar</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php
                            $sisa_kapasitas = $total_kapasitas - $total_peserta;
                            ?>
                            <h3 class="text-info mb-1"><?= $sisa_kapasitas ?></h3>
                            <p class="text-muted mb-0">Sisa Kapasitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Tambah Kelas -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Kelas Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('data-master/kelas/store') ?>" method="POST" id="formKelas">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-tag me-1"></i>
                                Nama Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="nama_kelas"
                                   value="<?= old('nama_kelas') ?>"
                                   placeholder="Contoh: Tahsin Anak A" required>
                            <div class="form-text">Nama kelas harus unik dan mudah diingat</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-book-quran me-1"></i>
                                Program <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="id_program" id="selectProgram" required>
                                <option value="">Pilih Program</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['id_program'] ?>"
                                            data-kategori="<?= $program['kategori_usia'] ?>"
                                        <?= old('id_program') == $program['id_program'] ? 'selected' : '' ?>>
                                        <?= $program['nama_program'] ?> (<?= ucfirst($program['kategori_usia']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-chalkboard-teacher me-1"></i>
                                Ustadz Pengajar <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="id_ustadz" id="selectUstadz" required>
                                <option value="">Pilih Ustadz</option>
                                <?php foreach ($ustadz_list as $ustadz): ?>
                                    <option value="<?= $ustadz['id_ustadz'] ?>"
                                            data-spesialisasi="<?= $ustadz['spesialisasi'] ?>"
                                        <?= old('id_ustadz') == $ustadz['id_ustadz'] ? 'selected' : '' ?>>
                                        <?= $ustadz['nama_ustadz'] ?> (<?= ucfirst($ustadz['spesialisasi']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Pastikan spesialisasi ustadz sesuai dengan program</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-users me-1"></i>
                                Kapasitas Maksimal <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" name="kapasitas_maksimal"
                                   value="<?= old('kapasitas_maksimal') ?>" min="1" max="50"
                                   placeholder="Masukkan jumlah maksimal peserta" required>
                            <div class="form-text">Rekomendasi: 15-25 orang untuk efektivitas pembelajaran</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-calendar-alt me-1"></i>
                                Hari Belajar <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="hari_belajar"
                                   value="<?= old('hari_belajar') ?>"
                                   placeholder="Contoh: Senin, Rabu, Jumat" required>
                            <div class="form-text">Tuliskan hari-hari pembelajaran</div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="info-icon fas fa-clock me-1"></i>
                                    Waktu Mulai <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control" name="waktu_mulai"
                                       value="<?= old('waktu_mulai') ?>" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="info-icon fas fa-clock me-1"></i>
                                    Waktu Selesai <span class="text-danger">*</span>
                                </label>
                                <input type="time" class="form-control" name="waktu_selesai"
                                       value="<?= old('waktu_selesai') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-door-open me-1"></i>
                                Ruangan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="ruangan"
                                   value="<?= old('ruangan') ?>"
                                   placeholder="Contoh: Ruang A1, Aula Utama" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="info-icon fas fa-money-bill-wave me-1"></i>
                                Biaya Operasional Bulanan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="biaya_operasional_bulanan"
                                       value="<?= old('biaya_operasional_bulanan') ?>" min="0"
                                       placeholder="0">
                            </div>
                            <div class="form-text">Biaya operasional seperti listrik, air, dan perlengkapan kelas</div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100" id="btnSubmit">
                            <i class="fas fa-save me-2"></i>
                            Simpan Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Kelas -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Daftar Kelas (<?= count($kelas) ?>)
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light btn-sm" onclick="toggleView('card')" id="btnCardView">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="btn btn-outline-light btn-sm" onclick="toggleView('table')" id="btnTableView">
                                <i class="fas fa-table"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($kelas)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chalkboard fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada kelas yang terdaftar</h5>
                            <p class="text-muted">Silakan tambah kelas baru menggunakan form di sebelah kiri</p>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tips: Pastikan sudah ada program dan ustadz sebelum membuat kelas
                                </small>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Card View -->
                        <div id="cardView" class="row">
                            <?php foreach ($kelas as $k): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card kelas-card h-100">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-bold text-warning"><?= $k['nama_kelas'] ?></h6>
                                                <span class="badge badge-<?= $k['kategori_usia'] ?>">
                                                        <?= ucfirst($k['kategori_usia']) ?>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p class="card-text mb-2">
                                                    <strong><i class="fas fa-book-quran text-primary me-1"></i>Program:</strong>
                                                    <?= $k['nama_program'] ?>
                                                </p>
                                                <p class="card-text mb-2">
                                                    <strong><i class="fas fa-chalkboard-teacher text-success me-1"></i>Ustadz:</strong>
                                                    <?= $k['nama_ustadz'] ?>
                                                </p>
                                                <p class="card-text mb-2">
                                                    <strong><i class="fas fa-calendar text-info me-1"></i>Jadwal:</strong>
                                                    <?= $k['hari_belajar'] ?>
                                                </p>
                                                <p class="card-text mb-2">
                                                    <strong><i class="fas fa-clock text-warning me-1"></i>Waktu:</strong>
                                                    <span class="time-badge">
                                                            <?= date('H:i', strtotime($k['waktu_mulai'])) ?> - <?= date('H:i', strtotime($k['waktu_selesai'])) ?>
                                                        </span>
                                                </p>
                                                <p class="card-text mb-3">
                                                    <strong><i class="fas fa-door-open text-secondary me-1"></i>Ruangan:</strong>
                                                    <?= $k['ruangan'] ?>
                                                </p>
                                            </div>

                                            <!-- Capacity Progress -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <small class="fw-semibold">Kapasitas Kelas</small>
                                                    <small class="capacity-indicator">
                                                        <?php
                                                        $percentage = ($k['peserta_terdaftar'] / $k['kapasitas_maksimal']) * 100;
                                                        if ($percentage >= 90) {
                                                            $statusClass = 'status-full';
                                                            $colorClass = 'bg-danger';
                                                        } elseif ($percentage >= 70) {
                                                            $statusClass = 'status-medium';
                                                            $colorClass = 'bg-warning';
                                                        } else {
                                                            $statusClass = 'status-available';
                                                            $colorClass = 'bg-success';
                                                        }
                                                        ?>
                                                        <span class="status-indicator <?= $statusClass ?>"></span>
                                                        <?= $k['peserta_terdaftar'] ?>/<?= $k['kapasitas_maksimal'] ?> orang
                                                    </small>
                                                </div>
                                                <div class="progress progress-capacity">
                                                    <div class="progress-bar progress-bar-capacity <?= $colorClass ?>"
                                                         style="width: <?= $percentage ?>%"></div>
                                                </div>
                                                <div class="text-center mt-1">
                                                    <small class="text-muted">
                                                        <?= number_format($percentage, 1) ?>% terisi
                                                        <?php if ($k['kapasitas_maksimal'] - $k['peserta_terdaftar'] > 0): ?>
                                                            • <?= $k['kapasitas_maksimal'] - $k['peserta_terdaftar'] ?> slot tersisa
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                            </div>

                                            <?php if ($k['biaya_operasional_bulanan'] > 0): ?>
                                                <div class="alert alert-info py-2 mb-3">
                                                    <small>
                                                        <i class="fas fa-money-bill-wave me-1"></i>
                                                        <strong>Operasional:</strong> Rp <?= number_format($k['biaya_operasional_bulanan'], 0, ',', '.') ?>/bulan
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-light">
                                            <button class="btn btn-sm btn-danger w-100"
                                                    onclick="confirmDelete(<?= $k['id_kelas'] ?>, '<?= $k['nama_kelas'] ?>', <?= $k['peserta_terdaftar'] ?>)">
                                                <i class="fas fa-trash me-1"></i>
                                                Hapus Kelas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Table View -->
                        <div id="tableView" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Kelas & Program</th>
                                        <th>Ustadz</th>
                                        <th>Jadwal</th>
                                        <th>Kapasitas</th>
                                        <th>Operasional</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($kelas as $k): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-warning"><?= $k['nama_kelas'] ?></strong><br>
                                                <small class="text-muted"><?= $k['nama_program'] ?></small><br>
                                                <span class="badge badge-<?= $k['kategori_usia'] ?> mt-1">
                                                            <?= ucfirst($k['kategori_usia']) ?>
                                                        </span>
                                            </td>
                                            <td>
                                                <strong><?= $k['nama_ustadz'] ?></strong><br>
                                                <small class="text-muted">
                                                    <i class="fas fa-door-open me-1"></i><?= $k['ruangan'] ?>
                                                </small>
                                            </td>
                                            <td>
                                                <strong><?= $k['hari_belajar'] ?></strong><br>
                                                <span class="time-badge">
                                                            <?= date('H:i', strtotime($k['waktu_mulai'])) ?> - <?= date('H:i', strtotime($k['waktu_selesai'])) ?>
                                                        </span>
                                            </td>
                                            <td>
                                                <div class="capacity-indicator mb-1">
                                                    <?php
                                                    $percentage = ($k['peserta_terdaftar'] / $k['kapasitas_maksimal']) * 100;
                                                    if ($percentage >= 90) {
                                                        $statusClass = 'status-full';
                                                        $colorClass = 'bg-danger';
                                                    } elseif ($percentage >= 70) {
                                                        $statusClass = 'status-medium';
                                                        $colorClass = 'bg-warning';
                                                    } else {
                                                        $statusClass = 'status-available';
                                                        $colorClass = 'bg-success';
                                                    }
                                                    ?>
                                                    <span class="status-indicator <?= $statusClass ?>"></span>
                                                    <?= $k['peserta_terdaftar'] ?>/<?= $k['kapasitas_maksimal'] ?>
                                                </div>
                                                <div class="progress progress-capacity" style="height: 6px;">
                                                    <div class="progress-bar <?= $colorClass ?>"
                                                         style="width: <?= $percentage ?>%"></div>
                                                </div>
                                                <small class="text-muted"><?= number_format($percentage, 1) ?>%</small>
                                            </td>
                                            <td>
                                                <?php if ($k['biaya_operasional_bulanan'] > 0): ?>
                                                    <strong>Rp <?= number_format($k['biaya_operasional_bulanan'], 0, ',', '.') ?></strong><br>
                                                    <small class="text-muted">/bulan</small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete(<?= $k['id_kelas'] ?>, '<?= $k['nama_kelas'] ?>', <?= $k['peserta_terdaftar'] ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus kelas <strong id="kelasName"></strong>?</p>

                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Peringatan Penting!
                    </h6>
                    <ul class="mb-0">
                        <li>Menghapus kelas akan mempengaruhi <strong id="pesertaCount"></strong> santri yang terdaftar</li>
                        <li>Data pendaftaran santri di kelas ini akan terpengaruh</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>

                <div class="alert alert-info">
                    <strong>Saran:</strong> Jika kelas hanya tidak aktif sementara, pertimbangkan untuk menonaktifkan kelas daripada menghapusnya.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Batal
                </button>
                <a href="#" id="deleteLink" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>
                    Ya, Hapus Kelas
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan Pengelolaan Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-lightbulb me-1"></i>
                            Tips Pengelolaan Kelas
                        </h6>
                        <ul class="small">
                            <li>Kapasitas ideal: 15-25 orang untuk pembelajaran efektif</li>
                            <li>Pastikan spesialisasi ustadz sesuai dengan program</li>
                            <li>Atur jadwal yang tidak bentrok antar kelas</li>
                            <li>Monitor kapasitas kelas secara berkala</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">
                            <i class="fas fa-chart-line me-1"></i>
                            Indikator Kapasitas
                        </h6>
                        <div class="mb-2">
                            <span class="status-indicator status-available me-2"></span>
                            <small>Hijau: Tersedia (< 70%)</small>
                        </div>
                        <div class="mb-2">
                            <span class="status-indicator status-medium me-2"></span>
                            <small>Kuning: Hampir Penuh (70-90%)</small>
                        </div>
                        <div class="mb-2">
                            <span class="status-indicator status-full me-2"></span>
                            <small>Merah: Penuh (> 90%)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Help Button -->
<button class="btn btn-info rounded-circle position-fixed"
        style="bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 1000;"
        data-bs-toggle="modal" data-bs-target="#infoModal"
        title="Bantuan">
    <i class="fas fa-question fa-lg"></i>
</button>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Form validation and enhancement
        $('#formKelas').on('submit', function(e) {
            const waktuMulai = $('input[name="waktu_mulai"]').val();
            const waktuSelesai = $('input[name="waktu_selesai"]').val();

            if (waktuMulai && waktuSelesai) {
                if (waktuMulai >= waktuSelesai) {
                    e.preventDefault();
                    alert('Waktu mulai harus lebih awal dari waktu selesai!');
                    return false;
                }
            }

            $('#btnSubmit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        });

        // Real-time form validation
        $('input[name="waktu_mulai"], input[name="waktu_selesai"]').on('change', function() {
            validateTime();
        });

        function validateTime() {
            const waktuMulai = $('input[name="waktu_mulai"]').val();
            const waktuSelesai = $('input[name="waktu_selesai"]').val();

            if (waktuMulai && waktuSelesai) {
                if (waktuMulai >= waktuSelesai) {
                    $('input[name="waktu_selesai"]').addClass('is-invalid');
                    if (!$('.time-error').length) {
                        $('input[name="waktu_selesai"]').after('<div class="invalid-feedback time-error">Waktu selesai harus lebih akhir dari waktu mulai</div>');
                    }
                } else {
                    $('input[name="waktu_selesai"]').removeClass('is-invalid');
                    $('.time-error').remove();
                }
            }
        }

        // Enhanced program selection
        $('#selectProgram').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const kategori = selectedOption.data('kategori');

            // Filter ustadz based on program type if needed
            // This can be enhanced to filter ustadz by specialization

            // Visual feedback
            if ($(this).val()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        // Enhanced ustadz selection
        $('#selectUstadz').on('change', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        // Capacity input enhancement
        $('input[name="kapasitas_maksimal"]').on('input', function() {
            const value = parseInt($(this).val());
            const $feedback = $(this).siblings('.capacity-feedback');

            if ($feedback.length === 0) {
                $(this).after('<div class="form-text capacity-feedback"></div>');
            }

            if (value > 0) {
                let message = '';
                let className = '';

                if (value <= 10) {
                    message = 'Kapasitas kecil - cocok untuk pembelajaran intensif';
                    className = 'text-info';
                } else if (value <= 20) {
                    message = 'Kapasitas ideal untuk pembelajaran efektif';
                    className = 'text-success';
                } else if (value <= 30) {
                    message = 'Kapasitas besar - pastikan ruangan memadai';
                    className = 'text-warning';
                } else {
                    message = 'Kapasitas sangat besar - pertimbangkan pembagian kelas';
                    className = 'text-danger';
                }

                $('.capacity-feedback').html(`<i class="fas fa-info-circle me-1"></i>${message}`).attr('class', `form-text capacity-feedback ${className}`);
            }
        });

        // Auto-suggest nama kelas based on program
        $('#selectProgram').on('change', function() {
            const programText = $(this).find('option:selected').text();
            const namaKelasInput = $('input[name="nama_kelas"]');

            if (programText && !namaKelasInput.val()) {
                // Extract program name without category
                const programName = programText.split(' (')[0];
                // Generate suggestion
                const suggestion = programName + ' A';
                namaKelasInput.attr('placeholder', `Saran: ${suggestion}`);
            }
        });
    });

    // View toggle functions
    function toggleView(viewType) {
        const cardView = document.getElementById('cardView');
        const tableView = document.getElementById('tableView');
        const btnCard = document.getElementById('btnCardView');
        const btnTable = document.getElementById('btnTableView');

        if (viewType === 'card') {
            cardView.style.display = 'block';
            tableView.style.display = 'none';
            btnCard.className = 'btn btn-light btn-sm';
            btnTable.className = 'btn btn-outline-light btn-sm';
        } else {
            cardView.style.display = 'none';
            tableView.style.display = 'block';
            btnCard.className = 'btn btn-outline-light btn-sm';
            btnTable.className = 'btn btn-light btn-sm';
        }

        // Save preference to localStorage
        localStorage.setItem('kelasViewType', viewType);
    }

    // Load saved view preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('kelasViewType') || 'card';
        toggleView(savedView);
    });

    // Delete confirmation function
    function confirmDelete(id, name, pesertaCount) {
        document.getElementById('kelasName').textContent = name;
        document.getElementById('pesertaCount').textContent = pesertaCount + ' santri';
        document.getElementById('deleteLink').href = `<?= base_url('data-master/kelas/delete') ?>/${id}`;

        // Change warning based on student count
        const warningAlert = document.querySelector('.alert-warning');
        if (pesertaCount > 0) {
            warningAlert.classList.remove('alert-warning');
            warningAlert.classList.add('alert-danger');
            warningAlert.querySelector('.alert-heading').innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Peringatan Kritis!';
        } else {
            warningAlert.classList.remove('alert-danger');
            warningAlert.classList.add('alert-warning');
            warningAlert.querySelector('.alert-heading').innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Peringatan Penting!';
        }

        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Enhanced search functionality
    function searchKelas() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('#cardView .col-md-6');
        const rows = document.querySelectorAll('#tableView tbody tr');

        // Search in card view
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });

        // Search in table view
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? 'table-row' : 'none';
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
            }
        }

        // Ctrl/Cmd + N for new class
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            document.querySelector('input[name="nama_kelas"]').focus();
        }
    });

    // Auto-save form data to localStorage (draft)
    const formInputs = document.querySelectorAll('#formKelas input, #formKelas select, #formKelas textarea');
    formInputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`kelas_draft_${input.name}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }

        // Save data on change
        input.addEventListener('change', function() {
            localStorage.setItem(`kelas_draft_${input.name}`, input.value);
        });
    });

    // Clear draft on successful submission
    document.getElementById('formKelas').addEventListener('submit', function() {
        setTimeout(() => {
            formInputs.forEach(input => {
                localStorage.removeItem(`kelas_draft_${input.name}`);
            });
        }, 1000);
    });

    // Tooltip initialization for better UX
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>
