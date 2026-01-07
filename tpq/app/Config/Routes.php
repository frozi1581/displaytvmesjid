<?php
// ================================================================
// app/Config/Routes.php - Routes Lengkap
// ================================================================

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Pendaftaran::index');

// ================================================================
// PENDAFTARAN SANTRI ROUTES
// ================================================================

$routes->group('', function($routes) {
    // Halaman utama pendaftaran
    $routes->get('pendaftaran', 'Pendaftaran::index');
    $routes->post('pendaftaran/store', 'Pendaftaran::store');

    // Halaman sukses pendaftaran
    $routes->get('pendaftaran/sukses/(:segment)', 'Pendaftaran::sukses/$1');

    // Cek status pendaftaran
    $routes->get('pendaftaran/cek-status', 'Pendaftaran::cekStatus');
    $routes->post('pendaftaran/status', 'Pendaftaran::status');

    // AJAX endpoints untuk pendaftaran
    $routes->post('pendaftaran/getKelasbyProgram', 'Pendaftaran::getKelasbyProgram');
    $routes->post('pendaftaran/checkAvailability', 'Pendaftaran::checkAvailability');

    // Alternative routes untuk kemudahan akses
    $routes->get('daftar', 'Pendaftaran::index');
    $routes->get('register', 'Pendaftaran::index');
    $routes->get('status', 'Pendaftaran::cekStatus');
});

// ================================================================
// DATA MASTER ROUTES
// ================================================================

