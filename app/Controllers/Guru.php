<?php

namespace App\Controllers;

use App\Libraries\MockData;

class Guru extends BaseController
{
    protected array $commonData;

    public function __construct()
    {
        $this->commonData = [
            'role' => 'guru',
            'sekolah' => MockData::getSekolah(),
            'taAktif' => '2025/2026 - Ganjil (Aktif)',
            'namaGuru' => 'Ustadz Hendra Gunawan, M.Pd.',
            'kelasWali' => 'XI-MIPA-1',
            'isWaliKelas' => true,
            'sistemState' => MockData::getSistemState(),
        ];
    }

    public function index()
    {
        return $this->dashboard('wali');
    }

    // 1-2. Dashboard Guru Mapel & Wali Kelas
    public function dashboard($variant = 'wali')
    {
        $data = array_merge($this->commonData, [
            'title' => 'Dashboard Guru ' . ($variant === 'wali' ? '& Wali Kelas' : 'Mata Pelajaran'),
            'menu' => 'dashboard',
            'submenu' => $variant,
            'variant' => $variant,
            'stats' => [
                'mapel_diajar' => 2,
                'kelas_diajar' => 3,
                'total_siswa' => 92,
                'raport_progress' => 85, // 26 of 31 siswa complete
            ],
            'pengingat' => [
                ['judul' => 'Ulangan Harian 2 (Matriks) XI-MIPA-1', 'status' => 'Belum lengkap (30/31)', 'tipe' => 'warning'],
                ['judul' => 'Tugas 3 Proyek Terapan Belum Dinilai', 'status' => '3 hari tersisa', 'tipe' => 'info'],
                ['judul' => 'Kelengkapan Nilai Sikap & Ekstrakurikuler XI-MIPA-1', 'status' => '5 siswa belum diisi', 'tipe' => 'danger'],
                ['judul' => 'Finalisasi Raport Semester Ganjil', 'status' => 'Batas akhir 19 Des 2025', 'tipe' => 'primary'],
            ],
            'mapelList' => array_slice(MockData::getPengajaran(), 0, 3)
        ]);

        return view('guru/dashboard', $data);
    }

