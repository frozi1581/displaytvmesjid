<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Program - Data Master</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .header-section {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 40px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #f8f9fa;
            border: none;
            font-weight: 600;
        }
        .badge-anak { background-color: #e3f2fd; color: #1976d2; }
        .badge-dewasa { background-color: #f3e5f5; color: #7b1fa2; }
        .badge-semua { background-color: #e8f5e8; color: #388e3c; }
    </style>
</head>
<body>
<section class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-3">
                    <i class="fas fa-book-quran me-3"></i>
                    Kelola Program
                </h1>
                <p class="lead mb-0">Tambah, edit, dan kelola program Tahsin & Tahfiz</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?= base_url('data-master') ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Form Tambah Program -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Program Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('data-master/program/store') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Program *</label>
                            <input type="text" class="form-control" name="nama_program"
                                   value="<?= old('nama_program') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori Usia *</label>
                            <select class="form-select" name="kategori_usia" required>
                                <option value="">Pilih Kategori</option>
                                <option value="anak" <?= old('kategori_usia') == 'anak' ? 'selected' : '' ?>>Anak</option>
                                <option value="dewasa" <?= old('kategori_usia') == 'dewasa' ? 'selected' : '' ?>>Dewasa</option>
                                <option value="semua" <?= old('kategori_usia') == 'semua' ? 'selected' : '' ?>>Semua Usia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Peserta *</label>
                            <input type="number" class="form-control" name="target_peserta"
                                   value="<?= old('target_peserta') ?>" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Durasi (Bulan) *</label>
                            <input type="number" class="form-control" name="durasi_bulan"
                                   value="<?= old('durasi_bulan') ?>" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi *</label>
                            <textarea class="form-control" name="deskripsi" rows="3" required><?= old('deskripsi') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-2"></i>
                            Simpan Program
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Program -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Program (<?= count($programs) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($programs)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada program</h5>
                            <p class="text-muted">Silakan tambah program baru menggunakan form di sebelah kiri</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Kategori</th>
                                    <th>Target</th>
                                    <th>Durasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($programs as $program): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $program['nama_program'] ?></strong><br>
                                            <small class="text-muted"><?= $program['deskripsi'] ?></small>
                                        </td>
                                        <td>
                                                    <span class="badge badge-<?= $program['kategori_usia'] ?> px-3 py-2">
                                                        <?= ucfirst($program['kategori_usia']) ?>
                                                    </span>
                                        </td>
                                        <td><?= $program['target_peserta'] ?> orang</td>
                                        <td><?= $program['durasi_bulan'] ?> bulan</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete(<?= $program['id_program'] ?>, '<?= $program['nama_program'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
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
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus program <strong id="programName"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan:</strong> Menghapus program akan menghapus semua data terkait termasuk kelas dan pendaftaran!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteLink" class="btn btn-danger">Hapus Program</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id, name) {
        document.getElementById('programName').textContent = name;
        document.getElementById('deleteLink').href = `<?= base_url('data-master/program/delete') ?>/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
</body>
</html>
