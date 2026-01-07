<?php
// app/Controllers/Pendaftaran.php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Config;

class Pendaftaran extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil data program yang aktif
        $query = $this->db->query("
            SELECT id_program, nama_program, deskripsi, kategori_usia, target_peserta, durasi_bulan
            FROM program
            WHERE status_aktif = 1
            ORDER BY kategori_usia, nama_program
        ");
        $data['programs'] = $query->getResultArray();

        // Ambil data kelas yang tersedia
        $query = $this->db->query("
            SELECT
                k.id_kelas,
                k.nama_kelas,
                k.hari_belajar,
                k.waktu_mulai,
                k.waktu_selesai,
                k.ruangan,
                k.kapasitas_maksimal,
                p.nama_program,
                p.kategori_usia,
                u.nama_ustadz,
                COUNT(pen.id_pendaftaran) as peserta_terdaftar
            FROM kelas k
            LEFT JOIN program p ON k.id_program = p.id_program
            LEFT JOIN ustadz u ON k.id_ustadz = u.id_ustadz
            LEFT JOIN pendaftaran pen ON k.id_kelas = pen.id_kelas AND pen.status_pendaftaran = 'diterima'
            WHERE k.status_aktif = 1 AND p.status_aktif = 1
            GROUP BY k.id_kelas
            HAVING peserta_terdaftar < k.kapasitas_maksimal
            ORDER BY p.kategori_usia, k.nama_kelas
        ");
        $data['kelas'] = $query->getResultArray();

        return view('pendaftaran/form', $data);
    }

    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'nama_panggilan' => 'required|min_length[2]|max_length[50]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[50]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required|min_length[10]',
            'nomor_hp' => 'permit_empty|max_length[15]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'nama_wali' => 'required|min_length[3]|max_length[100]',
            'nomor_hp_wali' => 'required|max_length[15]',
            'pekerjaan_wali' => 'required|max_length[100]',
            'kondisi_ekonomi' => 'required|in_list[mampu,kurang_mampu,tidak_mampu]',
            'id_program' => 'required|numeric',
            'id_kelas' => 'required|numeric',
            'motivasi_mengikuti' => 'required|min_length[10]',
            'rekomendasi_dari' => 'permit_empty|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Mulai transaksi database
        $this->db->transStart();

        try {
            // Generate nomor induk santri
            $query = $this->db->query("CALL GenerateNomorInduk(@nomor_induk)");
            $result = $this->db->query("SELECT @nomor_induk as nomor_induk")->getRow();
            $nomor_induk = $result->nomor_induk;

            // Tentukan kategori usia berdasarkan tanggal lahir
            $tanggal_lahir = $this->request->getPost('tanggal_lahir');
            $umur = date_diff(date_create($tanggal_lahir), date_create('now'))->y;
            $kategori_usia = ($umur < 18) ? 'anak' : 'dewasa';

            // Insert data santri
            $santri_data = [
                'nomor_induk' => $nomor_induk,
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'nama_panggilan' => $this->request->getPost('nama_panggilan'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $tanggal_lahir,
                'kategori_usia' => $kategori_usia,
                'alamat' => $this->request->getPost('alamat'),
                'nomor_hp' => $this->request->getPost('nomor_hp'),
                'email' => $this->request->getPost('email'),
                'nama_wali' => $this->request->getPost('nama_wali'),
                'nomor_hp_wali' => $this->request->getPost('nomor_hp_wali'),
                'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
                'kondisi_ekonomi' => $this->request->getPost('kondisi_ekonomi'),
                'keterangan_khusus' => $this->request->getPost('keterangan_khusus'),
                'status_aktif' => 1
            ];

            $this->db->table('santri')->insert($santri_data);
            $id_santri = $this->db->insertID();

            // Generate nomor pendaftaran
            $query = $this->db->query("CALL GenerateNomorPendaftaran(@nomor_pendaftaran)");
            $result = $this->db->query("SELECT @nomor_pendaftaran as nomor_pendaftaran")->getRow();
            $nomor_pendaftaran = $result->nomor_pendaftaran;

            // Insert data pendaftaran
            $pendaftaran_data = [
                'nomor_pendaftaran' => $nomor_pendaftaran,
                'id_santri' => $id_santri,
                'id_program' => $this->request->getPost('id_program'),
                'id_kelas' => $this->request->getPost('id_kelas'),
                'tanggal_daftar' => date('Y-m-d'),
                'status_pendaftaran' => 'pending',
                'motivasi_mengikuti' => $this->request->getPost('motivasi_mengikuti'),
                'rekomendasi_dari' => $this->request->getPost('rekomendasi_dari'),
                'catatan' => 'Pendaftaran melalui form online'
            ];

            $this->db->table('pendaftaran')->insert($pendaftaran_data);

            $this->db->transComplete();

            if ($this->db->transStatus() === FALSE) {
                throw new \Exception('Gagal menyimpan data pendaftaran');
            }

            // Redirect ke halaman sukses dengan nomor pendaftaran
            return redirect()->to('/pendaftaran/sukses/' . $nomor_pendaftaran);

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function sukses($nomor_pendaftaran = null)
    {
        if (!$nomor_pendaftaran) {
            return redirect()->to('/pendaftaran');
        }

        // Ambil data pendaftaran
        $query = $this->db->query("
            SELECT
                pen.nomor_pendaftaran,
                pen.tanggal_daftar,
                pen.status_pendaftaran,
                s.nama_lengkap,
                s.nomor_induk,
                s.jenis_kelamin,
                s.kategori_usia,
                p.nama_program,
                k.nama_kelas,
                k.hari_belajar,
                k.waktu_mulai,
                k.waktu_selesai,
                k.ruangan,
                u.nama_ustadz
            FROM pendaftaran pen
            JOIN santri s ON pen.id_santri = s.id_santri
            JOIN program p ON pen.id_program = p.id_program
            LEFT JOIN kelas k ON pen.id_kelas = k.id_kelas
            LEFT JOIN ustadz u ON k.id_ustadz = u.id_ustadz
            WHERE pen.nomor_pendaftaran = ?
        ", [$nomor_pendaftaran]);

        $data['pendaftaran'] = $query->getRowArray();

        if (!$data['pendaftaran']) {
            return redirect()->to('/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan');
        }

        return view('pendaftaran/sukses', $data);
    }

    public function getKelasbyProgram()
    {
        $id_program = $this->request->getPost('id_program');

        $query = $this->db->query("
            SELECT
                k.id_kelas,
                k.nama_kelas,
                k.hari_belajar,
                k.waktu_mulai,
                k.waktu_selesai,
                k.ruangan,
                k.kapasitas_maksimal,
                u.nama_ustadz,
                COUNT(pen.id_pendaftaran) as peserta_terdaftar,
                (k.kapasitas_maksimal - COUNT(pen.id_pendaftaran)) as sisa_kapasitas
            FROM kelas k
            LEFT JOIN ustadz u ON k.id_ustadz = u.id_ustadz
            LEFT JOIN pendaftaran pen ON k.id_kelas = pen.id_kelas AND pen.status_pendaftaran = 'diterima'
            WHERE k.id_program = ? AND k.status_aktif = 1
            GROUP BY k.id_kelas
            HAVING peserta_terdaftar < k.kapasitas_maksimal
            ORDER BY k.nama_kelas
        ", [$id_program]);

        $kelas = $query->getResultArray();

        return $this->response->setJSON($kelas);
    }

    public function cekStatus()
    {
        return view('pendaftaran/cek_status');
    }

    public function status()
    {
        $nomor_pendaftaran = $this->request->getPost('nomor_pendaftaran');
        $nomor_induk = $this->request->getPost('nomor_induk');

        if (!$nomor_pendaftaran && !$nomor_induk) {
            return redirect()->back()->with('error', 'Masukkan nomor pendaftaran atau nomor induk');
        }

        $where = '';
        $params = [];

        if ($nomor_pendaftaran) {
            $where = "pen.nomor_pendaftaran = ?";
            $params[] = $nomor_pendaftaran;
        } else {
            $where = "s.nomor_induk = ?";
            $params[] = $nomor_induk;
        }

        $query = $this->db->query("
            SELECT
                pen.nomor_pendaftaran,
                pen.tanggal_daftar,
                pen.status_pendaftaran,
                pen.tanggal_mulai_belajar,
                s.nama_lengkap,
                s.nomor_induk,
                s.jenis_kelamin,
                s.kategori_usia,
                p.nama_program,
                k.nama_kelas,
                k.hari_belajar,
                k.waktu_mulai,
                k.waktu_selesai,
                k.ruangan,
                u.nama_ustadz,
                CASE
                    WHEN pen.status_pendaftaran = 'pending' THEN 'Menunggu Verifikasi'
                    WHEN pen.status_pendaftaran = 'diterima' THEN 'Diterima'
                    WHEN pen.status_pendaftaran = 'ditolak' THEN 'Ditolak'
                    WHEN pen.status_pendaftaran = 'waiting_list' THEN 'Daftar Tunggu'
                    ELSE 'Status Tidak Dikenal'
                END as status_text
            FROM pendaftaran pen
            JOIN santri s ON pen.id_santri = s.id_santri
            JOIN program p ON pen.id_program = p.id_program
            LEFT JOIN kelas k ON pen.id_kelas = k.id_kelas
            LEFT JOIN ustadz u ON k.id_ustadz = u.id_ustadz
            WHERE $where
        ", $params);

        $data['pendaftaran'] = $query->getRowArray();

        if (!$data['pendaftaran']) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }

        return view('pendaftaran/detail_status', $data);
    }
}
