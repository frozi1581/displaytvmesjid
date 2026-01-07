<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Santri Tahsin & Tahfiz</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .form-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-outline-primary {
            border: 2px solid #667eea;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .required {
            color: #dc3545;
        }
        .program-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 10px 0;
            border-radius: 0 10px 10px 0;
        }
        .kelas-info {
            background: #f3e5f5;
            border-left: 4px solid #9c27b0;
            padding: 15px;
            margin: 10px 0;
            border-radius: 0 10px 10px 0;
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px;
        }
    </style>
</head>
<body>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fas fa-mosque me-3"></i>
                    Pendaftaran Santri Tahsin & Tahfiz TPQ Masjid Jami An-Nur
                </h1>
                <p class="lead mb-4">
                    Program pembelajaran Al-Quran GRATIS untuk anak dan dewasa.
                    Bergabunglah bersama kami dalam mendalami bacaan dan hafalan Al-Quran.
                </p>
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <div class="feature-icon">
                            <i class="fas fa-book-quran"></i>
                        </div>
                        <h6>Program Gratis</h6>
                        <p class="small">Tanpa biaya pendaftaran</p>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h6>Ustadz Berpengalaman</h6>
                        <p class="small">Dibimbing pengajar ahli</p>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h6>Kelas Terbatas</h6>
                        <p class="small">Pembelajaran efektif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <img src="https://via.placeholder.com/300x300/ffffff/667eea?text=Al-Quran" class="img-fluid rounded-circle" alt="Al-Quran">
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <?php if (session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= session('error') ?>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Form Pendaftaran Santri
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">Silakan lengkapi data diri untuk mendaftar program tahsin dan tahfiz</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= base_url('pendaftaran/store') ?>" method="POST" id="formPendaftaran">
                            <?= csrf_field() ?>

                            <!-- Data Pribadi Santri -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Data Pribadi Santri
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Lengkap <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="nama_lengkap"
                                           value="<?= old('nama_lengkap') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Panggilan <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="nama_panggilan"
                                           value="<?= old('nama_panggilan') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Jenis Kelamin <span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Tempat Lahir <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="tempat_lahir"
                                           value="<?= old('tempat_lahir') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Tanggal Lahir <span class="required">*</span>
                                    </label>
                                    <input type="date" class="form-control" name="tanggal_lahir"
                                           value="<?= old('tanggal_lahir') ?>" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-semibold">
                                        Alamat Lengkap <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                                </div>
                               <!-- <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Kondisi Ekonomi <span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="kondisi_ekonomi" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="mampu" <?= old('kondisi_ekonomi') == 'mampu' ? 'selected' : '' ?>>Mampu</option>
                                        <option value="kurang_mampu" <?= old('kondisi_ekonomi') == 'kurang_mampu' ? 'selected' : '' ?>>Kurang Mampu</option>
                                        <option value="tidak_mampu" <?= old('kondisi_ekonomi') == 'tidak_mampu' ? 'selected' : '' ?>>Tidak Mampu</option>
                                    </select>
                                </div>-->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nomor HP Santri</label>
                                    <input type="tel" class="form-control" name="nomor_hp"
                                           value="<?= old('nomor_hp') ?>" placeholder="Untuk santri dewasa">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Email Santri</label>
                                    <input type="email" class="form-control" name="email"
                                           value="<?= old('email') ?>" placeholder="Untuk santri dewasa">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Keterangan Khusus</label>
                                    <textarea class="form-control" name="keterangan_khusus" rows="2"
                                              placeholder="Kondisi kesehatan, alergi, atau informasi penting lainnya"><?= old('keterangan_khusus') ?></textarea>
                                </div>
                            </div>

                            <!-- Data Wali -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        Data Wali/Orang Tua
                                    </h5>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Wali <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="nama_wali"
                                           value="<?= old('nama_wali') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nomor HP Wali <span class="required">*</span>
                                    </label>
                                    <input type="tel" class="form-control" name="nomor_hp_wali"
                                           value="<?= old('nomor_hp_wali') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        Pekerjaan Wali <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="pekerjaan_wali"
                                           value="<?= old('pekerjaan_wali') ?>" required>
                                </div>
                            </div>

                            <!-- Pilihan Program -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-book-quran text-primary me-2"></i>
                                        Pilihan Program & Kelas
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Program <span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="id_program" id="selectProgram" required>
                                        <option value="">Pilih Program</option>
                                        <?php foreach ($programs as $program): ?>
                                            <option value="<?= $program['id_program'] ?>"
                                                    data-kategori="<?= $program['kategori_usia'] ?>"
                                                    data-deskripsi="<?= $program['deskripsi'] ?>"
                                                    data-durasi="<?= $program['durasi_bulan'] ?>"
                                                <?= old('id_program') == $program['id_program'] ? 'selected' : '' ?>>
                                                <?= $program['nama_program'] ?> (<?= ucfirst($program['kategori_usia']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="programInfo" class="program-info" style="display: none;">
                                        <h6 class="mb-2">Informasi Program:</h6>
                                        <p id="programDeskripsi" class="mb-1"></p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Durasi: <span id="programDurasi"></span> bulan
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Kelas <span class="required">*</span>
                                    </label>
                                    <select class="form-select" name="id_kelas" id="selectKelas" required>
                                        <option value="">Pilih program terlebih dahulu</option>
                                    </select>
                                    <div id="kelasInfo" class="kelas-info" style="display: none;">
                                        <h6 class="mb-2">Informasi Kelas:</h6>
                                        <p id="kelasDetail" class="mb-1"></p>
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1"></i>
                                            Ustadz: <span id="kelasUstadz"></span><br>
                                            <i class="fas fa-users me-1"></i>
                                            Sisa kapasitas: <span id="kelasKapasitas"></span> orang
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Motivasi dan Rekomendasi -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-heart text-primary me-2"></i>
                                        Motivasi & Rekomendasi
                                    </h5>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-semibold">
                                        Motivasi Mengikuti Program <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" name="motivasi_mengikuti" rows="3"
                                              placeholder="Ceritakan alasan dan tujuan Anda mengikuti program ini..." required><?= old('motivasi_mengikuti') ?></textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Rekomendasi Dari</label>
                                    <input type="text" class="form-control" name="rekomendasi_dari"
                                           value="<?= old('rekomendasi_dari') ?>"
                                           placeholder="Ustadz, teman, keluarga, dll">
                                    <div class="form-text">Kosongkan jika tidak ada</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-3" id="btnSubmit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Daftar Sekarang
                                </button>
                                <a href="<?= base_url('pendaftaran/cek-status') ?>" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-search me-2"></i>
                                    Cek Status Pendaftaran
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle program selection
        $('#selectProgram').change(function() {
            const selectedOption = $(this).find('option:selected');
            const programId = $(this).val();

            if (programId) {
                // Show program info
                const deskripsi = selectedOption.data('deskripsi');
                const durasi = selectedOption.data('durasi');

                $('#programDeskripsi').text(deskripsi);
                $('#programDurasi').text(durasi);
                $('#programInfo').slideDown();

                // Load kelas for selected program
                loadKelas(programId);
            } else {
                $('#programInfo').slideUp();
                resetKelas();
            }
        });

        // Handle kelas selection
        $('#selectKelas').change(function() {
            const selectedOption = $(this).find('option:selected');

            if ($(this).val()) {
                const hari = selectedOption.data('hari');
                const waktu = selectedOption.data('waktu');
                const ruangan = selectedOption.data('ruangan');
                const ustadz = selectedOption.data('ustadz');
                const kapasitas = selectedOption.data('kapasitas');

                $('#kelasDetail').html(`<strong>Jadwal:</strong> ${hari}<br><strong>Waktu:</strong> ${waktu}<br><strong>Ruangan:</strong> ${ruangan}`);
                $('#kelasUstadz').text(ustadz);
                $('#kelasKapasitas').text(kapasitas);
                $('#kelasInfo').slideDown();
            } else {
                $('#kelasInfo').slideUp();
            }
        });

        // Form submission
        $('#formPendaftaran').submit(function(e) {
            $('#btnSubmit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');
        });

        function loadKelas(programId) {
            $.ajax({
                url: '<?= base_url('pendaftaran/getKelasbyProgram') ?>',
                type: 'POST',
                data: {
                    id_program: programId,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(data) {
                    let options = '<option value="">Pilih Kelas</option>';

                    if (data.length > 0) {
                        $.each(data, function(index, kelas) {
                            const waktu = kelas.waktu_mulai + ' - ' + kelas.waktu_selesai;
                            options += `<option value="${kelas.id_kelas}"
                                                   data-hari="${kelas.hari_belajar}"
                                                   data-waktu="${waktu}"
                                                   data-ruangan="${kelas.ruangan}"
                                                   data-ustadz="${kelas.nama_ustadz}"
                                                   data-kapasitas="${kelas.sisa_kapasitas}">
                                               ${kelas.nama_kelas} - ${kelas.hari_belajar} (${waktu})
                                            </option>`;
                        });
                    } else {
                        options += '<option value="">Tidak ada kelas tersedia</option>';
                    }

                    $('#selectKelas').html(options);
                },
                error: function() {
                    $('#selectKelas').html('<option value="">Error loading kelas</option>');
                }
            });
        }

        function resetKelas() {
            $('#selectKelas').html('<option value="">Pilih program terlebih dahulu</option>');
            $('#kelasInfo').slideUp();
        }
    });
</script>
</body>
</html>
