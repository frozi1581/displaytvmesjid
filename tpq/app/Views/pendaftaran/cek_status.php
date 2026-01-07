<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pendaftaran - Santri Tahsin & Tahfiz</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .check-section {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 80px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .check-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .check-header {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .check-icon {
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
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 15px 20px;
            font-size: 16px;
        }
        .form-control:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            font-weight: 600;
        }
    </style>
</head>
<body>
<section class="check-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="check-card">
                    <div class="check-header">
                        <div class="check-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h1 class="mb-3">Cek Status Pendaftaran</h1>
                        <p class="lead mb-0">Masukkan nomor pendaftaran atau nomor induk santri</p>
                    </div>

                    <div class="p-4">
                        <?php if (session('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= session('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('pendaftaran/status') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nomor Pendaftaran</label>
                                <input type="text" class="form-control" name="nomor_pendaftaran"
                                       placeholder="Contoh: REG2024001" value="<?= old('nomor_pendaftaran') ?>">
                                <div class="form-text">Format: REG + Tahun + Nomor urut</div>
                            </div>

                            <div class="text-center mb-3">
                                <small class="text-muted">ATAU</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nomor Induk Santri</label>
                                <input type="text" class="form-control" name="nomor_induk"
                                       placeholder="Contoh: SNT001" value="<?= old('nomor_induk') ?>">
                                <div class="form-text">Format: SNT + Nomor urut</div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-search me-2"></i>
                                    Cek Status
                                </button>
                                <a href="<?= base_url('pendaftaran') ?>" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
