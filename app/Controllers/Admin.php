<?php

namespace App\Controllers;

use App\Libraries\MockData;

class Admin extends BaseController
{
    protected array $commonData;

    public function __construct()
    {
        $activeTa = session()->get('tahun_ajaran_aktif_override') ?? '2025/2026';
        $activeSem = session()->get('semester_aktif_override') ?? 'Ganjil';

        $this->commonData = [
            'role' => 'admin',
            'sekolah' => MockData::getSekolah(),
            'tahunAjaranList' => MockData::getTahunAjaran(),
            'taAktif' => $activeTa . ' - ' . $activeSem . ' (Aktif)',
            'sistemState' => MockData::getSistemState(),
        ];
    }

    public function index()
    {
        return $this->dashboard();
    }

    // 1. Dashboard Admin
    public function dashboard()
    {
        $activeTa = session()->get('tahun_ajaran_aktif_override') ?? '2025/2026';
        $activeSem = session()->get('semester_aktif_override') ?? 'Ganjil';

        $data = array_merge($this->commonData, [
            'title' => 'Dashboard Admin',
            'menu' => 'dashboard',
            'submenu' => '',
            'stats' => [
                'total_siswa' => 177,
                'total_guru' => 24,
                'total_kelas' => 7,
                'ta_status' => $activeTa . ' ' . $activeSem . ' (Aktif)'
            ],
            'ta_list' => MockData::getTahunAjaran(),
            'tingkatan_list' => MockData::getTingkatan(),
            'unlockRequestsPending' => MockData::getSistemState()['unlock_requests_pending'] ?? [],
        ]);

        return view('admin/dashboard', $data);
    }