$routes->group('data-master', function($routes) {
    // Dashboard data master
    $routes->get('/', 'DataMaster::index');
    $routes->get('dashboard', 'DataMaster::index');

    // ============================================================
    // PROGRAM ROUTES
    // ============================================================
    $routes->group('program', function($routes) {
        $routes->get('/', 'DataMaster::program');
        $routes->get('list', 'DataMaster::program');
        $routes->post('store', 'DataMaster::storeProgram');
        $routes->post('create', 'DataMaster::storeProgram'); // Alternative
        $routes->get('delete/(:num)', 'DataMaster::deleteProgram/$1');
        $routes->post('delete/(:num)', 'DataMaster::deleteProgram/$1'); // For AJAX
        $routes->get('edit/(:num)', 'DataMaster::editProgram/$1'); // Future: edit form
        $routes->post('update/(:num)', 'DataMaster::updateProgram/$1'); // Future: update
        $routes->get('view/(:num)', 'DataMaster::viewProgram/$1'); // Future: detail view
        $routes->post('toggle-status/(:num)', 'DataMaster::toggleProgramStatus/$1'); // Future: activate/deactivate
    });

    // ============================================================
    // USTADZ ROUTES
    // ============================================================
    $routes->group('ustadz', function($routes) {
        $routes->get('/', 'DataMaster::ustadz');
        $routes->get('list', 'DataMaster::ustadz');
        $routes->post('store', 'DataMaster::storeUstadz');
        $routes->post('create', 'DataMaster::storeUstadz'); // Alternative
        $routes->get('delete/(:num)', 'DataMaster::deleteUstadz/$1');
        $routes->post('delete/(:num)', 'DataMaster::deleteUstadz/$1'); // For AJAX
        $routes->get('edit/(:num)', 'DataMaster::editUstadz/$1'); // Future: edit form
        $routes->post('update/(:num)', 'DataMaster::updateUstadz/$1'); // Future: update
        $routes->get('view/(:num)', 'DataMaster::viewUstadz/$1'); // Future: detail view
        $routes->get('profile/(:num)', 'DataMaster::ustadzProfile/$1'); // Future: profile page
        $routes->post('toggle-status/(:num)', 'DataMaster::toggleUstadzStatus/$1'); // Future: activate/deactivate
    });

    // ============================================================
    // KELAS ROUTES
    // ============================================================
    $routes->group('kelas', function($routes) {
        $routes->get('/', 'DataMaster::kelas');
        $routes->get('list', 'DataMaster::kelas');
        $routes->post('store', 'DataMaster::storeKelas');
        $routes->post('create', 'DataMaster::storeKelas'); // Alternative
        $routes->get('delete/(:num)', 'DataMaster::deleteKelas/$1');
        $routes->post('delete/(:num)', 'DataMaster::deleteKelas/$1'); // For AJAX
        $routes->get('edit/(:num)', 'DataMaster::editKelas/$1'); // Future: edit form
        $routes->post('update/(:num)', 'DataMaster::updateKelas/$1'); // Future: update
        $routes->get('view/(:num)', 'DataMaster::viewKelas/$1'); // Future: detail view
        $routes->get('schedule', 'DataMaster::kelasSchedule'); // Future: schedule view
        $routes->get('capacity-report', 'DataMaster::capacityReport'); // Future: capacity report
        $routes->post('toggle-status/(:num)', 'DataMaster::toggleKelasStatus/$1'); // Future: activate/deactivate
    });

    // ============================================================
    // DONATUR ROUTES
    // ============================================================
    $routes->group('donatur', function($routes) {
        $routes->get('/', 'DataMaster::donatur');
        $routes->get('list', 'DataMaster::donatur');
        $routes->post('store', 'DataMaster::storeDonatur');
        $routes->post('create', 'DataMaster::storeDonatur'); // Alternative
        $routes->get('delete/(:num)', 'DataMaster::deleteDonatur/$1');
        $routes->post('delete/(:num)', 'DataMaster::deleteDonatur/$1'); // For AJAX
        $routes->get('edit/(:num)', 'DataMaster::editDonatur/$1'); // Future: edit form
        $routes->post('update/(:num)', 'DataMaster::updateDonatur/$1'); // Future: update
        $routes->get('view/(:num)', 'DataMaster::viewDonatur/$1'); // Future: detail view
        $routes->get('tetap', 'DataMaster::donaturTetap'); // Future: regular donors only
        $routes->get('tidak-tetap', 'DataMaster::donaturTidakTetap'); // Future: irregular donors
        $routes->get('report', 'DataMaster::donaturReport'); // Future: donor report
        $routes->post('toggle-status/(:num)', 'DataMaster::toggleDonaturStatus/$1'); // Future: activate/deactivate
    });

    // ============================================================
    // LOKASI TROMOL ROUTES
    // ============================================================
    $routes->group('lokasi-tromol', function($routes) {
        $routes->get('/', 'DataMaster::lokasiTromol');
        $routes->get('list', 'DataMaster::lokasiTromol');
        $routes->post('store', 'DataMaster::storeLokasiTromol');
        $routes->post('create', 'DataMaster::storeLokasiTromol'); // Alternative
        $routes->get('delete/(:num)', 'DataMaster::deleteLokasiTromol/$1');
        $routes->post('delete/(:num)', 'DataMaster::deleteLokasiTromol/$1'); // For AJAX
        $routes->get('edit/(:num)', 'DataMaster::editLokasiTromol/$1'); // Future: edit form
        $routes->post('update/(:num)', 'DataMaster::updateLokasiTromol/$1'); // Future: update
        $routes->get('view/(:num)', 'DataMaster::viewLokasiTromol/$1'); // Future: detail view
        $routes->get('map', 'DataMaster::tromolMap'); // Future: map view
        $routes->get('performance', 'DataMaster::tromolPerformance'); // Future: performance report
        $routes->post('toggle-status/(:num)', 'DataMaster::toggleTromolStatus/$1'); // Future: activate/deactivate
    });

    // ============================================================
    // AJAX ENDPOINTS UNTUK DATA MASTER
    // ============================================================
    $routes->post('getUstadzBySpesialisasi', 'DataMaster::getUstadzBySpesialisasi');
    $routes->post('getKelasByProgram', 'DataMaster::getKelasByProgram');
    $routes->post('getProgramByKategori', 'DataMaster::getProgramByKategori');
    $routes->post('checkKelasCapacity', 'DataMaster::checkKelasCapacity');
    $routes->post('validateJadwal', 'DataMaster::validateJadwal');
    $routes->post('searchData', 'DataMaster::searchData');

    // ============================================================
    // BULK OPERATIONS (Future)
    // ============================================================
    $routes->post('bulk-delete', 'DataMaster::bulkDelete');
    $routes->post('bulk-update-status', 'DataMaster::bulkUpdateStatus');
    $routes->post('bulk-export', 'DataMaster::bulkExport');
    $routes->post('bulk-import', 'DataMaster::bulkImport');
});

// Alternative shorter routes for data master
$routes->group('master', function($routes) {
    $routes->get('/', 'DataMaster::index');
    $routes->get('program', 'DataMaster::program');
    $routes->get('ustadz', 'DataMaster::ustadz');
    $routes->get('kelas', 'DataMaster::kelas');
    $routes->get('donatur', 'DataMaster::donatur');
    $routes->get('tromol', 'DataMaster::lokasiTromol');
});

// ================================================================
// KEUANGAN ROUTES (Future Implementation)
// ================================================================