    // 3. Mapel Saya
    public function mapel()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Mata Pelajaran Saya',
            'menu' => 'mapel_saya',
            'submenu' => '',
            'pengajaranList' => array_slice(MockData::getPengajaran(), 0, 3)
        ]);

        return view('guru/mapel', $data);
    }

    // Helper untuk mengambil dan mengelola state nilai tugas
    private function getTugasScores($pengajaran_id = 1): array
    {
        $sessionKey = 'tugas_scores_' . $pengajaran_id;
        $scores = session()->get($sessionKey);
        if ($scores === null) {
            $scores = MockData::getDefaultNilaiTugas($pengajaran_id);
            session()->set($sessionKey, $scores);
        }
        return $scores;
    }

    // Helper untuk mengambil matriks nilai siswa yang tersinkronisasi otomatis dengan rata-rata tugas & UH
    private function getSiswaNilaiMatrixData($pengajaran_id = 1): array
    {
        $sessionKey = 'siswa_nilai_matrix_' . $pengajaran_id;
        $matrix = session()->get($sessionKey);
        if ($matrix === null) {
            $matrix = MockData::getSiswaNilaiMatrix();
            $matrix = $this->applyTugasAveragesToMatrix($pengajaran_id, $matrix);
            session()->set($sessionKey, $matrix);
        }
        return $matrix;
    }

    // Menerapkan kalkulasi rata-rata Tugas dan UH ke dalam matriks nilai
    private function applyTugasAveragesToMatrix($pengajaran_id, array $matrix): array
    {
        $rekap = MockData::getRekapTugasDanUH($pengajaran_id, $this->getTugasScores($pengajaran_id));
        $rekapMap = [];
        foreach ($rekap['rekap'] as $r) {
            $rekapMap[$r['siswa_id']] = $r;
        }

        foreach ($matrix as &$row) {
            $sId = $row['siswa_id'];
            if (isset($rekapMap[$sId])) {
                $r = $rekapMap[$sId];
                if (!empty($r['tugas_scores'])) {
                    $row['pengetahuan']['tugas'] = $r['avg_tugas'];
                }
                if (!empty($r['uh_scores'])) {
                    $row['pengetahuan']['uh'] = $r['avg_uh'];
                }

                // Kalkulasi Nilai Akhir (NA) Pengetahuan: UH 20%, Tugas 20%, UTS 25%, UAS 35%
                $uh = (float)$row['pengetahuan']['uh'];
                $tugas = (float)$row['pengetahuan']['tugas'];
                $uts = (float)$row['pengetahuan']['uts'];
                $uas = (float)$row['pengetahuan']['uas'];
                $na = round(($uh * 0.20) + ($tugas * 0.20) + ($uts * 0.25) + ($uas * 0.35), 1);
                $row['pengetahuan']['nilai_akhir'] = $na;

                // Hitung Predikat KKM 75
                if ($na >= 92) {
                    $predikat = 'A';
                } elseif ($na >= 83) {
                    $predikat = 'B';
                } elseif ($na >= 75) {
                    $predikat = 'C';
                } else {
                    $predikat = 'D';
                }
                $row['pengetahuan']['predikat'] = $predikat;
            }
        }
        return $matrix;
    }

    // 4-5. Input Nilai (Pengetahuan & Keterampilan)
    public function inputNilai($pengajaran_id = 1, $aspek = 'pengetahuan')
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $aspek = ($aspek === 'keterampilan') ? 'keterampilan' : 'pengetahuan';
        $komponenList = MockData::getKomponenNilai()[$aspek];
        $siswaNilai = $this->getSiswaNilaiMatrixData($pengajaran_id);
        $rekapTugasUH = MockData::getRekapTugasDanUH($pengajaran_id, $this->getTugasScores($pengajaran_id));

        $sessionDeskripsiKey = 'deskripsi_capaian_' . $pengajaran_id . '_' . $aspek;
        $savedDeskripsi = session()->get($sessionDeskripsiKey) ?? [];
        
        foreach ($siswaNilai as &$sn) {
            $sId = $sn['siswa_id'];
            $na = (float)($sn[$aspek]['nilai_akhir'] ?? 75);
            $sn[$aspek]['deskripsi'] = $savedDeskripsi[$sId] ?? MockData::generateDeskripsiCapaian($na, $aspek);
        }

        $data = array_merge($this->commonData, [
            'title' => 'Input Nilai: ' . $pengajaran['mapel_nama'] . ' (' . $pengajaran['kelas_nama'] . ')',
            'menu' => 'input_nilai',
            'submenu' => '',
            'pengajaran' => $pengajaran,
            'activeAspek' => $aspek,
            'komponenList' => $komponenList,
            'siswaNilai' => $siswaNilai,
            'rekapTugasUH' => $rekapTugasUH,
            'kompetensiDasar' => MockData::getKompetensiDasar($pengajaran['mapel_id'] ?? 4, 2),
        ]);

        return view('guru/nilai/input', $data);
    }

    // Sinkronisasi paksa rata-rata Tugas dan UH ke Matriks Nilai
    public function syncRataRataTugas($pengajaran_id = 1)
    {
        $matrix = $this->getSiswaNilaiMatrixData($pengajaran_id);
        $matrix = $this->applyTugasAveragesToMatrix($pengajaran_id, $matrix);
        session()->set('siswa_nilai_matrix_' . $pengajaran_id, $matrix);

        return redirect()->to(base_url('guru/nilai/' . $pengajaran_id . '/pengetahuan'))
            ->with('success', 'Rata-rata nilai Tugas & Ulangan Harian berhasil disinkronkan ke buku nilai!');
    }

    // 6-7. Tugas Harian & Ulangan Harian (Daftar & Rekap)
    public function rekapNilaiTugas($pengajaran_id = 1)
    {
        return redirect()->to(base_url('guru/tugas/' . ($pengajaran_id ?? 1)));
    }

    public function tugasHarian($pengajaran_id = 1)
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $tugasList = MockData::getTugasHarian($pengajaran_id);
        $allScores = $this->getTugasScores($pengajaran_id);
        
        // Update status kelengkapan jumlah siswa dinilai secara dinamis
        foreach ($tugasList as &$t) {
            $tId = $t['id'];
            $dinilai = 0;
            if (isset($allScores[$tId])) {
                foreach ($allScores[$tId] as $s) {
                    if (isset($s['nilai']) && $s['nilai'] !== '' && $s['nilai'] !== null) {
                        $dinilai++;
                    }
                }
            }
            $t['jumlah_dinilai'] = $dinilai;
            $t['total_siswa'] = 5; // 5 siswa aktif kelas XI-MIPA-1
        }

        $rekapData = MockData::getRekapTugasDanUH($pengajaran_id, $allScores);

        $data = array_merge($this->commonData, [
            'title' => 'Tugas Harian & Ulangan - ' . $pengajaran['mapel_nama'],
            'menu' => 'tugas_harian',
            'submenu' => '',
            'pengajaran' => $pengajaran,
            'tugasList' => $tugasList,
            'komponenList' => MockData::getKomponenNilai()['pengetahuan'],
            'rekapData' => $rekapData
        ]);

        return view('guru/tugas/index', $data);
    }

    // Form Khusus Input Nilai Siswa untuk Tugas / Ulangan yang Dipilih
    public function inputNilaiTugas($pengajaran_id = 1, $tugas_id = 1)
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $tugasList = MockData::getTugasHarian($pengajaran_id);
        $selectedTugas = null;
        foreach ($tugasList as $t) {
            if ($t['id'] == $tugas_id) {
                $selectedTugas = $t;
                break;
            }
        }
        if (!$selectedTugas) {
            $selectedTugas = $tugasList[0];
            $tugas_id = $selectedTugas['id'];
        }

        $allScores = $this->getTugasScores($pengajaran_id);
        $siswaNilaiList = MockData::getNilaiTugasDetail($pengajaran_id, $tugas_id, $allScores);

        // Hitung statistik nilai tugas ini
        $nilaiValues = array_column($siswaNilaiList, 'nilai');
        $validValues = array_filter($nilaiValues, fn($v) => is_numeric($v));
        $count = count($validValues);
        $avgKelas = $count > 0 ? round(array_sum($validValues) / $count, 1) : 0;
        $maxNilai = $count > 0 ? max($validValues) : 0;
        $minNilai = $count > 0 ? min($validValues) : 0;
        $kkm = $selectedTugas['kkm_snapshot'] ?? ($pengajaran['kkm_snapshot'] ?? ($pengajaran['kkm'] ?? 75.0));
        $tuntasCount = count(array_filter($validValues, fn($v) => $v >= $kkm));
        $remedialCount = count(array_filter($validValues, fn($v) => $v < $kkm));

        $data = array_merge($this->commonData, [
            'title' => 'Input Nilai: ' . $selectedTugas['judul'],
            'menu' => 'tugas_harian',
            'submenu' => '',
            'pengajaran' => $pengajaran,
            'tugas' => $selectedTugas,
            'tugasList' => $tugasList,
            'siswaNilaiList' => $siswaNilaiList,
            'stats' => [
                'rata_rata' => $avgKelas,
                'tertinggi' => $maxNilai,
                'terendah' => $minNilai,
                'tuntas_count' => $tuntasCount,
                'remedial_count' => $remedialCount,
                'total_siswa' => count($siswaNilaiList),
            ]
        ]);

        return view('guru/tugas/nilai', $data);
    }

    // Simpan Nilai Siswa untuk Tugas / Ulangan Tertentu & Otomatis Hitung Ulang Rata-rata
    public function saveNilaiTugas($pengajaran_id = 1, $tugas_id = 1)
    {
        $nilaiPost = $this->request->getPost('nilai') ?? [];
        $catatanPost = $this->request->getPost('catatan') ?? [];
        $judulTugas = $this->request->getPost('judul_tugas') ?? 'Tugas';

        $allScores = $this->getTugasScores($pengajaran_id);
        if (!isset($allScores[$tugas_id])) {
            $allScores[$tugas_id] = [];
        }

        foreach ($nilaiPost as $sId => $val) {
            $allScores[$tugas_id][$sId] = [
                'nilai' => ($val !== '' && is_numeric($val)) ? (float)$val : null,
                'catatan' => $catatanPost[$sId] ?? ''
            ];
        }

        // Simpan scores tugas ke session
        session()->set('tugas_scores_' . $pengajaran_id, $allScores);

        // Kalkulasi ulang rata-rata tugas & UH dan update ke matriks nilai umum
        $matrix = $this->getSiswaNilaiMatrixData($pengajaran_id);
        $matrix = $this->applyTugasAveragesToMatrix($pengajaran_id, $matrix);
        session()->set('siswa_nilai_matrix_' . $pengajaran_id, $matrix);

        return redirect()->to(base_url('guru/tugas/' . $pengajaran_id . '/nilai/' . $tugas_id))
            ->with('success', "Nilai untuk \"{$judulTugas}\" berhasil disimpan! Rata-rata nilai tugas/UH siswa telah otomatis diperbarui ke Input Nilai Mapel.");
    }

    // =========================================================================
    // PRESENSI HARIAN PER PERTEMUAN & JURNAL KBM GURU MATA PELAJARAN
    // =========================================================================

    private function getPertemuanList($pengajaran_id = 1): array
    {
        $sessionKey = 'pertemuan_list_' . $pengajaran_id;
        $list = session()->get($sessionKey);
        if ($list === null) {
            $list = MockData::getDefaultPertemuanList($pengajaran_id);
            session()->set($sessionKey, $list);
        }
        return $list;
    }

    private function getPresensiDetailMap($pengajaran_id = 1): array
    {
        $sessionKey = 'presensi_detail_map_' . $pengajaran_id;
        $map = session()->get($sessionKey);
        if ($map === null) {
            $map = MockData::getDefaultPresensiDetailMap($pengajaran_id);
            session()->set($sessionKey, $map);
        }
        return $map;
    }

    // 1. Halaman Index Presensi (Daftar Pertemuan & Rekapitulasi Matriks)
    public function presensi($pengajaran_id = 1, $tab = 'pertemuan')
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $validTabs = ['pertemuan', 'rekap'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'pertemuan';
        }

        $pertemuanList = $this->getPertemuanList($pengajaran_id);
        $detailMap = $this->getPresensiDetailMap($pengajaran_id);
        $rekapData = MockData::getRekapPresensiMapel($pengajaran_id, $pertemuanList, $detailMap);

        // Cari siswa dengan kehadiran kritis (< 85%)
        $siswaKritis = array_values(array_filter($rekapData['rekap'], fn($s) => !$s['is_tuntas']));

        $data = array_merge($this->commonData, [
            'title' => 'Presensi & Jurnal KBM: ' . $pengajaran['mapel_nama'],
            'menu' => 'presensi_kelas',
            'submenu' => $tab,
            'activeTab' => $tab,
            'pengajaran' => $pengajaran,
            'pengajaranList' => array_slice(MockData::getPengajaran(), 0, 3),
            'pertemuanList' => $pertemuanList,
            'detailMap' => $detailMap,
            'rekapData' => $rekapData,
            'siswaKritis' => $siswaKritis,
        ]);

        return view('guru/presensi/index', $data);
    }

    // 2. Form Input / Edit Kehadiran Siswa & Jurnal KBM untuk Pertemuan Tertentu
    public function presensiInput($pengajaran_id = 1, $pertemuan_id = 1)
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $pertemuanList = $this->getPertemuanList($pengajaran_id);
        $selectedPertemuan = null;
        foreach ($pertemuanList as $pt) {
            if ($pt['id'] == $pertemuan_id) {
                $selectedPertemuan = $pt;
                break;
            }
        }
        if (!$selectedPertemuan) {
            $selectedPertemuan = $pertemuanList[0];
            $pertemuan_id = $selectedPertemuan['id'];
        }

        $detailMap = $this->getPresensiDetailMap($pengajaran_id);
        $pertemuanDetail = $detailMap[$pertemuan_id] ?? [];

        $siswaList = array_slice(MockData::getSiswaList(), 0, 5);
        $siswaPresensi = [];
        foreach ($siswaList as $s) {
            $sId = $s['id'];
            $st = $pertemuanDetail[$sId]['status'] ?? 'H';
            $ct = $pertemuanDetail[$sId]['catatan'] ?? '';
            $siswaPresensi[] = [
                'siswa_id' => $sId,
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'foto_path' => $s['foto_path'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                'status' => $st,
                'catatan' => $ct,
            ];
        }

        $data = array_merge($this->commonData, [
            'title' => 'Isi Presensi Pertemuan ' . $selectedPertemuan['pertemuan_ke'] . ' - ' . $pengajaran['mapel_nama'],
            'menu' => 'presensi_kelas',
            'submenu' => 'input',
            'pengajaran' => $pengajaran,
            'pertemuan' => $selectedPertemuan,
            'pertemuanList' => $pertemuanList,
            'siswaPresensi' => $siswaPresensi,
        ]);

        return view('guru/presensi/input', $data);
    }

    // 3. Simpan Presensi & Jurnal KBM Pertemuan
    public function savePresensiPertemuan($pengajaran_id = 1, $pertemuan_id = 1)
    {
        $tanggal = $this->request->getPost('tanggal');
        $jamKe = $this->request->getPost('jam_ke');
        $materiPokok = $this->request->getPost('materi_pokok');
        $metode = $this->request->getPost('metode');
        $catatanJurnal = $this->request->getPost('catatan_jurnal');

        $statusPost = $this->request->getPost('status') ?? [];
        $catatanPost = $this->request->getPost('catatan') ?? [];

        $detailMap = $this->getPresensiDetailMap($pengajaran_id);
        $hadirCount = 0;
        $sakitCount = 0;
        $izinCount = 0;
        $alpaCount = 0;
        $dispCount = 0;

        foreach ($statusPost as $sId => $st) {
            $validStatus = in_array($st, ['H', 'S', 'I', 'A', 'D']) ? $st : 'H';
            $detailMap[$pertemuan_id][$sId] = [
                'status' => $validStatus,
                'catatan' => $catatanPost[$sId] ?? '',
            ];

            if ($validStatus === 'H') $hadirCount++;
            elseif ($validStatus === 'S') $sakitCount++;
            elseif ($validStatus === 'I') $izinCount++;
            elseif ($validStatus === 'A') $alpaCount++;
            elseif ($validStatus === 'D') $dispCount++;
        }

        // Update list pertemuan
        $pertemuanList = $this->getPertemuanList($pengajaran_id);
        $pFound = false;
        foreach ($pertemuanList as &$pt) {
            if ($pt['id'] == $pertemuan_id) {
                if ($tanggal) $pt['tanggal'] = $tanggal;
                if ($jamKe) $pt['jam_ke'] = $jamKe;
                if ($materiPokok) $pt['materi_pokok'] = $materiPokok;
                if ($metode) $pt['metode'] = $metode;
                $pt['catatan_jurnal'] = $catatanJurnal ?? '';
                $pt['status'] = 'selesai';
                $pt['rekap'] = [
                    'hadir' => $hadirCount,
                    'sakit' => $sakitCount,
                    'izin' => $izinCount,
                    'alpa' => $alpaCount,
                    'dispensasi' => $dispCount,
                    'total' => count($statusPost)
                ];
                $pFound = true;
                break;
            }
        }

        session()->set('presensi_detail_map_' . $pengajaran_id, $detailMap);
        session()->set('pertemuan_list_' . $pengajaran_id, $pertemuanList);

        return redirect()->to(base_url('guru/presensi/' . $pengajaran_id))
            ->with('success', "Presensi & Jurnal Pembelajaran untuk Pertemuan ini berhasil disimpan dan rekap kehadiran kelas telah diperbarui!");
    }

    // 4. Tambah Sesi Pertemuan Baru
    public function tambahPertemuan($pengajaran_id = 1)
    {
        $tanggal = $this->request->getPost('tanggal') ?? date('Y-m-d');
        $jamKe = $this->request->getPost('jam_ke') ?? 'Jam ke 1-2 (07:15 - 08:45)';
        $materiPokok = $this->request->getPost('materi_pokok') ?? 'Materi Pembelajaran';
        $metode = $this->request->getPost('metode') ?? 'Ceramah & Diskusi';
        $catatanJurnal = $this->request->getPost('catatan_jurnal') ?? '';

        $pertemuanList = $this->getPertemuanList($pengajaran_id);
        $maxPertemuanKe = 0;
        $maxId = 0;
        foreach ($pertemuanList as $pt) {
            if ($pt['pertemuan_ke'] > $maxPertemuanKe) $maxPertemuanKe = $pt['pertemuan_ke'];
            if ($pt['id'] > $maxId) $maxId = $pt['id'];
        }

        $newPertemuanKe = $maxPertemuanKe + 1;
        $newId = $maxId + 1;

        $newPertemuan = [
            'id' => $newId,
            'pertemuan_ke' => $newPertemuanKe,
            'tanggal' => $tanggal,
            'jam_ke' => $jamKe,
            'materi_pokok' => $materiPokok,
            'metode' => $metode,
            'catatan_jurnal' => $catatanJurnal,
            'status' => 'belum_diisi',
            'rekap' => ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispensasi' => 0, 'total' => 5]
        ];

        $pertemuanList[] = $newPertemuan;

        // Inisialisasi detail kehadiran dengan 'H'
        $detailMap = $this->getPresensiDetailMap($pengajaran_id);
        $siswaList = array_slice(MockData::getSiswaList(), 0, 5);
        $detailMap[$newId] = [];
        foreach ($siswaList as $s) {
            $detailMap[$newId][$s['id']] = ['status' => 'H', 'catatan' => ''];
        }

        session()->set('pertemuan_list_' . $pengajaran_id, $pertemuanList);
        session()->set('presensi_detail_map_' . $pengajaran_id, $detailMap);

        return redirect()->to(base_url('guru/presensi/' . $pengajaran_id . '/input/' . $newId))
            ->with('success', "Sesi Pertemuan ke-{$newPertemuanKe} berhasil dibuat. Silakan lakukan pencatatan kehadiran dan jurnal KBM!");
    }

    // 5. Cetak Rekapitulasi Presensi & Jurnal KBM (Print View)
    public function presensiCetak($pengajaran_id = 1)
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];
        foreach ($pengajaranList as $p) {
            if ($p['id'] == $pengajaran_id) {
                $pengajaran = $p;
                break;
            }
        }

        $pertemuanList = $this->getPertemuanList($pengajaran_id);
        $detailMap = $this->getPresensiDetailMap($pengajaran_id);
        $rekapData = MockData::getRekapPresensiMapel($pengajaran_id, $pertemuanList, $detailMap);

        $data = array_merge($this->commonData, [
            'title' => 'Cetak Buku Presensi & Jurnal KBM - ' . $pengajaran['mapel_nama'],
            'pengajaran' => $pengajaran,
            'pertemuanList' => $pertemuanList,
            'rekapData' => $rekapData,
        ]);

        return view('guru/presensi/cetak', $data);
    }

    // 8-9. Analitik Nilai (Guru Mapel & Wali Kelas)
    public function analitik($pengajaran_id = 1, $variant = 'mapel')
    {
        $pengajaranList = MockData::getPengajaran();
        $pengajaran = $pengajaranList[0];

        $data = array_merge($this->commonData, [
            'title' => 'Analitik Nilai ' . ($variant === 'wali' ? 'Kelas Perwalian (XI-MIPA-1)' : $pengajaran['mapel_nama']),
            'menu' => 'analitik',
            'submenu' => $variant,
            'variant' => $variant,
            'pengajaran' => $pengajaran,
            'stats' => [
                'rata_rata' => 88.4,
                'tertinggi' => 98.0,
                'terendah' => 70.0,
                'tuntas_count' => 29,
                'remedial_count' => 2
            ],
            'siswaBawahKkm' => [
                ['nis' => '242510005', 'nama' => 'Aldi Kurniawan', 'nilai_akhir' => 72.5, 'kkm' => 75.0, 'rekomendasi' => 'Remedial UTS & Tugas Tambahan'],
                ['nis' => '242510019', 'nama' => 'Bagas Firmansyah', 'nilai_akhir' => 70.0, 'kkm' => 75.0, 'rekomendasi' => 'Remedial UAS & Bimbingan Matriks'],
            ]
        ]);

        return view('guru/analitik/index', $data);
    }

    // 10-12. Kelas Perwalian (Sikap, Ekstrakurikuler, Prestasi, Absensi)
    public function perwalian($tab = 'sikap')
    {
        $validTabs = ['sikap', 'ekskul', 'prestasi', 'absensi'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'sikap';
        }

        $sessionAbsensi = session()->get('absensi_perwalian_4') ?? MockData::getDefaultAbsensiPerwalian(4);
        $siswaList = array_slice(MockData::getSiswaList(), 0, 5);
        foreach ($siswaList as &$s) {
            $sId = $s['id'];
            $s['absensi'] = $sessionAbsensi[$sId] ?? ['sakit' => 0, 'izin' => 0, 'tanpa_keterangan' => 0, 'catatan' => ''];
        }

        $data = array_merge($this->commonData, [
            'title' => 'Kelas Perwalian: XI-MIPA-1',
            'menu' => 'kelas_perwalian',
            'submenu' => $tab,
            'activeTab' => $tab,
            'siswaList' => $siswaList,
            'absensiData' => $sessionAbsensi,
            'jenisSikap' => MockData::getJenisSikap(),
            'jenisEkskul' => MockData::getJenisEkstrakurikuler(),
            'jenisPrestasi' => MockData::getJenisPrestasi(),
        ]);

        return view('guru/perwalian/index', $data);
    }

    // Simpan Rekap Kehadiran (Absensi) Siswa Kelas Perwalian
    public function saveAbsensiPerwalian()
    {
        $sakit = $this->request->getPost('sakit') ?? [];
        $izin = $this->request->getPost('izin') ?? [];
        $tanpaKeterangan = $this->request->getPost('tanpa_keterangan') ?? [];
        $catatan = $this->request->getPost('catatan') ?? [];

        $absensiData = [];
        foreach ($sakit as $sId => $sVal) {
            $absensiData[$sId] = [
                'siswa_id' => $sId,
                'sakit' => (int)$sVal,
                'izin' => (int)($izin[$sId] ?? 0),
                'tanpa_keterangan' => (int)($tanpaKeterangan[$sId] ?? 0),
                'catatan' => $catatan[$sId] ?? ''
            ];
        }

        session()->set('absensi_perwalian_4', $absensiData);

        return redirect()->to(base_url('guru/perwalian/absensi'))
            ->with('success', 'Rekap Kehadiran (Absensi) Siswa Kelas XI-MIPA-1 berhasil disimpan dan otomatis disinkronkan ke Raport Digital!');
    }

    // Matriks Nilai Kelas (Leger Nilai & Rekapitulasi Rombel)
    public function legerNilai()
    {
        $legerData = MockData::getLegerNilaiKelas(4);
        $rows = $legerData['rows'];
        
        $totalSiswa = count($rows);
        $avgValues = array_column($rows, 'rata_rata');
        $maxAvg = !empty($avgValues) ? max($avgValues) : 0;
        $minAvg = !empty($avgValues) ? min($avgValues) : 0;
        $overallAvg = !empty($avgValues) ? round(array_sum($avgValues) / count($avgValues), 1) : 0;
        $tuntasCount = count(array_filter($rows, fn($r) => $r['is_tuntas']));
        
        $data = array_merge($this->commonData, [
            'title' => 'Matriks Nilai Kelas: ' . $legerData['kelas'],
            'menu' => 'leger_nilai',
            'submenu' => '',
            'legerData' => $legerData,
            'stats' => [
                'total_siswa' => $totalSiswa,
                'overall_avg' => $overallAvg,
                'max_avg' => $maxAvg,
                'min_avg' => $minAvg,
                'tuntas_count' => $tuntasCount,
                'tuntas_percent' => $totalSiswa > 0 ? round(($tuntasCount / $totalSiswa) * 100, 1) : 0
            ]
        ]);

        return view('guru/leger/index', $data);
    }

    // 13. Kenaikan Kelas / Kelulusan (2 Tahap: Usulan Wali Kelas & Pengesahan Pleno)
    public function kenaikanKelas()
    {
        $allSiswa = MockData::getKenaikanKelasList();
        $sessionPleno = session()->get('pleno_kenaikan_data') ?? [];
        $rekapPresensi = MockData::getRekapPresensiMapel(1);
        $presensiMap = [];
        foreach ($rekapPresensi['rekap'] as $rp) {
            $presensiMap[$rp['siswa_id']] = $rp;
        }

        foreach ($allSiswa as &$s) {
            $sId = $s['id'];
            if (isset($sessionPleno[$sId])) {
                $s['status'] = $sessionPleno[$sId]['status_usulan'] ?? $s['status'];
                $s['kelas_tujuan'] = $sessionPleno[$sId]['kelas_tujuan'] ?? $s['kelas_tujuan'];
                $s['catatan'] = $sessionPleno[$sId]['catatan'] ?? $s['catatan'];
                $s['status_pleno'] = $sessionPleno[$sId]['status_pleno'] ?? 'belum_disahkan';
            } else {
                $s['status_pleno'] = ($s['id'] <= 2 ? 'disahkan_pleno' : 'belum_disahkan');
            }

            // Indikator otomatis bantuan keputusan
            $s['kehadiran_persen'] = $presensiMap[$sId]['persentase'] ?? 95.0;
            $s['kehadiran_kritis'] = ($s['kehadiran_persen'] < 85.0);
            $s['mapel_bawah_kkm_count'] = ($s['rata_rata'] < 75.0) ? 2 : (($s['rata_rata'] < 80.0) ? 1 : 0);
            $s['sikap_predikat'] = ($s['id'] == 5 ? 'Cukup' : ($s['id'] == 3 ? 'Baik' : 'Sangat Baik'));
            $s['tinggal_berulang'] = ($s['id'] == 5); // Aldi Kurniawan: flag perhatian khusus BK
        }

        $siswaKenaikan = array_values(array_filter($allSiswa, fn($s) => ($s['tingkatan'] ?? 11) < 12));
        $siswaKelulusan = array_values(array_filter($allSiswa, fn($s) => ($s['tingkatan'] ?? 11) >= 12));

        $data = array_merge($this->commonData, [
            'title' => 'Keputusan Kenaikan Kelas & Sidang Pleno',
            'menu' => 'kenaikan_kelas',
            'submenu' => '',
            'siswaList' => $allSiswa,
            'siswaKenaikan' => $siswaKenaikan,
            'siswaKelulusan' => $siswaKelulusan,
            'kelasList' => MockData::getKelas(),
            'statusPlenoRombel' => (session()->get('pleno_disahkan_resmi') ? 'selesai' : 'sedang_berlangsung'),
            'isDisahkanSemua' => count(array_filter($allSiswa, fn($s) => ($s['status_pleno'] ?? '') === 'disahkan_pleno')) === count($allSiswa)
        ]);

        return view('guru/kenaikan/index', $data);
    }

    public function savePlenoKenaikan()
    {
        $statusUsulan = $this->request->getPost('status_usulan') ?? [];
        $kelasTujuan = $this->request->getPost('kelas_tujuan') ?? [];
        $catatan = $this->request->getPost('catatan') ?? [];
        $tindakan = $this->request->getPost('tindakan') ?? 'simpan_usulan';

        $sessionData = session()->get('pleno_kenaikan_data') ?? [];
        foreach ($statusUsulan as $sId => $st) {
            $sessionData[$sId] = [
                'status_usulan' => $st,
                'kelas_tujuan' => $kelasTujuan[$sId] ?? '',
                'catatan' => $catatan[$sId] ?? '',
                'status_pleno' => ($tindakan === 'sahkan_pleno') ? 'disahkan_pleno' : ($sessionData[$sId]['status_pleno'] ?? 'belum_disahkan')
            ];
        }

        session()->set('pleno_kenaikan_data', $sessionData);
        if ($tindakan === 'sahkan_pleno') {
            session()->set('pleno_disahkan_resmi', true);
        }

        $msg = ($tindakan === 'sahkan_pleno')
            ? 'Hasil Sidang Pleno Kenaikan Kelas XI-MIPA-1 berhasil disahkan resmi oleh Dewan Guru dan Kepala Sekolah!'
            : 'Usulan Kenaikan Kelas dari Wali Kelas berhasil disimpan dan siap diajukan ke Sidang Pleno.';

        return redirect()->to(base_url('guru/kenaikan-kelas'))->with('success', $msg);
    }

    // 14. Raport - Generate
    public function raportGenerate()
    {
        $sistemState = MockData::getSistemState();
        $kelasId = 4; // XI-MIPA-1
        $kelengkapanInfo = $sistemState['kelengkapan_nilai_kelas'][$kelasId] ?? [
            'persen' => 85,
            'mapel_belum' => ['Fisika (Ustadz Budi)', 'Bahasa Sunda'],
            'boleh_generate' => false
        ];
        $mapelList = $sistemState['kelengkapan_mapel_detail'][$kelasId] ?? [];

        $data = array_merge($this->commonData, [
            'title' => 'Generate Raport Digital Semester Ini',
            'menu' => 'raport',
            'submenu' => 'generate',
            'kelasWali' => 'XI-MIPA-1',
            'kelasId' => $kelasId,
            'totalSiswa' => 31,
            'kelengkapanInfo' => $kelengkapanInfo,
            'mapelList' => $mapelList,
        ]);

        return view('guru/raport/generate', $data);
    }

    // 15-16. Raport - Tinjau per Siswa (Paper View Section A-F) & Finalisasi Bertahap
    public function raportTinjau($siswa_id = 1)
    {
        $siswaList = MockData::getSiswaList();
        $raport = MockData::getRaportSiswa($siswa_id);

        $statusOverride = session()->get('raport_status_' . $siswa_id);
        if ($statusOverride) {
            $raport['status'] = $statusOverride;
        }
        if ($raport['status'] === 'final') {
            $raport['approval_kepsek']['status'] = 'disahkan';
            $raport['approval_kepsek']['disahkan_pada'] = '2025-12-19 15:30:00';
        }

        $catatanPenolakan = session()->get('raport_catatan_penolakan_' . $siswa_id);

        $data = array_merge($this->commonData, [
            'title' => 'Tinjau Raport: ' . $raport['siswa']['nama'],
            'menu' => 'raport',
            'submenu' => 'tinjau',
            'siswaList' => $siswaList,
            'currentSiswaId' => $siswa_id,
            'raport' => $raport,
            'catatanPenolakan' => $catatanPenolakan,
        ]);

        return view('guru/raport/tinjau', $data);
    }

    public function finalisasiRaport($siswa_id = 1)
    {
        $tahap = $this->request->getPost('tahap') ?? 'ajukan_kepsek';
        $sessionKey = 'raport_status_' . $siswa_id;

        if ($tahap === 'ajukan_kepsek') {
            session()->set($sessionKey, 'menunggu_persetujuan_kepsek');
            session()->remove('raport_catatan_penolakan_' . $siswa_id);
            return redirect()->to(base_url('guru/raport/tinjau/' . $siswa_id))
                ->with('success', 'Raport berhasil dikunci sementara oleh Wali Kelas dan telah diajukan ke Kepala Sekolah untuk disahkan.');
        } elseif ($tahap === 'sahkan_kepsek') {
            session()->set($sessionKey, 'final');
            session()->remove('raport_catatan_penolakan_' . $siswa_id);
            return redirect()->to(base_url('guru/raport/tinjau/' . $siswa_id))
                ->with('success', 'Raport berhasil disahkan resmi oleh Kepala Sekolah dengan Tanda Tangan Digital Resmi (Status: Final).');
        } elseif ($tahap === 'tolak_kepsek') {
            $catatan = $this->request->getPost('catatan_revisi') ?? 'Terdapat perbaikan yang perlu ditinjau ulang.';
            session()->set($sessionKey, 'draft');
            session()->set('raport_catatan_penolakan_' . $siswa_id, $catatan);
            return redirect()->to(base_url('guru/raport/tinjau/' . $siswa_id))
                ->with('warning', 'Raport telah ditolak / dikembalikan ke status DRAFT untuk diperbaiki oleh Wali Kelas.');
        }

        return redirect()->to(base_url('guru/raport/tinjau/' . $siswa_id));
    }

    // 17. Buka Kembali Raport Final untuk Revisi
    public function raportBukaKunci($siswa_id = 1)
    {
        $siswaList = MockData::getSiswaList();
        $raport = MockData::getRaportSiswa($siswa_id);

        $statusOverride = session()->get('raport_status_' . $siswa_id);
        if ($statusOverride) {
            $raport['status'] = $statusOverride;
        } else {
            $raport['status'] = $raport['status'] ?? 'final';
        }

        $unlockPendingList = MockData::getUnlockRequests();

        // Periksa apakah ada permohonan pending untuk raport siswa ini
        $hasPendingRequest = false;
        $currentPending = null;
        foreach ($unlockPendingList as $req) {
            $reqSiswaId = $req['siswa_id'] ?? $req['id'] ?? 0;
            $reqNis = $req['siswa_nis'] ?? '';
            if ($reqSiswaId == $siswa_id || ($reqNis !== '' && $reqNis === ($raport['siswa']['nis'] ?? ''))) {
                $hasPendingRequest = true;
                $currentPending = $req;
                break;
            }
        }

        $data = array_merge($this->commonData, [
            'title' => 'Buka Kunci Raport Final: ' . ($raport['siswa']['nama'] ?? 'Siswa'),
            'menu' => 'raport',
            'submenu' => 'buka_kunci',
            'siswaList' => $siswaList,
            'currentSiswaId' => $siswa_id,
            'raport' => $raport,
            'hasPendingRequest' => $hasPendingRequest,
            'currentPending' => $currentPending,
            'unlockPendingList' => $unlockPendingList,
        ]);

        return view('guru/raport/buka_kunci', $data);
    }

    public function ajukanBukaKunciRaport($siswa_id = 1)
    {
        $raport = MockData::getRaportSiswa($siswa_id);
        $alasan = trim($this->request->getPost('alasan_revisi') ?? '');
        if (empty($alasan)) {
            $alasan = 'Perbaikan kekeliruan data nilai / capaian kompetensi siswa';
        }

        $pendingList = MockData::getUnlockRequests();

        // Bersihkan permohonan pending sebelumnya untuk siswa ini jika ada
        $pendingList = array_values(array_filter($pendingList, function ($item) use ($siswa_id, $raport) {
            $reqSiswaId = $item['siswa_id'] ?? $item['id'] ?? 0;
            $reqNis = $item['siswa_nis'] ?? '';
            return !($reqSiswaId == $siswa_id || ($reqNis !== '' && $reqNis === ($raport['siswa']['nis'] ?? '')));
        }));

        $newReq = [
            'id' => time(),
            'siswa_id' => (int)$siswa_id,
            'siswa_nama' => $raport['siswa']['nama'] ?? 'Siswa',
            'siswa_nis' => $raport['siswa']['nis'] ?? '',
            'kelas' => $raport['siswa']['kelas'] ?? 'XI-MIPA-1',
            'semester' => $raport['siswa']['semester'] ?? 'Ganjil 2025/2026',
            'alasan' => $alasan,
            'diminta_oleh' => $this->commonData['user']['nama'] ?? 'Ustadz Hendra Gunawan, M.Pd.',
            'diminta_pada' => date('Y-m-d H:i'),
            'status' => 'pending'
        ];

        $pendingList[] = $newReq;
        session()->set('unlock_requests_pending', $pendingList);
        session()->remove('unlock_request_status_1');

        return redirect()->to(base_url('guru/raport/buka-kunci/' . $siswa_id))
            ->with('success', 'Permohonan buka kunci raport untuk ananda ' . ($raport['siswa']['nama'] ?? '') . ' berhasil dikirim ke Administrator.');
    }

    public function batalBukaKunciRaport($siswa_id = 1)
    {
        $raport = MockData::getRaportSiswa($siswa_id);
        $pendingList = MockData::getUnlockRequests();

        $pendingList = array_values(array_filter($pendingList, function ($item) use ($siswa_id, $raport) {
            $reqSiswaId = $item['siswa_id'] ?? $item['id'] ?? 0;
            $reqNis = $item['siswa_nis'] ?? '';
            return !($reqSiswaId == $siswa_id || ($reqNis !== '' && $reqNis === ($raport['siswa']['nis'] ?? '')));
        }));

        session()->set('unlock_requests_pending', $pendingList);

        return redirect()->to(base_url('guru/raport/buka-kunci/' . $siswa_id))
            ->with('info', 'Permohonan buka kunci raport untuk ananda ' . ($raport['siswa']['nama'] ?? '') . ' telah dibatalkan.');
    }

    public function saveAction()
    {
        $action = $this->request->getPost('action') ?? 'Data';
        $redirectUrl = $this->request->getPost('redirect_url') ?? '/guru';
        $siswaId = $this->request->getPost('siswa_id');

        if ($siswaId && (stripos($action, 'buka kunci') !== false || $this->request->getPost('alasan_revisi'))) {
            return $this->ajukanBukaKunciRaport($siswaId);
        }

        $pengajaranId = $this->request->getPost('pengajaran_id') ?? 1;
        $nilaiPost = $this->request->getPost('nilai');
        $aspek = $this->request->getPost('aspek') ?? 'pengetahuan';

        if (is_array($nilaiPost)) {
            $matrix = $this->getSiswaNilaiMatrixData($pengajaranId);
            foreach ($matrix as &$row) {
                $sId = $row['siswa_id'];
                if (isset($nilaiPost[$sId])) {
                    $vals = $nilaiPost[$sId];
                    if ($aspek === 'pengetahuan') {
                        $uh = isset($vals['uh']) && is_numeric($vals['uh']) ? (float)$vals['uh'] : (float)$row['pengetahuan']['uh'];
                        $tugas = isset($vals['tugas']) && is_numeric($vals['tugas']) ? (float)$vals['tugas'] : (float)$row['pengetahuan']['tugas'];
                        $uts = isset($vals['uts']) && is_numeric($vals['uts']) ? (float)$vals['uts'] : (float)$row['pengetahuan']['uts'];
                        $uas = isset($vals['uas']) && is_numeric($vals['uas']) ? (float)$vals['uas'] : (float)$row['pengetahuan']['uas'];

                        $oldNa = (float)$row['pengetahuan']['nilai_akhir'];
                        $row['pengetahuan']['uh'] = $uh;
                        $row['pengetahuan']['tugas'] = $tugas;
                        $row['pengetahuan']['uts'] = $uts;
                        $row['pengetahuan']['uas'] = $uas;

                        $na = round(($uh * 0.20) + ($tugas * 0.20) + ($uts * 0.25) + ($uas * 0.35), 1);
                        $row['pengetahuan']['nilai_akhir'] = $na;
                        $row['pengetahuan']['predikat'] = ($na >= 92 ? 'A' : ($na >= 83 ? 'B' : ($na >= 75 ? 'C' : 'D')));

                        if ($oldNa > 0 && $oldNa != $na) {
                            $auditLogs = session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai();
                            $auditLogs[] = [
                                'id' => count($auditLogs) + 1,
                                'siswa_id' => $sId,
                                'siswa_nama' => $row['nama'],
                                'siswa_nis' => $row['nis'],
                                'kelas' => 'XI-MIPA-1',
                                'mapel' => 'Matematika (Wajib)',
                                'komponen' => 'Nilai Akhir Pengetahuan',
                                'nilai_sebelum' => $oldNa,
                                'nilai_sesudah' => $na,
                                'diubah_oleh' => $this->commonData['user']['nama'] ?? 'Ustadz Hendra Gunawan, M.Pd.',
                                'alasan' => 'Revisi nilai setelah pembukaan kunci oleh Kepala Sekolah',
                                'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
                                'waktu_perubahan' => date('Y-m-d H:i:s')
                            ];
                            session()->set('audit_log_nilai', $auditLogs);
                        }
                    } else {
                        $oldNa = (float)$row['keterampilan']['nilai_akhir'];
                        $p1 = isset($vals['praktik']) && is_numeric($vals['praktik']) ? (float)$vals['praktik'] : (float)$row['keterampilan']['praktik'];
                        $p2 = isset($vals['proyek']) && is_numeric($vals['proyek']) ? (float)$vals['proyek'] : (float)$row['keterampilan']['proyek'];
                        $p3 = isset($vals['portofolio']) && is_numeric($vals['portofolio']) ? (float)$vals['portofolio'] : (float)$row['keterampilan']['portofolio'];

                        $row['keterampilan']['praktik'] = $p1;
                        $row['keterampilan']['proyek'] = $p2;
                        $row['keterampilan']['portofolio'] = $p3;

                        $na = round(($p1 * 0.40) + ($p2 * 0.30) + ($p3 * 0.30), 1);
                        $row['keterampilan']['nilai_akhir'] = $na;
                        $row['keterampilan']['predikat'] = ($na >= 92 ? 'A' : ($na >= 83 ? 'B' : ($na >= 75 ? 'C' : 'D')));

                        if ($oldNa > 0 && $oldNa != $na) {
                            $auditLogs = session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai();
                            $auditLogs[] = [
                                'id' => count($auditLogs) + 1,
                                'siswa_id' => $sId,
                                'siswa_nama' => $row['nama'],
                                'siswa_nis' => $row['nis'],
                                'kelas' => 'XI-MIPA-1',
                                'mapel' => 'Matematika (Wajib)',
                                'komponen' => 'Nilai Akhir Keterampilan',
                                'nilai_sebelum' => $oldNa,
                                'nilai_sesudah' => $na,
                                'diubah_oleh' => $this->commonData['user']['nama'] ?? 'Ustadz Hendra Gunawan, M.Pd.',
                                'alasan' => 'Revisi nilai unjuk kerja / portofolio pasca buka kunci',
                                'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
                                'waktu_perubahan' => date('Y-m-d H:i:s')
                            ];
                            session()->set('audit_log_nilai', $auditLogs);
                        }
                    }
                }
            }
            session()->set('siswa_nilai_matrix_' . $pengajaranId, $matrix);
        }

        $deskripsiPost = $this->request->getPost('deskripsi');
        if (is_array($deskripsiPost)) {
            session()->set('deskripsi_capaian_' . $pengajaranId . '_' . $aspek, $deskripsiPost);
        }

        return redirect()->to($redirectUrl)->with('success', $action . ' berhasil disimpan dan diperbarui.');
    }
}
