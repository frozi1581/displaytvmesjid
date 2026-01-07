<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ustadz - Data Master</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .header-section {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 40px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .badge-tahsin { background-color: #e8f5e8; color: #388e3c; }
        .badge-tahfiz { background-color: #fff3cd; color: #856404; }
        .badge-keduanya { background-color: #e3f2fd; color: #1976d2; }
        .badge-relawan { background-color: #f3e5f5; color: #7b1fa2; }
        .badge-digaji { background-color: #e0f2f1; color: #00796b; }
    </style>
</head>
<body>
<section class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-3">
                    <i class="fas fa-chalkboard-teacher me-3"></i>
                    Kelola Ustadz
                </h1>
                <p class="lead mb-0">Tambah dan kelola data pengajar Tahsin & Tahfiz</p>
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
        <!-- Form Tambah Ustadz -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Ustadz Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('data-master/ustadz/store') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Ustadz *</label>
                            <input type="text" class="form-control" name="nama_ustadz"
                                   value="<?= old('nama_ustadz') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Spesialisasi *</label>
                            <select class="form-select" name="spesialisasi" required>
                                <option value="">Pilih Spesialisasi</option>
                                <option value="tahsin" <?= old('spesialisasi') == 'tahsin' ? 'selected' : '' ?>>Tahsin</option>
                                <option value="tahfiz" <?= old('spesialisasi') == 'tahfiz' ? 'selected' : '' ?>>Tahfiz</option>
                                <option value="keduanya" <?= old('spesialisasi') == 'keduanya' ? 'selected' : '' ?>>Keduanya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status *</label>
                            <select class="form-select" name="status_relawan" id="statusRelawan" required>
                                <option value="">Pilih Status</option>
                                <option value="1" <?= old('status_relawan') == '1' ? 'selected' : '' ?>>Relawan</option>
                                <option value="0" <?= old('status_relawan') == '0' ? 'selected' : '' ?>>Digaji</option>
                            </select>
                        </div>

                        <div class="mb-3" id="honorariumField" style="display: none;">
                            <label class="form-label fw-semibold">Honorarium Bulanan (Rp)</label>
                            <input type="number" class="form-control" name="honorarium_bulanan"
                                   value="<?= old('honorarium_bulanan') ?>" min="0">
                        </div>

                        <div class="mb-3" id="rekeningField" style="display: none;">
                            <label class="form-label fw-semibold">Rekening Bank</label>
                            <input type="text" class="form-control" name="rekening_bank"
                                   value="<?= old('rekening_bank') ?>" placeholder="1234567890 (BCA)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor HP</label>
                            <input type="tel" class="form-control" name="nomor_hp"
                                   value="<?= old('nomor_hp') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="<?= old('email') ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>
                            Simpan Ustadz
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Ustadz -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Ustadz (<?= count($ustadz) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($ustadz)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada ustadz</h5>
                            <p class="text-muted">Silakan tambah ustadz baru menggunakan form di sebelah kiri</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Nama & Kontak</th>
                                    <th>Spesialisasi</th>
                                    <th>Status</th>
                                    <th>Honorarium</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ustadz as $u): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $u['nama_ustadz'] ?></strong><br>
                                            <?php if ($u['nomor_hp']): ?>
                                                <small class="text-muted"><i class="fas fa-phone me-1"></i><?= $u['nomor_hp'] ?></small><br>
                                            <?php endif; ?>
                                            <?php if ($u['email']): ?>
                                                <small class="text-muted"><i class="fas fa-envelope me-1"></i><?= $u['email'] ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                                    <span class="badge badge-<?= $u['spesialisasi'] ?> px-3 py-2">
                                                        <?= ucfirst($u['spesialisasi']) ?>
                                                    </span>
                                        </td>
                                        <td>
                                                    <span class="badge badge-<?= $u['status_relawan'] ? 'relawan' : 'digaji' ?> px-3 py-2">
                                                        <?= $u['status_text'] ?>
                                                    </span>
                                        </td>
                                        <td>
                                            <?php if ($u['honorarium_bulanan'] > 0): ?>
                                                Rp <?= number_format($u['honorarium_bulanan'], 0, ',', '.') ?>
                                                <?php if ($u['rekening_bank']): ?>
                                                    <br><small class="text-muted"><?= $u['rekening_bank'] ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete(<?= $u['id_ustadz'] ?>, '<?= $u['nama_ustadz'] ?>')">
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
                <p>Apakah Anda yakin ingin menghapus ustadz <strong id="ustadzName"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan:</strong> Menghapus ustadz akan mempengaruhi kelas yang diampu!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteLink" class="btn btn-danger">Hapus Ustadz</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('statusRelawan').addEventListener('change', function() {
        const honorariumField = document.getElementById('honorariumField');
        const rekeningField = document.getElementById('rekeningField');

        if (this.value == '0') { // Digaji
            honorariumField.style.display = 'block';
            rekeningField.style.display = 'block';
        } else {
            honorariumField.style.display = 'none';
            rekeningField.style.display = 'none';
        }
    });

    function confirmDelete(id, name) {
        document.getElementById('ustadzName').textContent = name;
        document.getElementById('deleteLink').href = `<?= base_url('data-master/ustadz/delete') ?>/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
</body>
</html>