$routes->group('keuangan', function($routes) {
    // Dashboard keuangan
    $routes->get('/', 'Keuangan::index');
    $routes->get('dashboard', 'Keuangan::index');

    // ============================================================
    // DONASI ROUTES
    // ============================================================
    $routes->group('donasi', function($routes) {
        $routes->get('/', 'Keuangan::donasi');
        $routes->get('list', 'Keuangan::donasi');
        $routes->post('store', 'Keuangan::storeDonasi');
        $routes->get('delete/(:num)', 'Keuangan::deleteDonasi/$1');
        $routes->post('verify/(:num)', 'Keuangan::verifyDonasi/$1');
        $routes->post('reject/(:num)', 'Keuangan::rejectDonasi/$1');
        $routes->get('tromol', 'Keuangan::donasiTromol');
        $routes->get('transfer', 'Keuangan::donasiTransfer');
        $routes->get('report', 'Keuangan::donasiReport');
    });

    // ============================================================
    // PENGELUARAN ROUTES
    // ============================================================
    $routes->group('pengeluaran', function($routes) {
        $routes->get('/', 'Keuangan::pengeluaran');
        $routes->get('list', 'Keuangan::pengeluaran');
        $routes->post('store', 'Keuangan::storePengeluaran');
        $routes->get('delete/(:num)', 'Keuangan::deletePengeluaran/$1');
        $routes->post('approve/(:num)', 'Keuangan::approvePengeluaran/$1');
        $routes->post('reject/(:num)', 'Keuangan::rejectPengeluaran/$1');
        $routes->get('honorarium', 'Keuangan::pengeluaranHonorarium');
        $routes->get('operasional', 'Keuangan::pengeluaranOperasional');
        $routes->get('report', 'Keuangan::pengeluaranReport');
    });

    // ============================================================
    // LAPORAN KEUANGAN ROUTES
    // ============================================================
    $routes->group('laporan', function($routes) {
        $routes->get('/', 'Keuangan::laporan');
        $routes->get('bulanan', 'Keuangan::laporanBulanan');
        $routes->get('tahunan', 'Keuangan::laporanTahunan');
        $routes->get('kas', 'Keuangan::laporanKas');
        $routes->get('donatur', 'Keuangan::laporanDonatur');
        $routes->get('tromol', 'Keuangan::laporanTromol');
        $routes->post('generate', 'Keuangan::generateLaporan');
        $routes->get('export/(:segment)', 'Keuangan::exportLaporan/$1');
    });
});

// ================================================================
// ABSENSI ROUTES (Future Implementation)
// ================================================================

$routes->group('absensi', function($routes) {
    // Dashboard absensi
    $routes->get('/', 'Absensi::index');
    $routes->get('dashboard', 'Absensi::index');

    // Input absensi
    $routes->get('input', 'Absensi::input');
    $routes->post('store', 'Absensi::store');
    $routes->get('kelas/(:num)', 'Absensi::byKelas/$1');
    $routes->get('santri/(:num)', 'Absensi::bySantri/$1');

    // Laporan absensi
    $routes->get('report', 'Absensi::report');
    $routes->get('report/kelas/(:num)', 'Absensi::reportKelas/$1');
    $routes->get('report/santri/(:num)', 'Absensi::reportSantri/$1');
    $routes->post('export', 'Absensi::export');

    // AJAX endpoints
    $routes->post('getSantriByKelas', 'Absensi::getSantriByKelas');
    $routes->post('updateAbsensi', 'Absensi::updateAbsensi');
});

// ================================================================
// SANTRI MANAGEMENT ROUTES (Future Implementation)
// ================================================================

$routes->group('santri', function($routes) {
    // Dashboard santri
    $routes->get('/', 'Santri::index');
    $routes->get('dashboard', 'Santri::index');
    $routes->get('list', 'Santri::list');

    // CRUD santri
    $routes->get('add', 'Santri::add');
    $routes->post('store', 'Santri::store');
    $routes->get('edit/(:num)', 'Santri::edit/$1');
    $routes->post('update/(:num)', 'Santri::update/$1');
    $routes->get('delete/(:num)', 'Santri::delete/$1');
    $routes->get('view/(:num)', 'Santri::view/$1');

    // Profile santri
    $routes->get('profile/(:num)', 'Santri::profile/$1');
    $routes->post('update-profile/(:num)', 'Santri::updateProfile/$1');
    $routes->post('upload-photo/(:num)', 'Santri::uploadPhoto/$1');

    // Filter dan pencarian
    $routes->get('kategori/(:segment)', 'Santri::byKategori/$1');
    $routes->get('kelas/(:num)', 'Santri::byKelas/$1');
    $routes->get('program/(:num)', 'Santri::byProgram/$1');
    $routes->post('search', 'Santri::search');

    // Export dan import
    $routes->get('export', 'Santri::export');
    $routes->post('import', 'Santri::import');
    $routes->get('template', 'Santri::downloadTemplate');
});