    // 2. Data Sekolah
    public function sekolah()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Data Sekolah',
            'menu' => 'sekolah',
            'submenu' => '',
            'sekolahData' => MockData::getSekolah()
        ]);

        return view('admin/sekolah', $data);
    }

    // 3. Tahun Ajaran & Semester - List
    public function tahunAjaran()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Tahun Ajaran & Semester',
            'menu' => 'master_akademik',
            'submenu' => 'tahun_ajaran',
            'tahunAjaran' => MockData::getTahunAjaran()
        ]);

        return view('admin/tahun_ajaran/index', $data);
    }

    // 4-9. Setup Tahun Ajaran 6 Langkah
    public function wizard($step = 1)
    {
        $step = max(1, min(6, (int)$step));

        $plenoList = MockData::getStatusPlenoRombel();
        $isSemuaPlenoSelesai = MockData::isSemuaPlenoSelesai();
        $belumPleno = array_values(array_filter($plenoList, fn($p) => $p['status_pleno'] !== 'selesai'));

        // Proteksi Server-Side: Blokir akses ke step berikutnya jika pleno belum 100% selesai
        if ($step > 1 && !$isSemuaPlenoSelesai) {
            return redirect()->to(base_url('admin/wizard/1'))
                ->with('error', 'Validasi Kunci Urutan Sistem: Tidak dapat melanjutkan wizard tahun ajaran baru sebelum seluruh rombel menyelesaikan Sidang Pleno Kenaikan Kelas.');
        }

        $data = array_merge($this->commonData, [
            'title' => 'Setup Tahun Ajaran Baru: Langkah ' . $step . ' dari 6',
            'menu' => 'master_akademik',
            'submenu' => 'tahun_ajaran',
            'currentStep' => $step,
            'tingkatan' => MockData::getTingkatan(),
            'guru' => MockData::getGuru(),
            'kelas' => MockData::getKelas(),
            'mapel' => MockData::getMapel(),
            'siswaList' => MockData::getSiswaList(),
            'plenoList' => $plenoList,
            'isSemuaPlenoSelesai' => $isSemuaPlenoSelesai,
            'belumPleno' => $belumPleno,
            'kenaikanList' => MockData::getKenaikanKelasList(),
            'riwayatKelasList' => MockData::getSiswaRiwayatKelas(),
        ]);

        return view('admin/tahun_ajaran/wizard_step_' . $step, $data);
    }

    // Aktivasi Semester Genap
    public function aktivasiSemesterGenap()
    {
        $sistemState = MockData::getSistemState();
        $unlockPending = $sistemState['unlock_requests_pending'] ?? [];

        $data = array_merge($this->commonData, [
            'title' => 'Aktivasi Semester Genap 2025/2026',
            'menu' => 'master_akademik',
            'submenu' => 'tahun_ajaran',
            'taAktif' => '2025/2026',
            'kelasList' => MockData::getKelas(),
            'unlockPendingCount' => count($unlockPending),
            'raportGanjilFinalCount' => 7,
            'totalKelas' => 7,
            'pengecualianGuru' => [
                ['nama' => 'Ustadz Budi Rahardjo, S.Si.', 'mapel' => 'Fisika XI-MIPA-1', 'status' => 'Cuti Belajar', 'rekomendasi' => 'Perlu penunjukan guru pengganti sebelum semester genap dimulai']
            ],
            'pengecualianSiswa' => [
                ['nama' => 'Aditya Pratama', 'nis' => '232410050', 'kelas_asal' => 'XI-MIPA-2', 'status' => 'Pindah Keluar (Mutasi)', 'keterangan' => 'Mutasi keluar per 10 Januari 2025 ke SMA Negeri 3 Bandung. Tidak dialokasikan ke semester genap.']
            ],
        ]);

        return view('admin/tahun_ajaran/aktivasi_semester_genap', $data);
    }

    public function doAktivasiSemesterGenap()
    {
        session()->set('semester_aktif_override', 'Genap');
        return redirect()->to('/admin/tahun-ajaran')->with('success', 'Semester Genap 2025/2026 berhasil diaktifkan. Penugasan guru dari semester ganjil telah disalin dengan penyesuaian pengecualian mutasi.');
    }

    // 10. Tingkatan Kelas
    public function tingkatan()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Tingkatan Kelas',
            'menu' => 'master_akademik',
            'submenu' => 'tingkatan',
            'tingkatanList' => MockData::getTingkatan()
        ]);

        return view('admin/master/tingkatan', $data);
    }

    // 11. Jurusan
    public function jurusan()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Jurusan',
            'menu' => 'master_akademik',
            'submenu' => 'jurusan',
            'jurusanList' => MockData::getJurusan()
        ]);

        return view('admin/master/jurusan', $data);
    }

    // 12-14. Mata Pelajaran & Kelompok Mapel
    public function mapel($selectedKelompokId = 1)
    {
        $kelompokList = MockData::getKelompokMapel();
        $allMapel = MockData::getMapel();

        $selectedKelompok = null;
        foreach ($kelompokList as $k) {
            if ($k['id'] == $selectedKelompokId) {
                $selectedKelompok = $k;
                break;
            }
        }
        if (!$selectedKelompok) {
            $selectedKelompok = $kelompokList[0];
            $selectedKelompokId = $selectedKelompok['id'];
        }

        $filteredMapel = array_filter($allMapel, function ($m) use ($selectedKelompokId) {
            return $m['kelompok_mapel_id'] == $selectedKelompokId;
        });

        $data = array_merge($this->commonData, [
            'title' => 'Mata Pelajaran & Kelompok Mapel',
            'menu' => 'master_akademik',
            'submenu' => 'mapel',
            'kelompokList' => $kelompokList,
            'selectedKelompok' => $selectedKelompok,
            'mapelList' => array_values($filteredMapel),
            'jurusanList' => MockData::getJurusan()
        ]);

        return view('admin/master/mapel', $data);
    }

    // 15-16. Komponen Nilai & Bobot
    public function komponenNilai($aspek = 'pengetahuan')
    {
        $allKomponen = MockData::getKomponenNilai();
        $aspek = ($aspek === 'keterampilan') ? 'keterampilan' : 'pengetahuan';

        $data = array_merge($this->commonData, [
            'title' => 'Komponen Nilai & Bobot',
            'menu' => 'master_penilaian',
            'submenu' => 'komponen_nilai',
            'activeAspek' => $aspek,
            'komponenList' => $allKomponen[$aspek] ?? [],
        ]);

        return view('admin/master/komponen_nilai', $data);
    }

    // 17. KKM & Interval Predikat
    public function kriteriaPenilaian()
    {
        $data = array_merge($this->commonData, [
            'title' => 'KKM & Interval Predikat',
            'menu' => 'master_penilaian',
            'submenu' => 'kriteria_penilaian',
            'kriteriaList' => MockData::getKriteriaPenilaian()
        ]);

        return view('admin/master/kriteria_penilaian', $data);
    }

    // 18. Jenis Sikap
    public function masterSikap()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Master Penilaian - Jenis Sikap',
            'menu' => 'master_penilaian',
            'submenu' => 'sikap_ekskul_prestasi',
            'activeTab' => 'sikap',
            'sikapList' => MockData::getJenisSikap()
        ]);

        return view('admin/master/sikap', $data);
    }

    // 19. Jenis Ekstrakurikuler
    public function masterEkskul()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Master Penilaian - Ekstrakurikuler',
            'menu' => 'master_penilaian',
            'submenu' => 'sikap_ekskul_prestasi',
            'activeTab' => 'ekskul',
            'ekskulList' => MockData::getJenisEkstrakurikuler()
        ]);

        return view('admin/master/ekskul', $data);
    }

    // 20. Jenis Prestasi
    public function masterPrestasi()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Master Penilaian - Jenis Prestasi',
            'menu' => 'master_penilaian',
            'submenu' => 'sikap_ekskul_prestasi',
            'activeTab' => 'prestasi',
            'prestasiList' => MockData::getJenisPrestasi()
        ]);

        return view('admin/master/prestasi', $data);
    }

    // 21. Kelola Kelas - List
    public function kelas()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Kelola Kelas',
            'menu' => 'kelas_penugasan',
            'submenu' => 'kelas',
            'kelasList' => MockData::getKelas(),
            'tingkatan' => MockData::getTingkatan(),
            'jurusan' => MockData::getJurusan(),
            'guru' => MockData::getGuru()
        ]);

        return view('admin/kelas/index', $data);
    }

    // 22. Form Buka Kelas Baru
    public function bukaKelas()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Buka Kelas Baru',
            'menu' => 'kelas_penugasan',
            'submenu' => 'kelas',
            'tingkatan' => MockData::getTingkatan(),
            'jurusan' => MockData::getJurusan(),
            'guru' => MockData::getGuru()
        ]);

        return view('admin/kelas/form_buka_kelas', $data);
    }

    // 23. Detail Kelas - Kelola Siswa
    public function detailKelas($id = 4)
    {
        $allKelas = MockData::getKelas();
        $kelas = $allKelas[3]; // XI-MIPA-1
        foreach ($allKelas as $k) {
            if ($k['id'] == $id) {
                $kelas = $k;
                break;
            }
        }

        $allSiswa = MockData::getSiswaList();
        $siswaInKelas = array_filter($allSiswa, fn($s) => $s['kelas_id'] == $kelas['id']);

        $data = array_merge($this->commonData, [
            'title' => 'Detail Kelas: ' . $kelas['nama_kelas'],
            'menu' => 'kelas_penugasan',
            'submenu' => 'kelas',
            'kelas' => $kelas,
            'siswaInKelas' => array_values($siswaInKelas),
            'siswaUnassigned' => array_values(array_filter($allSiswa, fn($s) => $s['kelas_id'] === null))
        ]);

        return view('admin/kelas/detail', $data);
    }

    // 24-25. Penugasan Guru Mengajar
    public function penugasan()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Penugasan Guru Mengajar',
            'menu' => 'kelas_penugasan',
            'submenu' => 'penugasan',
            'penugasanList' => MockData::getPengajaran(),
            'guruList' => MockData::getGuru(),
            'mapelList' => MockData::getMapel(),
            'kelasList' => MockData::getKelas(),
            'taList' => MockData::getTahunAjaran(),
            'kriteriaList' => MockData::getKriteriaPenilaian(),
        ]);

        return view('admin/penugasan/index', $data);
    }

    // 26. Data Guru - List
    public function guru()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Data Guru',
            'menu' => 'data_pengguna',
            'submenu' => 'guru',
            'guruList' => MockData::getGuru()
        ]);

        return view('admin/pengguna/guru_index', $data);
    }

    // 27. Form Tambah / Edit Guru
    public function guruForm($id = null)
    {
        $guruData = null;
        if ($id) {
            $list = MockData::getGuru();
            foreach ($list as $g) {
                if ($g['id'] == $id) {
                    $guruData = $g;
                    break;
                }
            }
        }

        $data = array_merge($this->commonData, [
            'title' => $id ? 'Edit Data Guru' : 'Tambah Data Guru Baru',
            'menu' => 'data_pengguna',
            'submenu' => 'guru',
            'guru' => $guruData
        ]);

        return view('admin/pengguna/guru_form', $data);
    }

    // 28. Data Siswa - List
    public function siswa()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Data Siswa',
            'menu' => 'data_pengguna',
            'submenu' => 'siswa',
            'siswaList' => MockData::getSiswaList(),
            'kelasList' => MockData::getKelas()
        ]);

        return view('admin/pengguna/siswa_index', $data);
    }

    // 29. Form Tambah / Edit Siswa
    public function siswaForm($id = null)
    {
        $siswaData = null;
        if ($id) {
            $list = MockData::getSiswaList();
            foreach ($list as $s) {
                if ($s['id'] == $id) {
                    $siswaData = $s;
                    break;
                }
            }
        }

        $data = array_merge($this->commonData, [
            'title' => $id ? 'Edit Data Siswa' : 'Tambah Data Siswa Baru',
            'menu' => 'data_pengguna',
            'submenu' => 'siswa',
            'siswa' => $siswaData,
            'kelasList' => MockData::getKelas()
        ]);

        return view('admin/pengguna/siswa_form', $data);
    }

    // 30-34. Detail Siswa (5 Tabs)
    public function siswaDetail($id = 1, $tab = 'biodata')
    {
        $list = MockData::getSiswaList();
        $siswa = $list[0];
        foreach ($list as $s) {
            if ($s['id'] == $id) {
                $siswa = $s;
                break;
            }
        }

        $raport = MockData::getRaportSiswa($id);

        $data = array_merge($this->commonData, [
            'title' => 'Detail Siswa: ' . $siswa['nama'],
            'menu' => 'data_pengguna',
            'submenu' => 'siswa',
            'siswa' => $siswa,
            'activeTab' => $tab,
            'raport' => $raport,
            'riwayatKelas' => MockData::getRiwayatKelasBySiswa($id),
            'arsip' => MockData::getArsipData()
        ]);

        return view('admin/pengguna/siswa_detail', $data);
    }

    // 35. Data Orang Tua / Wali - List
    public function orangTua()
    {
        $siswaList = MockData::getSiswaList();
        $ortuList = [];
        foreach ($siswaList as $s) {
            if (!empty($s['ortu'])) {
                foreach ($s['ortu'] as $o) {
                    $ortuList[] = [
                        'nama' => $o['nama'],
                        'jenis' => ucfirst($o['jenis']),
                        'anak' => $s['nama'],
                        'nis' => $s['nis'],
                        'kelas' => $s['kelas_nama'],
                        'telepon' => $o['telepon'],
                        'pekerjaan' => $o['pekerjaan'],
                        'alamat' => $o['alamat']
                    ];
                }
            }
        }

        $data = array_merge($this->commonData, [
            'title' => 'Data Orang Tua / Wali Siswa',
            'menu' => 'data_pengguna',
            'submenu' => 'ortu',
            'ortuList' => $ortuList
        ]);

        return view('admin/pengguna/ortu_index', $data);
    }

    // 36. Akun Staff TU
    public function staffTu()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Akun & Data Staff TU',
            'menu' => 'data_pengguna',
            'submenu' => 'staff_tu',
            'staffList' => MockData::getStaffTu()
        ]);

        return view('admin/pengguna/staff_tu', $data);
    }

    // 37. Manajemen Raport - Buka Kunci Raport Final & Audit Trail
    public function bukaKunciRaport()
    {
        $siswaList = MockData::getSiswaList();

        $lockedRaportList = [];
        foreach ($siswaList as $s) {
            $sId = $s['id'];
            $st = session()->get('raport_status_' . $sId);
            if ($st !== 'draft') {
                $lockedRaportList[] = [
                    'id' => $sId,
                    'nama_siswa' => $s['nama'],
                    'nis' => $s['nis'],
                    'kelas' => $s['kelas'] ?? 'XI-MIPA-1',
                    'semester' => 'Ganjil 2025/2026',
                    'finalized_at' => '2025-12-19 10:30',
                    'finalized_by' => 'Ustadz Hendra Gunawan, M.Pd.',
                ];
            }
        }

        $data = array_merge($this->commonData, [
            'title' => 'Buka Kunci Raport Final & Audit Trail',
            'menu' => 'raport',
            'submenu' => 'buka_kunci',
            'unlockRequestsPending' => MockData::getUnlockRequests(),
            'lockedRaportList' => $lockedRaportList,
            'logPerubahanNilai' => session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai(),
        ]);

        return view('admin/raport/buka_kunci', $data);
    }

    // Ujian Sekolah & Formula Nilai Akhir Kelulusan Kelas 12
    public function ujianSekolah()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Ujian Sekolah & Formula Kelulusan (Kelas 12)',
            'menu' => 'master_penilaian',
            'submenu' => 'ujian_sekolah',
            'formula' => MockData::getFormulaKelulusan(),
            'ujianData' => MockData::getUjianSekolahData(),
        ]);

        return view('admin/ujian_sekolah/index', $data);
    }

    // Cetak Transkrip Nilai Kumulatif 6 Semester Siswa
    public function transkripSiswa($id = 1)
    {
        $transkrip = MockData::getTranskripLengkapSiswa($id);

        $data = array_merge($this->commonData, [
            'title' => 'Transkrip Nilai Kumulatif: ' . $transkrip['siswa']['nama'],
            'menu' => 'data_pengguna',
            'submenu' => 'siswa',
            'transkrip' => $transkrip,
        ]);

        return view('admin/pengguna/transkrip_cetak', $data);
    }

    // 38. Modul Surat - Kategori Surat
    public function kategoriSurat()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Kategori Surat',
            'menu' => 'modul_surat',
            'submenu' => 'kategori_surat',
            'kategoriList' => MockData::getKategoriSurat()
        ]);

        return view('admin/surat/kategori', $data);
    }

    // 39. Modul Surat - Format Penomoran Surat
    public function formatNomorSurat()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Format Penomoran Surat',
            'menu' => 'modul_surat',
            'submenu' => 'format_surat',
            'formatList' => MockData::getFormatNomorSurat()
        ]);

        return view('admin/surat/format_nomor', $data);
    }

    // 40-46. Modul Arsip (7 Tabs)
    public function arsip($tab = 'alumni')
    {
        $validTabs = ['alumni', 'kenaikan', 'raport', 'mutasi', 'dokumen', 'penugasan', 'surat'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'alumni';
        }

        $data = array_merge($this->commonData, [
            'title' => 'Modul Arsip Terpadu',
            'menu' => 'arsip',
            'submenu' => $tab,
            'activeTab' => $tab,
            'arsip' => MockData::getArsipData(),
            'suratMasuk' => MockData::getSuratMasuk(),
            'suratKeluar' => MockData::getSuratKeluar()
        ]);

        return view('admin/arsip/index', $data);
    }

    // Generic form submit handler for UI prototype demo
    public function saveAction()
    {
        $action = $this->request->getPost('action') ?? 'Data';
        $redirectUrl = $this->request->getPost('redirect_url') ?? '/admin';

        if ($action === 'Mutasi Siswa') {
            $siswaId = $this->request->getPost('siswa_id');
            $jenis = $this->request->getPost('jenis_mutasi');
            $sekolah = $this->request->getPost('sekolah_terkait');
            $tanggal = $this->request->getPost('tanggal_mutasi');
            $alasan = $this->request->getPost('alasan');

            $riwayatOverrides = session()->get('siswa_riwayat_kelas_overrides') ?? [];
            $riwayatOverrides[$siswaId] = [
                'status_siswa' => ($jenis === 'keluar') ? 'Pindah Keluar' : 'Aktif',
                'catatan' => 'Mutasi ' . $jenis . ' (' . $sekolah . ') tgl ' . $tanggal . '. Alasan: ' . $alasan
            ];
            session()->set('siswa_riwayat_kelas_overrides', $riwayatOverrides);

            return redirect()->to($redirectUrl)->with('success', 'Mutasi siswa berhasil diproses dan langsung dicatat ke tabel siswa_riwayat_kelas.');
        }

        // 1. Simpan Draft Tahun Ajaran Baru (tanpa mengaktifkan)
        if ($this->request->getPost('as_draft') || stripos($action, 'Draft Tahun Ajaran') !== false) {
            $taNama = '2026/2027';
            if (preg_match('/(\d{4}\/\d{4})/', $action, $m)) {
                $taNama = $m[1];
            }
            return redirect()->to($redirectUrl)->with('success', 'Konfigurasi Tahun Ajaran ' . $taNama . ' berhasil disimpan sebagai Draft Persiapan (belum diaktifkan).');
        }

        // 2. Aktivasi Tahun Ajaran Baru (dari Wizard Step 6 atau tabel Tahun Ajaran)
        if (stripos($action, 'Aktivasi Tahun Ajaran') !== false) {
            $taNama = '2026/2027';
            if (preg_match('/(\d{4}\/\d{4})/', $action, $m)) {
                $taNama = $m[1];
            }
            session()->set('tahun_ajaran_aktif_override', $taNama);
            session()->set('semester_aktif_override', 'Ganjil');

            return redirect()->to($redirectUrl)->with('success', 'Tahun Ajaran ' . $taNama . ' (Semester Ganjil) berhasil diaktifkan sebagai periode akademik berjalan.');
        }

        // 3. Aktivasi Semester Genap
        if (stripos($action, 'Semester Genap') !== false) {
            session()->set('semester_aktif_override', 'Genap');
            return redirect()->to($redirectUrl)->with('success', 'Semester Genap berhasil diaktifkan sebagai semester akademik berjalan.');
        }

        // 3. Persetujuan / Penolakan Buka Kunci Raport di Admin
        if (stripos($action, 'buka kunci raport') !== false || $this->request->getPost('unlock_decision')) {
            $decision = $this->request->getPost('unlock_decision') ?? 'approve';
            $siswaId = (int)($this->request->getPost('siswa_id') ?? 1);
            $reqId = $this->request->getPost('request_id');
            $alasanRevisi = $this->request->getPost('alasan_revisi');
            $alasanPenolakan = $this->request->getPost('alasan_penolakan') ?? 'Permohonan buka kunci belum memenuhi syarat kelayakan revisi.';

            // Lookup student info
            $siswaList = MockData::getSiswaList();
            $targetSiswa = null;
            foreach ($siswaList as $s) {
                if ($s['id'] == $siswaId) {
                    $targetSiswa = $s;
                    break;
                }
            }
            if (!$targetSiswa) {
                $targetSiswa = [
                    'id' => $siswaId,
                    'nama' => 'Muhammad Raihan Pratama',
                    'nis' => '242510001',
                    'kelas' => 'XI-MIPA-1'
                ];
            }

            // Hapus / filter dari antrean pending unlock requests
            $pendingList = MockData::getUnlockRequests();
            $removedReq = null;
            $newPendingList = [];
            foreach ($pendingList as $p) {
                $pSiswaId = $p['siswa_id'] ?? $p['id'] ?? 0;
                $isMatch = ($reqId && ($p['id'] ?? null) == $reqId) || $pSiswaId == $siswaId || ($p['siswa_nis'] ?? '') === ($targetSiswa['nis'] ?? '');
                if ($isMatch) {
                    $removedReq = $p;
                } else {
                    $newPendingList[] = $p;
                }
            }
            session()->set('unlock_requests_pending', $newPendingList);

            if ($decision === 'reject' || stripos($action, 'ditolak') !== false) {
                session()->set('raport_catatan_penolakan_' . $siswaId, $alasanPenolakan);
                return redirect()->to($redirectUrl)->with('warning', 'Permohonan buka kunci raport siswa ' . $targetSiswa['nama'] . ' telah ditolak.');
            } else {
                session()->set('raport_status_' . $siswaId, 'draft');
                session()->remove('raport_catatan_penolakan_' . $siswaId);

                $auditLogs = session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai();
                $auditLogs[] = [
                    'id' => count($auditLogs) + 1,
                    'siswa_id' => $siswaId,
                    'siswa_nama' => $targetSiswa['nama'],
                    'siswa_nis' => $targetSiswa['nis'] ?? '242510001',
                    'kelas' => $targetSiswa['kelas'] ?? 'XI-MIPA-1',
                    'mapel' => 'Semua Mata Pelajaran (Raport)',
                    'komponen' => 'Status Raport Final -> Draft',
                    'nilai_sebelum' => 'FINAL',
                    'nilai_sesudah' => 'DRAFT',
                    'diubah_oleh' => 'Administrator SIAKAD (' . ($this->commonData['user']['nama'] ?? 'Admin') . ')',
                    'alasan' => $alasanRevisi ?: ($removedReq['alasan'] ?? 'Pembukaan kunci raport disetujui untuk perbaikan nilai oleh Wali Kelas'),
                    'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
                    'waktu_perubahan' => date('Y-m-d H:i:s')
                ];
                session()->set('audit_log_nilai', $auditLogs);

                return redirect()->to($redirectUrl)->with('success', 'Raport ananda ' . $targetSiswa['nama'] . ' berhasil dibuka kuncinya (Status: Draft).');
            }
        }

        return redirect()->to($redirectUrl)->with('success', $action . ' berhasil disimpan dan diperbarui.');
    }

    // Modul Terpusat Log Audit Sistem & Jejak Rekam Revisi Nilai (II.5)
    public function logAudit()
    {
        $auditNilai = session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai();
        $sistemLogs = [
            ['id' => 101, 'kategori' => 'Tahun Ajaran', 'aktivitas' => 'Verifikasi Kunci Sidang Pleno Kenaikan Kelas', 'pelaku' => 'Admin (Super Administrator)', 'waktu' => '2025-12-19 14:00:00', 'status' => 'Sukses', 'detail' => 'Seluruh rombel dinyatakan tuntas pleno.'],
            ['id' => 102, 'kategori' => 'Raport', 'aktivitas' => 'Pengesahan Tanda Tangan Digital Raport', 'pelaku' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)', 'waktu' => '2025-12-19 15:30:00', 'status' => 'Sukses', 'detail' => 'Raport siswa Muhammad Raihan Pratama disahkan.'],
            ['id' => 103, 'kategori' => 'Nilai', 'aktivitas' => 'Permohonan Buka Kunci Revisi Nilai', 'pelaku' => 'Ustadzah Siti Nurhaliza, S.Pd.', 'waktu' => '2025-12-20 11:15:00', 'status' => 'Disetujui', 'detail' => 'Koreksi nilai praktikum Biologi siswa Aldi Kurniawan.'],
            ['id' => 104, 'kategori' => 'Persuratan', 'aktivitas' => 'Penerbitan Nomor Resmi Surat Keluar', 'pelaku' => 'M. Taufik Hidayat, S.Sos. (TU)', 'waktu' => '2025-12-21 09:30:00', 'status' => 'Sukses', 'detail' => 'Nomor resmi 104/SMA-FI/TU/XII/2025 diterbitkan saat status menunggu TTD.'],
            ['id' => 105, 'kategori' => 'Mutasi Siswa', 'aktivitas' => 'Pencatatan Mutasi Keluar Siswa', 'pelaku' => 'Admin (Super Administrator)', 'waktu' => '2025-12-22 08:45:00', 'status' => 'Sukses', 'detail' => 'Siswa Aditya Pratama dimutasi dan riwayat kelas diperbarui.'],
        ];

        $data = array_merge($this->commonData, [
            'title' => 'Pusat Log Audit & Jejak Rekam Sistem',
            'menu' => 'master_pengaturan',
            'submenu' => 'log_audit',
            'auditNilai' => $auditNilai,
            'sistemLogs' => $sistemLogs,
        ]);

        return view('admin/audit/index', $data);
    }
}
