<?php
// app/Controllers/DataMaster.php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Config;

class DataMaster extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('data_master/dashboard');
    }

    // ================ PROGRAM MANAGEMENT ================
    public function program()
    {
        $query = $this->db->query("
            SELECT * FROM program
            ORDER BY kategori_usia, nama_program
        ");
        $data['programs'] = $query->getResultArray();
        return view('data_master/program', $data);
    }

    public function storeProgram()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_program' => 'required|min_length[3]|max_length[50]',
            'deskripsi' => 'required|min_length[10]',
            'kategori_usia' => 'required|in_list[anak,dewasa,semua]',
            'target_peserta' => 'required|numeric|greater_than[0]',
            'durasi_bulan' => 'required|numeric|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kategori_usia' => $this->request->getPost('kategori_usia'),
            'target_peserta' => $this->request->getPost('target_peserta'),
            'durasi_bulan' => $this->request->getPost('durasi_bulan'),
            'status_aktif' => 1
        ];

        $this->db->table('program')->insert($data);
        return redirect()->to('/data-master/program')->with('success', 'Program berhasil ditambahkan');
    }

    public function deleteProgram($id)
    {
        $this->db->table('program')->where('id_program', $id)->delete();
        return redirect()->to('/data-master/program')->with('success', 'Program berhasil dihapus');
    }

    // ================ USTADZ MANAGEMENT ================
    public function ustadz()
    {
        $query = $this->db->query("
            SELECT *,
                CASE WHEN status_relawan = 1 THEN 'Relawan' ELSE 'Digaji' END as status_text
            FROM ustadz
            ORDER BY nama_ustadz
        ");
        $data['ustadz'] = $query->getResultArray();
        return view('data_master/ustadz', $data);
    }

    public function storeUstadz()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_ustadz' => 'required|min_length[3]|max_length[100]',
            'nomor_hp' => 'permit_empty|max_length[15]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'spesialisasi' => 'required|in_list[tahsin,tahfiz,keduanya]',
            'status_relawan' => 'required|in_list[0,1]',
            'honorarium_bulanan' => 'permit_empty|numeric',
            'rekening_bank' => 'permit_empty|max_length[50]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_ustadz' => $this->request->getPost('nama_ustadz'),
            'nomor_hp' => $this->request->getPost('nomor_hp'),
            'email' => $this->request->getPost('email'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'status_relawan' => $this->request->getPost('status_relawan'),
            'honorarium_bulanan' => $this->request->getPost('honorarium_bulanan') ?: 0,
            'rekening_bank' => $this->request->getPost('rekening_bank'),
            'status_aktif' => 1
        ];

        $this->db->table('ustadz')->insert($data);
        return redirect()->to('/data-master/ustadz')->with('success', 'Data ustadz berhasil ditambahkan');
    }

    public function deleteUstadz($id)
    {
        $this->db->table('ustadz')->where('id_ustadz', $id)->delete();
        return redirect()->to('/data-master/ustadz')->with('success', 'Data ustadz berhasil dihapus');
    }

    // ================ KELAS MANAGEMENT ================
    public function kelas()
    {
        $query = $this->db->query("
            SELECT
                k.*,
                p.nama_program,
                p.kategori_usia,
                u.nama_ustadz,
                COUNT(pen.id_pendaftaran) as peserta_terdaftar
            FROM kelas k
            LEFT JOIN program p ON k.id_program = p.id_program
            LEFT JOIN ustadz u ON k.id_ustadz = u.id_ustadz
            LEFT JOIN pendaftaran pen ON k.id_kelas = pen.id_kelas AND pen.status_pendaftaran = 'diterima'
            GROUP BY k.id_kelas
            ORDER BY p.kategori_usia, k.nama_kelas
        ");
        $data['kelas'] = $query->getResultArray();

        // Get programs for dropdown
        $query = $this->db->query("SELECT * FROM program WHERE status_aktif = 1 ORDER BY kategori_usia, nama_program");
        $data['programs'] = $query->getResultArray();

        // Get ustadz for dropdown
        $query = $this->db->query("SELECT * FROM ustadz WHERE status_aktif = 1 ORDER BY nama_ustadz");
        $data['ustadz_list'] = $query->getResultArray();

        return view('data_master/kelas', $data);
    }

    public function storeKelas()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_kelas' => 'required|min_length[3]|max_length[50]',
            'id_program' => 'required|numeric',
            'id_ustadz' => 'required|numeric',
            'kapasitas_maksimal' => 'required|numeric|greater_than[0]',
            'hari_belajar' => 'required|max_length[50]',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'ruangan' => 'required|max_length[30]',
            'biaya_operasional_bulanan' => 'permit_empty|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_program' => $this->request->getPost('id_program'),
            'id_ustadz' => $this->request->getPost('id_ustadz'),
            'kapasitas_maksimal' => $this->request->getPost('kapasitas_maksimal'),
            'hari_belajar' => $this->request->getPost('hari_belajar'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan' => $this->request->getPost('ruangan'),
            'biaya_operasional_bulanan' => $this->request->getPost('biaya_operasional_bulanan') ?: 0,
            'status_aktif' => 1
        ];

        $this->db->table('kelas')->insert($data);
        return redirect()->to('/data-master/kelas')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function deleteKelas($id)
    {
        $this->db->table('kelas')->where('id_kelas', $id)->delete();
        return redirect()->to('/data-master/kelas')->with('success', 'Kelas berhasil dihapus');
    }

    // ================ DONATUR MANAGEMENT ================
    public function donatur()
    {
        $query = $this->db->query("
            SELECT
                d.*,
                COUNT(don.id_donasi) as total_donasi_count,
                COALESCE(SUM(don.jumlah_donasi), 0) as total_nominal_donasi,
                MAX(don.tanggal_donasi) as donasi_terakhir
            FROM donatur d
            LEFT JOIN donasi don ON d.id_donatur = don.id_donatur AND don.status_verifikasi = 'verified'
            GROUP BY d.id_donatur
            ORDER BY d.jenis_komitmen, d.nama_donatur
        ");
        $data['donatur'] = $query->getResultArray();
        return view('data_master/donatur', $data);
    }

    public function storeDonatur()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_donatur' => 'required|min_length[3]|max_length[100]',
            'jenis_donatur' => 'required|in_list[individu,perusahaan,yayasan,komunitas]',
            'nomor_hp' => 'permit_empty|max_length[15]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'jenis_komitmen' => 'required|in_list[tetap,tidak_tetap,insidentil]',
            'nominal_komitmen' => 'permit_empty|numeric',
            'periode_donasi' => 'required|in_list[bulanan,triwulan,semester,tahunan,tidak_tetap]',
            'rekening_bank' => 'permit_empty|max_length[50]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_donatur' => $this->request->getPost('nama_donatur'),
            'jenis_donatur' => $this->request->getPost('jenis_donatur'),
            'nomor_hp' => $this->request->getPost('nomor_hp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'jenis_komitmen' => $this->request->getPost('jenis_komitmen'),
            'nominal_komitmen' => $this->request->getPost('nominal_komitmen') ?: 0,
            'periode_donasi' => $this->request->getPost('periode_donasi'),
            'rekening_bank' => $this->request->getPost('rekening_bank'),
            'catatan' => $this->request->getPost('catatan'),
            'status_aktif' => 1
        ];

        $this->db->table('donatur')->insert($data);
        return redirect()->to('/data-master/donatur')->with('success', 'Data donatur berhasil ditambahkan');
    }

    public function deleteDonatur($id)
    {
        $this->db->table('donatur')->where('id_donatur', $id)->delete();
        return redirect()->to('/data-master/donatur')->with('success', 'Data donatur berhasil dihapus');
    }

    // ================ LOKASI TROMOL MANAGEMENT ================
    public function lokasiTromol()
    {
        $query = $this->db->query("
            SELECT
                lt.*,
                COUNT(d.id_donasi) as jumlah_pengambilan,
                COALESCE(SUM(d.jumlah_donasi), 0) as total_donasi_terkumpul,
                MAX(d.tanggal_donasi) as pengambilan_terakhir
            FROM lokasi_tromol lt
            LEFT JOIN donasi d ON d.jenis_donasi = 'tromol'
                AND d.keterangan LIKE CONCAT('%', lt.nama_lokasi, '%')
                AND d.status_verifikasi = 'verified'
            GROUP BY lt.id_lokasi
            ORDER BY lt.nama_lokasi
        ");
        $data['lokasi_tromol'] = $query->getResultArray();
        return view('data_master/lokasi_tromol', $data);
    }

    public function storeLokasiTromol()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_lokasi' => 'required|min_length[3]|max_length[100]',
            'alamat_lengkap' => 'required|min_length[10]',
            'pic_lokasi' => 'required|min_length[3]|max_length[100]',
            'nomor_hp_pic' => 'required|max_length[15]',
            'jadwal_pengambilan' => 'required|max_length[100]',
            'estimasi_donasi_bulanan' => 'permit_empty|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
            'pic_lokasi' => $this->request->getPost('pic_lokasi'),
            'nomor_hp_pic' => $this->request->getPost('nomor_hp_pic'),
            'jadwal_pengambilan' => $this->request->getPost('jadwal_pengambilan'),
            'estimasi_donasi_bulanan' => $this->request->getPost('estimasi_donasi_bulanan') ?: 0,
            'catatan' => $this->request->getPost('catatan'),
            'status_aktif' => 1
        ];

        $this->db->table('lokasi_tromol')->insert($data);
        return redirect()->to('/data-master/lokasi-tromol')->with('success', 'Lokasi tromol berhasil ditambahkan');
    }

    public function deleteLokasiTromol($id)
    {
        $this->db->table('lokasi_tromol')->where('id_lokasi', $id)->delete();
        return redirect()->to('/data-master/lokasi-tromol')->with('success', 'Lokasi tromol berhasil dihapus');
    }

    // ================ AJAX HELPERS ================
    public function getUstadzBySpesialisasi()
    {
        $spesialisasi = $this->request->getPost('spesialisasi');

        $query = $this->db->query("
            SELECT id_ustadz, nama_ustadz
            FROM ustadz
            WHERE status_aktif = 1
            AND (spesialisasi = ? OR spesialisasi = 'keduanya')
            ORDER BY nama_ustadz
        ", [$spesialisasi]);

        return $this->response->setJSON($query->getResultArray());
    }
}