// ================================================================
// API ROUTES (Future Implementation)
// ================================================================

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    // Authentication
    $routes->post('login', 'Auth::login');
    $routes->post('logout', 'Auth::logout');
    $routes->post('refresh', 'Auth::refresh');

    // Protected routes
    $routes->group('v1', ['filter' => 'auth'], function($routes) {
        // Santri API
        $routes->resource('santri', ['controller' => 'Santri']);
        $routes->resource('pendaftaran', ['controller' => 'Pendaftaran']);

        // Master data API
        $routes->resource('program', ['controller' => 'Program']);
        $routes->resource('ustadz', ['controller' => 'Ustadz']);
        $routes->resource('kelas', ['controller' => 'Kelas']);
        $routes->resource('donatur', ['controller' => 'Donatur']);

        // Keuangan API
        $routes->resource('donasi', ['controller' => 'Donasi']);
        $routes->resource('pengeluaran', ['controller' => 'Pengeluaran']);

        // Absensi API
        $routes->resource('absensi', ['controller' => 'Absensi']);

        // Statistics API
        $routes->get('stats/dashboard', 'Statistics::dashboard');
        $routes->get('stats/santri', 'Statistics::santri');
        $routes->get('stats/keuangan', 'Statistics::keuangan');
        $routes->get('stats/absensi', 'Statistics::absensi');
    });
});

// ================================================================
// ADMIN ROUTES (Future Implementation)
// ================================================================

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Admin dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::index');

    // User management
    $routes->group('users', function($routes) {
        $routes->get('/', 'Admin::users');
        $routes->post('store', 'Admin::storeUser');
        $routes->get('delete/(:num)', 'Admin::deleteUser/$1');
        $routes->post('update-role/(:num)', 'Admin::updateUserRole/$1');
        $routes->post('toggle-status/(:num)', 'Admin::toggleUserStatus/$1');
    });

    // System settings
    $routes->group('settings', function($routes) {
        $routes->get('/', 'Admin::settings');
        $routes->post('update', 'Admin::updateSettings');
        $routes->post('backup', 'Admin::backup');
        $routes->post('restore', 'Admin::restore');
        $routes->get('logs', 'Admin::logs');
    });

    // Reports
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Admin::reports');
        $routes->get('santri', 'Admin::reportSantri');
        $routes->get('keuangan', 'Admin::reportKeuangan');
        $routes->get('activity', 'Admin::reportActivity');
        $routes->post('generate', 'Admin::generateReport');
    });
});

// ================================================================
// UTILITY ROUTES
// ================================================================

// File uploads
$routes->post('upload/photo', 'Upload::photo');
$routes->post('upload/document', 'Upload::document');
$routes->post('upload/bukti', 'Upload::buktiTransfer');

// File downloads
$routes->get('download/template/(:segment)', 'Download::template/$1');
$routes->get('download/report/(:segment)', 'Download::report/$1');
$routes->get('download/backup/(:segment)', 'Download::backup/$1');

// Notifications (Future)
$routes->group('notifications', function($routes) {
    $routes->get('/', 'Notifications::index');
    $routes->post('mark-read/(:num)', 'Notifications::markRead/$1');
    $routes->post('mark-all-read', 'Notifications::markAllRead');
    $routes->get('count', 'Notifications::count');
});

// ================================================================
// HELP & DOCUMENTATION ROUTES
// ================================================================

$routes->group('help', function($routes) {
    $routes->get('/', 'Help::index');
    $routes->get('panduan', 'Help::panduan');
    $routes->get('faq', 'Help::faq');
    $routes->get('contact', 'Help::contact');
    $routes->post('feedback', 'Help::feedback');
});

// ================================================================
// PUBLIC INFORMATION ROUTES
// ================================================================

$routes->group('info', function($routes) {
    $routes->get('/', 'Info::index');
    $routes->get('program', 'Info::program');
    $routes->get('jadwal', 'Info::jadwal');
    $routes->get('pengumuman', 'Info::pengumuman');
    $routes->get('kontak', 'Info::kontak');
});

// ================================================================
// MAINTENANCE & ERROR ROUTES
// ================================================================

// Maintenance mode
$routes->get('maintenance', 'Maintenance::index');

// Error pages
$routes->get('404', function() {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});

$routes->get('500', function() {
    throw new \Exception('Test 500 Error');
});

// ================================================================
// REDIRECTS & ALIASES
// ================================================================

// Common redirects
$routes->addRedirect('home', '/');
$routes->addRedirect('beranda', '/');
$routes->addRedirect('main', '/');

// Legacy support
$routes->addRedirect('old-registration', 'pendaftaran');
$routes->addRedirect('old-status', 'pendaftaran/cek-status');

// ================================================================
// CLI ROUTES (Command Line Interface)
// ================================================================

$routes->cli('migrate', 'Migrate::index');
$routes->cli('seed', 'Seed::index');
$routes->cli('backup', 'Backup::create');
$routes->cli('restore', 'Backup::restore');
$routes->cli('clear-cache', 'Cache::clear');
$routes->cli('generate-report', 'Reports::generate');

// ================================================================
// WEBHOOK ROUTES (Future for integrations)
// ================================================================

$routes->group('webhook', function($routes) {
    $routes->post('payment/notification', 'Webhook::paymentNotification');
    $routes->post('whatsapp/message', 'Webhook::whatsappMessage');
    $routes->post('telegram/update', 'Webhook::telegramUpdate');
});

// ================================================================
// CUSTOM ERROR PAGES
// ================================================================

$routes->set404Override('App\Controllers\Errors::show404');

// ================================================================
// ROUTE OPTIONS
// ================================================================

// Global route options
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Pendaftaran');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Disable auto routing for security

/*
 * ================================================================
 * SUMMARY ROUTES YANG AKTIF SAAT INI:
 * ================================================================
 *
 * PENDAFTARAN SANTRI:
 * - GET  /                              -> Pendaftaran::index
 * - GET  /pendaftaran                   -> Pendaftaran::index
 * - POST /pendaftaran/store             -> Pendaftaran::store
 * - GET  /pendaftaran/sukses/{nomor}    -> Pendaftaran::sukses
 * - GET  /pendaftaran/cek-status        -> Pendaftaran::cekStatus
 * - POST /pendaftaran/status            -> Pendaftaran::status
 * - POST /pendaftaran/getKelasbyProgram -> Pendaftaran::getKelasbyProgram
 *
 * DATA MASTER:
 * - GET  /data-master                   -> DataMaster::index
 * - GET  /data-master/program           -> DataMaster::program
 * - POST /data-master/program/store     -> DataMaster::storeProgram
 * - GET  /data-master/program/delete/{id} -> DataMaster::deleteProgram
 * - GET  /data-master/ustadz            -> DataMaster::ustadz
 * - POST /data-master/ustadz/store      -> DataMaster::storeUstadz
 * - GET  /data-master/ustadz/delete/{id} -> DataMaster::deleteUstadz
 * - GET  /data-master/kelas             -> DataMaster::kelas
 * - POST /data-master/kelas/store       -> DataMaster::storeKelas
 * - GET  /data-master/kelas/delete/{id} -> DataMaster::deleteKelas
 * - GET  /data-master/donatur           -> DataMaster::donatur
 * - POST /data-master/donatur/store     -> DataMaster::storeDonatur
 * - GET  /data-master/donatur/delete/{id} -> DataMaster::deleteDonatur
 * - GET  /data-master/lokasi-tromol     -> DataMaster::lokasiTromol
 * - POST /data-master/lokasi-tromol/store -> DataMaster::storeLokasiTromol
 * - GET  /data-master/lokasi-tromol/delete/{id} -> DataMaster::deleteLokasiTromol
 * - POST /data-master/getUstadzBySpesialisasi -> DataMaster::getUstadzBySpesialisasi
 *
 * ================================================================
 * ROUTES UNTUK PENGEMBANGAN SELANJUTNYA:
 * ================================================================
 *
 * 1. KEUANGAN MODULE:
 *    - Input donasi masuk (tromol, transfer, tunai)
 *    - Input pengeluaran (honorarium, operasional)
 *    - Laporan keuangan (bulanan, tahunan)
 *    - Verifikasi dan approval transaksi
 *
 * 2. ABSENSI MODULE:
 *    - Input absensi per kelas
 *    - Laporan kehadiran santri
 *    - Monitoring progress pembelajaran
 *
 * 3. SANTRI MANAGEMENT:
 *    - Profile lengkap santri
 *    - Progress pembelajaran
 *    - Komunikasi dengan wali
 *
 * 4. API ENDPOINTS:
 *    - RESTful API untuk mobile app
 *    - Integration dengan sistem lain
 *    - Webhook untuk notifikasi
 *
 * 5. ADMIN & USER MANAGEMENT:
 *    - Role-based access control
 *    - User permissions
 *    - Activity logging
 *
 * 6. REPORTING & ANALYTICS:
 *    - Dashboard analytics
 *    - Export ke various formats
 *    - Automated reports
 *
 * ================================================================
 */
