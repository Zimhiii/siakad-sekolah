<?php

namespace App\Controllers;

use App\Libraries\MockData;

class FigmaExport extends BaseController
{
    public function index()
    {
        return view('figma_export/index', [
            'title' => 'Katalog Halaman Statis Per-Kondisi - Figma Export'
        ]);
    }

    public function render(string $role, string $file)
    {
        $file = str_replace('.php', '', $file);
        $viewPath = "figma_export/{$role}/{$file}";

        // Ensure session has the role and mock auth so layout & sidebar render properly
        session()->set('role', $role);
        session()->set('isLoggedIn', true);
        session()->set('nama_user', match($role) {
            'admin' => 'Administrator Sekolah',
            'guru' => 'Ustadz Hendra Gunawan, M.Pd.',
            'tu' => 'M. Taufik Hidayat, S.Sos.',
            'siswa' => 'Muhammad Raihan Pratama',
            default => 'Pengguna SIAKAD'
        });

        if ($role === 'auth') {
            return view($viewPath, [
                'title' => 'Login - Figma Export',
                'isFigmaExport' => true,
                'sekolah' => MockData::getSekolah(),
            ]);
        }

        // Shared base data for all layouts
        $baseData = [
            'isFigmaExport' => true,
            'role' => $role,
            'sekolah' => MockData::getSekolah(),
            'tahunAjaranList' => MockData::getTahunAjaran(),
            'taAktif' => '2025/2026 - Ganjil (Aktif)',
            'sistemState' => MockData::getSistemState(),
            'title' => ucwords(str_replace(['-', '_'], ' ', $file)) . ' (' . strtoupper($role) . ')',
        ];

        // Role-specific data resolution
        $data = match($role) {
            'admin' => $this->resolveAdminData($file, $baseData),
            'guru' => $this->resolveGuruData($file, $baseData),
            'tu' => $this->resolveTuData($file, $baseData),
            'siswa' => $this->resolveSiswaData($file, $baseData),
            default => $baseData
        };

        return view($viewPath, $data);
    }

    protected function resolveAdminData(string $file, array $base): array
    {
        $menu = 'dashboard';
        $submenu = '';

        if (str_starts_with($file, 'dashboard')) {
            $menu = 'dashboard';
        } elseif (str_starts_with($file, 'sekolah')) {
            $menu = 'sekolah';
        } elseif (str_starts_with($file, 'tahun-ajaran') || str_starts_with($file, 'wizard') || str_starts_with($file, 'aktivasi-semester')) {
            $menu = 'master_akademik';
            $submenu = 'tahun_ajaran';
        } elseif (str_starts_with($file, 'tingkatan')) {
            $menu = 'master_akademik';
            $submenu = 'tingkatan';
        } elseif (str_starts_with($file, 'jurusan')) {
            $menu = 'master_akademik';
            $submenu = 'jurusan';
        } elseif (str_starts_with($file, 'mapel')) {
            $menu = 'master_akademik';
            $submenu = 'mapel';
        } elseif (str_starts_with($file, 'komponen-nilai')) {
            $menu = 'master_penilaian';
            $submenu = 'komponen_nilai';
        } elseif (str_starts_with($file, 'kriteria-penilaian')) {
            $menu = 'master_penilaian';
            $submenu = 'kriteria_penilaian';
        } elseif (str_starts_with($file, 'sikap') || str_starts_with($file, 'ekskul') || str_starts_with($file, 'prestasi')) {
            $menu = 'master_penilaian';
            $submenu = 'sikap_ekskul_prestasi';
        } elseif (str_starts_with($file, 'kelas')) {
            $menu = 'kelas_penugasan';
            $submenu = 'kelas';
        } elseif (str_starts_with($file, 'penugasan')) {
            $menu = 'kelas_penugasan';
            $submenu = 'penugasan';
        } elseif (str_starts_with($file, 'guru')) {
            $menu = 'data_pengguna';
            $submenu = 'guru';
        } elseif (str_starts_with($file, 'siswa') || str_starts_with($file, 'transkrip')) {
            $menu = 'data_pengguna';
            $submenu = 'siswa';
        } elseif (str_starts_with($file, 'ortu')) {
            $menu = 'data_pengguna';
            $submenu = 'ortu';
        } elseif (str_starts_with($file, 'staff-tu')) {
            $menu = 'data_pengguna';
            $submenu = 'staff_tu';
        } elseif (str_starts_with($file, 'raport')) {
            $menu = 'raport';
        } elseif (str_starts_with($file, 'ujian-sekolah')) {
            $menu = 'ujian_sekolah';
        } elseif (str_starts_with($file, 'kategori-surat')) {
            $menu = 'modul_surat';
            $submenu = 'kategori_surat';
        } elseif (str_starts_with($file, 'format-surat')) {
            $menu = 'modul_surat';
            $submenu = 'format_surat';
        } elseif (str_starts_with($file, 'arsip')) {
            $menu = 'arsip';
        } elseif (str_starts_with($file, 'audit-log')) {
            $menu = 'log_audit';
            $submenu = 'log_audit';
        }

        $allGuru = MockData::getGuru();
        $allSiswa = MockData::getSiswaList();
        $allKelas = MockData::getKelas();
        $kelompokMapel = MockData::getKelompokMapel();
        $kategoriSurat = MockData::getKategoriSurat();

        $tingkatanList = MockData::getTingkatan();
        $jurusanList = MockData::getJurusan();
        $rawMapel = MockData::getMapel();
        $mapelList = array_map(function($m) {
            $m['nama'] = $m['nama_mapel'] ?? ($m['nama'] ?? '');
            $m['kode'] = $m['kode_mapel'] ?? ($m['kode'] ?? '');
            return $m;
        }, $rawMapel);
        $komponenList = MockData::getKomponenNilai()['pengetahuan'] ?? [];
        $kriteriaList = MockData::getKriteriaPenilaian();
        $sikapList = MockData::getJenisSikap();
        $ekskulList = MockData::getJenisEkstrakurikuler();
        $prestasiList = MockData::getJenisPrestasi();
        $staffTuList = MockData::getStaffTu();
        $penugasanList = MockData::getPengajaran();
        $formatList = MockData::getFormatNomorSurat();
        $arsipData = MockData::getArsipData();

        $ortuList = [];
        foreach ($allSiswa as $s) {
            if (!empty($s['ortu'])) {
                foreach ($s['ortu'] as $o) {
                    $ortuList[] = [
                        'nama' => $o['nama'],
                        'jenis' => ucfirst($o['jenis']),
                        'telepon' => $o['telepon'],
                        'pekerjaan' => $o['pekerjaan'],
                        'anak' => $s['nama'],
                        'kelas' => $s['kelas'] ?? 'XI-MIPA-1',
                    ];
                }
            }
        }

        $s1 = $allSiswa[0] ?? [];
        $g1 = $allGuru[0] ?? [];
        $k1 = $allKelas[0] ?? [];
        $k1['wali_kelas_nama'] = $k1['wali_kelas'] ?? 'Ustadz Hendra Gunawan, M.Pd.';
        $k1['tingkatan_nama'] = $k1['tingkat'] ?? 'Kelas 11 (Fase F)';
        $k1['kapasitas_max'] = $k1['kapasitas'] ?? 32;

        $transkripLengkap = MockData::getTranskripLengkapSiswa(1);

        $lockedRaportList = [];
        foreach ($allSiswa as $idx => $s) {
            if ($idx < 5) {
                $lockedRaportList[] = [
                    'id' => $s['id'],
                    'siswa_id' => $s['id'],
                    'nis' => $s['nis'],
                    'nama_siswa' => $s['nama'],
                    'siswa_nama' => $s['nama'],
                    'kelas' => $s['kelas'] ?? 'XI-MIPA-1',
                    'semester' => 'Ganjil 2025/2026',
                    'finalized_at' => '2025-12-19 10:30',
                    'finalized_by' => 'Ustadz Hendra Gunawan, M.Pd.',
                ];
            }
        }

        $kelasForView = ($file === 'kelas-detail') ? $k1 : $allKelas;

        return array_merge($base, [
            'menu' => $menu,
            'submenu' => $submenu,
            'stats' => [
                'total_siswa' => count($allSiswa),
                'total_guru' => count($allGuru),
                'total_kelas' => count($allKelas),
                'ta_status' => '2025/2026 Ganjil (Aktif)'
            ],
            'sekolahData' => MockData::getSekolah(),
            'tahunAjaran' => MockData::getTahunAjaran(),
            'tahunAjaranList' => MockData::getTahunAjaran(),
            'ta_list' => MockData::getTahunAjaran(),
            'tingkatan' => $tingkatanList,
            'tingkatan_list' => $tingkatanList,
            'tingkatanList' => $tingkatanList,
            'jurusan' => $jurusanList,
            'jurusanList' => $jurusanList,
            'mapelList' => $mapelList,
            'mapel' => $mapelList,
            'selectedKelompok' => $kelompokMapel[0] ?? ['id' => 1, 'nama' => 'Kelompok A (Wajib)', 'kode' => 'A'],
            'komponenList' => $komponenList,
            'activeAspek' => 'pengetahuan',
            'kriteriaList' => $kriteriaList,
            'kriteriaPenilaianList' => $kriteriaList,
            'sikapList' => $sikapList,
            'aspekSikap' => $sikapList,
            'ekskulList' => $ekskulList,
            'prestasiList' => $prestasiList,
            'activeTab' => 'alumni',
            'kelasList' => $allKelas,
            'kelas' => $kelasForView,
            'siswaInKelas' => $allSiswa,
            'kelasDetail' => [
                'id' => 1,
                'nama' => 'XI-MIPA-1',
                'tingkat' => '11',
                'jurusan' => 'MIPA',
                'wali_kelas' => 'Ustadz Hendra Gunawan, M.Pd.',
                'kapasitas' => 32,
                'jumlah_siswa' => 31,
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Ganjil',
                'daftar_siswa' => $allSiswa,
            ],
            'guruList' => $allGuru,
            'guru' => $allGuru,
            'isEdit' => false,
            'siswaList' => $allSiswa,
            'siswa' => $s1,
            'raport' => MockData::getRaportSiswa(1),
            'riwayatKelas' => MockData::getRiwayatKelasBySiswa(1),
            'ortuList' => $ortuList,
            'staffTuList' => $staffTuList,
            'staffList' => $staffTuList,
            'penugasanList' => $penugasanList,
            'kelompokList' => $kelompokMapel,
            'kategoriList' => $kategoriSurat,
            'kategoriSuratList' => $kategoriSurat,
            'formatList' => $formatList,
            'formatNomorList' => $formatList,
            'arsip' => $arsipData,
            'arsipList' => $arsipData,
            'suratMasuk' => MockData::getSuratMasuk(),
            'suratKeluar' => MockData::getSuratKeluar(),
            'auditNilai' => MockData::getLogPerubahanNilai(),
            'logPerubahanNilai' => MockData::getLogPerubahanNilai(),
            'sistemLogs' => [
                ['id' => 101, 'kategori' => 'Tahun Ajaran', 'aktivitas' => 'Verifikasi Kunci Sidang Pleno Kenaikan Kelas', 'pelaku' => 'Admin (Super Administrator)', 'waktu' => '2025-12-19 14:00:00', 'status' => 'Sukses', 'detail' => 'Seluruh rombel dinyatakan tuntas pleno.'],
                ['id' => 102, 'kategori' => 'Raport', 'aktivitas' => 'Pengesahan Tanda Tangan Digital Raport', 'pelaku' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)', 'waktu' => '2025-12-19 15:30:00', 'status' => 'Sukses', 'detail' => 'Raport siswa Muhammad Raihan Pratama disahkan.'],
            ],
            'formula' => MockData::getFormulaKelulusan(),
            'ujianData' => MockData::getUjianSekolahData(),
            'ujianList' => MockData::getUjianSekolahData(),
            'transkrip' => $transkripLengkap,
            'unlockRequestsPending' => MockData::getUnlockRequests(),
            'lockedRaportList' => $lockedRaportList,
            'isSemuaPlenoSelesai' => true,
            'belumPleno' => [
                ['nama_kelas' => 'XI-IPS-2', 'wali_kelas' => 'Siti Rahmah, S.Pd.', 'status_pleno' => 'belum_mulai'],
                ['nama_kelas' => 'X-3', 'wali_kelas' => 'Ahmad Shodiq, M.Ag.', 'status_pleno' => 'sedang_berlangsung'],
            ],
            'totalRombel' => 12,
            'plenoSelesaiCount' => 10,
            'currentSem' => 'Ganjil',
            'nextSem' => 'Genap',
            'semesterAktif' => 'Ganjil',
            'step' => 1,
            'tingkatanOptions' => $tingkatanList,
            'jurusanOptions' => $jurusanList,
            'waliOptions' => $allGuru,
            'raportGanjilFinalCount' => 7,
            'unlockPendingCount' => 1,
            'totalKelas' => 7,
            'pengecualianGuru' => [
                ['nama' => 'Ustadz Budi Rahardjo, S.Si.', 'mapel' => 'Fisika XI-MIPA-1', 'status' => 'Cuti Belajar', 'rekomendasi' => 'Perlu penunjukan guru pengganti sebelum semester genap dimulai']
            ],
            'pengecualianSiswa' => [
                ['nama' => 'Aditya Pratama', 'nis' => '232410050', 'kelas_asal' => 'XI-MIPA-2', 'status' => 'Pindah Keluar (Mutasi)', 'keterangan' => 'Mutasi keluar per 10 Januari 2025 ke SMA Negeri 3 Bandung. Tidak dialokasikan ke semester genap.']
            ],
        ]);
    }

    protected function resolveGuruData(string $file, array $base): array
    {
        $menu = 'dashboard';
        $submenu = '';
        $variant = 'wali';

        if (str_starts_with($file, 'dashboard-mode-wali')) {
            $menu = 'dashboard';
            $submenu = 'wali';
            $variant = 'wali';
        } elseif (str_starts_with($file, 'dashboard-mode-mapel')) {
            $menu = 'dashboard';
            $submenu = 'mapel';
            $variant = 'mapel';
        } elseif (str_starts_with($file, 'mapel')) {
            $menu = 'mapel_saya';
        } elseif (str_starts_with($file, 'nilai')) {
            $menu = 'input_nilai';
        } elseif (str_starts_with($file, 'tugas')) {
            $menu = 'tugas_harian';
        } elseif (str_starts_with($file, 'presensi')) {
            $menu = 'presensi_kelas';
        } elseif (str_starts_with($file, 'analitik')) {
            $menu = 'analitik';
        } elseif (str_starts_with($file, 'perwalian')) {
            $menu = 'kelas_perwalian';
        } elseif (str_starts_with($file, 'leger')) {
            $menu = 'leger_nilai';
        } elseif (str_starts_with($file, 'kenaikan-kelas')) {
            $menu = 'kenaikan_kelas';
        } elseif (str_starts_with($file, 'raport-generate')) {
            $menu = 'raport';
            $submenu = 'generate';
        } elseif (str_starts_with($file, 'raport-tinjau')) {
            $menu = 'raport';
            $submenu = 'tinjau';
        } elseif (str_starts_with($file, 'raport-buka-kunci')) {
            $menu = 'raport';
            $submenu = 'buka_kunci';
        }

        $allSiswa = MockData::getSiswaList();
        $tugasList = MockData::getTugasHarian(1);
        $t1 = $tugasList[0] ?? [];
        $t1['rata_rata'] = 84.5;
        $t1['tertinggi'] = 98.0;
        $t1['terendah'] = 70.0;
        $t1['tuntas_count'] = 29;
        $t1['belum_tuntas_count'] = 2;

        $rawPengajaran = MockData::getPengajaran();
        $pengajaranList = array_map(function($p, $idx) {
            $p['mapel'] = $p['mapel_nama'] ?? 'Matematika (Wajib)';
            $p['guru'] = $p['guru_nama'] ?? 'Ustadz Hendra Gunawan, M.Pd.';
            $p['status'] = ($idx === 1) ? 'belum_lengkap' : 'lengkap';
            $p['terisi'] = ($idx === 1) ? 28 : 31;
            $p['total'] = 31;
            return $p;
        }, $rawPengajaran, array_keys($rawPengajaran));
        $p1 = $pengajaranList[0] ?? [];
        $rekapTugas = MockData::getRekapTugasDanUH(1);
        $rekapPresensi = MockData::getRekapPresensiMapel(1);
        $pertemuanList = $rekapPresensi['pertemuan_list'] ?? MockData::getDefaultPertemuanList(1);
        $detailMap = MockData::getDefaultPresensiDetailMap(1, 1);
        $rekapData = str_starts_with($file, 'tugas') ? $rekapTugas : MockData::getRekapPresensiMapel(1, $pertemuanList, $detailMap);

        $kenaikan = MockData::getKenaikanKelasList('XI-MIPA-1');
        $siswaKenaikan = [];
        foreach ($allSiswa as $s) {
            $siswaKenaikan[] = [
                'id' => $s['id'],
                'siswa_id' => $s['id'],
                'nama' => $s['nama'],
                'nis' => $s['nis'],
                'kelas_asal' => 'XI-MIPA-1',
                'kelas_tujuan' => 'XII-MIPA-1',
                'status' => 'naik',
                'catatan' => 'Tuntas KKM & Kehadiran Baik',
                'is_tuntas' => true,
                'rata_rata' => 86.5,
            ];
        }

        $siswaPresensi = array_map(function($s) {
            return [
                'siswa_id' => $s['id'],
                'nama' => $s['nama'],
                'nis' => $s['nis'],
                'foto_path' => $s['foto'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                'status' => 'H',
                'catatan' => '',
            ];
        }, $allSiswa);

        $defaultDetails = MockData::getNilaiTugasDetail(1, 1);
        $detailBySiswa = [];
        foreach ($defaultDetails as $d) {
            $detailBySiswa[$d['siswa_id']] = $d;
        }
        $siswaNilaiList = [];
        foreach ($allSiswa as $s) {
            if (isset($detailBySiswa[$s['id']])) {
                $siswaNilaiList[] = $detailBySiswa[$s['id']];
            } else {
                $nilai = ($s['id'] % 7 === 0) ? 68.0 : 85.0;
                $siswaNilaiList[] = [
                    'siswa_id' => $s['id'],
                    'nis' => $s['nis'],
                    'nama' => $s['nama'],
                    'foto_path' => $s['foto'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($s['nama']),
                    'nilai' => $nilai,
                    'catatan' => ($nilai < 75) ? 'Perlu perbaikan konsep' : 'Sangat baik',
                    'is_tuntas' => ($nilai >= 75),
                ];
            }
        }

        $raport = MockData::getRaportSiswa(1);
        $matrixNilai = MockData::getSiswaNilaiMatrix(1, 'pengetahuan');

        $pFirst = $pertemuanList[0] ?? ['pertemuan_ke' => 1, 'tanggal' => '2025-07-21', 'materi' => 'Konsep Matriks Dasar', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00'];
        $pFirst['id'] = 1;

        $legerData = MockData::getLegerNilaiKelas('XI-MIPA-1');

        return array_merge($base, [
            'namaGuru' => 'Ustadz Hendra Gunawan, M.Pd.',
            'kelasWali' => 'XI-MIPA-1',
            'isWaliKelas' => true,
            'menu' => $menu,
            'submenu' => $submenu,
            'variant' => $variant,
            'stats' => [
                'mapel_diajar' => 2,
                'kelas_diajar' => 3,
                'total_siswa' => count($allSiswa),
                'raport_progress' => 85,
                'overall_avg' => 84.5,
                'rata_rata' => 84.5,
                'tertinggi' => 98.0,
                'terendah' => 70.0,
                'tuntas_count' => 29,
                'remedial_count' => 2,
                'ketuntasan_persen' => 96.8,
                'tuntas_percent' => 96.8,
                'min_avg' => 70.0,
                'max_avg' => 98.0,
                'avg_tugas' => 84.5,
            ],
            'pengingat' => [
                ['judul' => 'Ulangan Harian 2 (Matriks) XI-MIPA-1', 'status' => 'Belum lengkap (30/31)', 'tipe' => 'warning'],
                ['judul' => 'Tugas 3 Proyek Terapan Belum Dinilai', 'status' => '3 hari tersisa', 'tipe' => 'info'],
            ],
            'mapelList' => $pengajaranList,
            'pengajaranList' => $pengajaranList,
            'pengajaran' => $p1,
            'activeAspek' => 'pengetahuan',
            'komponenList' => MockData::getKomponenNilai()['pengetahuan'] ?? [],
            'nilaiMatrix' => $matrixNilai,
            'siswaList' => $allSiswa,
            'totalSiswa' => count($allSiswa),
            'siswaPresensi' => $siswaPresensi,
            'siswaNilaiList' => $siswaNilaiList,
            'siswaNilai' => $siswaNilaiList,
            'tugasList' => $tugasList,
            'tugas' => $t1,
            'rekapTugas' => $rekapTugas,
            'rekapPresensi' => $rekapPresensi,
            'rekapData' => $rekapData,
            'siswaKritis' => [],
            'pertemuanList' => $pertemuanList,
            'pertemuan' => $pFirst,
            'detailMap' => $detailMap,
            'presensiDetailMap' => $detailMap,
            'analitik' => [
                'rata_rata_kelas' => 84.2,
                'nilai_tertinggi' => 96,
                'nilai_terendah' => 70,
                'tuntas_count' => 29,
                'belum_tuntas_count' => 2,
                'distribusi' => ['A' => 12, 'B' => 17, 'C' => 2, 'D' => 0],
            ],
            'siswaBawahKkm' => [
                ['nis' => '242510005', 'nama' => 'Aldi Kurniawan', 'nilai_akhir' => 72.5, 'kkm' => 75.0, 'rekomendasi' => 'Remedial UTS & Tugas Tambahan'],
                ['nis' => '242510019', 'nama' => 'Bagas Firmansyah', 'nilai_akhir' => 70.0, 'kkm' => 75.0, 'rekomendasi' => 'Remedial UAS & Bimbingan Matriks'],
            ],
            'activeTab' => 'sikap',
            'aspekSikap' => MockData::getJenisSikap(),
            'daftarEkskul' => MockData::getJenisEkstrakurikuler(),
            'daftarPrestasi' => MockData::getJenisPrestasi(),
            'absensiData' => MockData::getDefaultAbsensiPerwalian('XI-MIPA-1'),
            'rekapAbsensi' => [
                'sakit' => 2,
                'izin' => 1,
                'tanpa_keterangan' => 0,
            ],
            'legerData' => $legerData,
            'mapelHeader' => MockData::getLegerMapelList('XI-MIPA-1'),
            'kenaikanData' => $kenaikan,
            'siswaKenaikan' => $siswaKenaikan,
            'siswaKelulusan' => $kenaikan['siswa_kelulusan'] ?? [],
            'isDisahkanSemua' => false,
            'raportList' => [
                ['id' => 1, 'siswa' => $allSiswa[0], 'status' => 'draft', 'kelengkapan' => 100],
                ['id' => 2, 'siswa' => $allSiswa[1] ?? $allSiswa[0], 'status' => 'menunggu_persetujuan_kepsek', 'kelengkapan' => 100],
                ['id' => 3, 'siswa' => $allSiswa[2] ?? $allSiswa[0], 'status' => 'final', 'kelengkapan' => 100],
            ],
            'kelengkapanInfo' => [
                'persen' => 85,
                'mapel_belum' => ['Fisika (Ustadz Budi)', 'Bahasa Sunda'],
                'boleh_generate' => false
            ],
            'raport' => $raport,
            'currentSiswaId' => 1,
            'catatanPenolakan' => '',
            'unlockRequests' => MockData::getUnlockRequests(),
        ]);
    }

    protected function resolveTuData(string $file, array $base): array
    {
        $menu = 'dashboard';
        $submenu = '';

        if (str_starts_with($file, 'dashboard')) {
            $menu = 'dashboard';
        } elseif (str_starts_with($file, 'surat-masuk')) {
            $menu = 'surat_masuk';
            $submenu = str_contains($file, 'form') ? 'tambah' : 'list';
        } elseif (str_starts_with($file, 'surat-keluar')) {
            $menu = 'surat_keluar';
            $submenu = str_contains($file, 'form') ? 'tambah' : 'list';
        } elseif (str_starts_with($file, 'arsip')) {
            $menu = 'arsip_surat';
        } elseif (str_starts_with($file, 'buku-agenda')) {
            $menu = 'buku_agenda';
        }

        $smList = MockData::getSuratMasuk();
        $skList = MockData::getSuratKeluar();
        $arsipData = MockData::getArsipData();
        $sm1 = $smList[0] ?? [];
        $sk1 = $skList[0] ?? [];

        // Enrich $sk1 with required detail view attributes
        if (empty($sk1['dibuat_oleh'])) {
            $sk1['dibuat_oleh'] = 'M. Taufik Hidayat, S.Sos. (TU)';
        }
        if (empty($sk1['ditandatangani_oleh'])) {
            $sk1['ditandatangani_oleh'] = 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)';
        }
        if (empty($sk1['nomor_draft'])) {
            $sk1['nomor_draft'] = 'DRAFT-2025-0012';
        }

        $suratTarget = str_starts_with($file, 'surat-keluar') ? $sk1 : $sm1;

        $agendaItems = [];
        $no = 1;
        foreach ($smList as $sm) {
            $agendaItems[] = [
                'no' => $no++,
                'jenis' => 'Surat Masuk',
                'nomor_agenda' => $sm['nomor_agenda'],
                'nomor_surat' => $sm['nomor_surat'],
                'tanggal' => $sm['tanggal_diterima'],
                'pengirim_tujuan' => $sm['pengirim'],
                'perihal' => $sm['perihal'],
                'status' => $sm['status']
            ];
        }
        foreach ($skList as $sk) {
            $agendaItems[] = [
                'no' => $no++,
                'jenis' => 'Surat Keluar',
                'nomor_agenda' => '-',
                'nomor_surat' => $sk['nomor_surat'],
                'tanggal' => $sk['tanggal_surat'],
                'pengirim_tujuan' => $sk['tujuan'],
                'perihal' => $sk['perihal'],
                'status' => $sk['status']
            ];
        }

        return array_merge($base, [
            'namaTu' => 'M. Taufik Hidayat, S.Sos.',
            'jabatanTu' => 'Kepala Tata Usaha',
            'menu' => $menu,
            'submenu' => $submenu,
            'activeTab' => 'semua',
            'periode' => 'Semester Ganjil TA 2025/2026',
            'suratMasukList' => $smList,
            'suratKeluarList' => $skList,
            'suratMasuk' => $smList,
            'suratKeluar' => $skList,
            'suratMasukTerbaru' => array_slice($smList, 0, 3),
            'suratKeluarTerbaru' => array_slice($skList, 0, 3),
            'disposisiDeadline' => [
                ['nomor_agenda' => 'SM-2025-00142', 'pengirim' => 'Dinas Pendidikan Jabar', 'penerima' => 'Drs. H. Ahmad Fauzi (Kepsek)', 'batas_waktu' => '2025-11-28', 'status' => 'Mendekati Batas Waktu', 'badge' => 'bg-warning text-dark'],
                ['nomor_agenda' => 'SM-2025-00139', 'pengirim' => 'BPJS Ketenagakerjaan', 'penerima' => 'M. Taufik Hidayat (TU)', 'batas_waktu' => '2025-11-25', 'status' => 'Lewat Batas Waktu', 'badge' => 'bg-danger'],
            ],
            'arsip' => $arsipData,
            'arsipSuratList' => $arsipData,
            'surat' => $suratTarget,
            'kategoriList' => MockData::getKategoriSurat(),
            'formatList' => MockData::getFormatNomorSurat(),
            'nextAgenda' => 'SM-2025-00146',
            'nextNomor' => '105/SMA-FI/TU/XII/2025',
            'agendaItems' => $agendaItems,
            'stats' => [
                'surat_masuk_bulan_ini' => 18,
                'menunggu_disposisi' => 3,
                'menunggu_ttd' => 2,
                'surat_keluar_terkirim' => 14,
            ],
            'tahun' => '2025',
            'bulan' => '09',
            'jenis' => 'semua',
        ]);
    }

    protected function resolveSiswaData(string $file, array $base): array
    {
        $menu = 'beranda';
        $submenu = '';

        if (str_starts_with($file, 'beranda')) {
            $menu = 'beranda';
        } elseif (str_starts_with($file, 'profil')) {
            $menu = 'profil';
        } elseif (str_starts_with($file, 'nilai')) {
            $menu = 'nilai';
        } elseif (str_starts_with($file, 'status')) {
            $menu = 'status';
        } elseif (str_starts_with($file, 'raport')) {
            $menu = 'raport';
        } elseif (str_starts_with($file, 'transkrip')) {
            $menu = 'transkrip';
        }

        $allSiswa = MockData::getSiswaList();
        $siswa = $allSiswa[0] ?? [];
        $raport = MockData::getRaportSiswa(1);
        $transkrip = MockData::getTranskripLengkapSiswa(1);
        $riwayatKelas = MockData::getRiwayatKelasBySiswa(1);
        $komponenNilai = MockData::getKomponenNilai();

        return array_merge($base, [
            'menu' => $menu,
            'submenu' => $submenu,
            'siswa' => $siswa,
            'variant' => 'berjalan',
            'aspek' => 'pengetahuan',
            'activeAspek' => 'pengetahuan',
            'raport' => $raport,
            'komponenNilai' => $komponenNilai['pengetahuan'] ?? [],
            'riwayatKelas' => $riwayatKelas,
            'ringkasanNilai' => [
                ['mapel' => 'Matematika (Wajib)', 'nilai' => 92.5, 'predikat' => 'A'],
                ['mapel' => 'Matematika Peminatan', 'nilai' => 93.0, 'predikat' => 'A'],
                ['mapel' => 'Bahasa Arab / Tahfidz', 'nilai' => 94.0, 'predikat' => 'A'],
                ['mapel' => 'Kimia', 'nilai' => 90.0, 'predikat' => 'B'],
                ['mapel' => 'Fisika', 'nilai' => 87.0, 'predikat' => 'B'],
            ],
            'semesterBerjalan' => 'Ganjil',
            'tahunAjaranBerjalan' => '2025/2026',
            'statusBerjalan' => [
                'status' => 'Aktif Belajar',
                'status_badge' => 'bg-success',
                'rombel' => 'XI-MIPA-1',
                'tingkatan' => 'Kelas 11 (Tingkat Menengah)',
                'wali_kelas' => 'Ustadz Hendra Gunawan, M.Pd.',
                'semester' => 'Semester Ganjil',
                'tahun_ajaran' => '2025/2026',
                'kehadiran_persen' => 96.8,
                'total_mapel' => 15,
                'catatan_disiplin' => 'Sangat Baik (A) - Tidak ada catatan pelanggaran tata tertib.',
                'keterangan' => 'Saat ini Ananda tercatat sebagai peserta didik aktif pada Semester Ganjil Tahun Ajaran 2025/2026. Seluruh kegiatan pembelajaran berjalan sesuai kalender akademik.',
                'jadwal_kenaikan' => 'Juni 2026 (Akhir Semester Genap)',
                'status_lalu' => [
                    'periode' => 'T.A. 2024/2025 (Genap)',
                    'keputusan' => 'TUNTAS NAIK TINGKAT',
                    'keterangan' => 'Naik dari Kelas X-MIPA-1 ke Kelas XI-MIPA-1 (Disahkan 20 Juni 2025)'
                ]
            ],
            'statusKenaikan' => [
                'status' => 'NAIK KE KELAS XII',
                'status_label' => 'NAIK KE KELAS XII',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Genap (Akhir Tahun Ajaran)',
                'kelas_tujuan' => 'XII-MIPA-1',
                'tanggal_keputusan' => '19 Juni 2026',
                'catatan' => 'Selamat! Ananda dinyatakan memenuhi seluruh kriteria kenaikan kelas dengan prestasi Sangat Memuaskan (Peringkat 1 Umum).',
                'keterangan' => 'Berdasarkan ketetapan Dewan Guru dan Kepala Sekolah SMA IT Fithrah Insani.',
                'syarat' => [
                    ['kriteria' => 'Ketuntasan Seluruh Mata Pelajaran', 'status' => 'Memenuhi KKM', 'keterangan' => 'Seluruh 15 mapel tuntas (nilai >= KKM 75.00)'],
                    ['kriteria' => 'Nilai Sikap Spiritual & Sosial Minimal', 'status' => 'Sangat Baik (A)', 'keterangan' => 'Predikat A dari seluruh dewan guru pengampu'],
                    ['kriteria' => 'Persentase Kehadiran Efektif', 'status' => '96.8%', 'keterangan' => 'Hadir 15 sesi, Sakit 1, Tanpa Keterangan 0 (Batas min. 85%)'],
                ]
            ],
            'statusKelulusan' => [
                'status' => 'LULUS',
                'status_label' => 'LULUS DARI SATUAN PENDIDIKAN',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Genap (Akhir Jenjang SMA)',
                'tanggal_keputusan' => '19 Juni 2026',
                'nomor_ijazah' => 'DN-02/M-SMA/26/001234',
                'bobot_rapor' => 60,
                'rata_rapor' => 90.5,
                'bobot_us' => 40,
                'rata_us' => 93.7,
                'rata_rata_akhir' => 91.8,
                'nilai_sekolah' => 91.8,
                'keterangan' => 'Selamat! Ananda dinyatakan LULUS dari SMA IT Fithrah Insani berdasarkan akumulasi nilai rapor 6 semester dan Ujian Sekolah.',
                'syarat' => [
                    ['kriteria' => 'Menyelesaikan Seluruh Program Pembelajaran (Semester 1-6)', 'status' => 'Tuntas 100%', 'keterangan' => 'Lengkap 6 semester'],
                    ['kriteria' => 'Memperoleh Nilai Sikap/Perilaku Minimal Baik', 'status' => 'Sangat Baik (A)', 'keterangan' => 'Predikat memuaskan'],
                    ['kriteria' => 'Lulus Ujian Sekolah (Teori & Praktik)', 'status' => 'Rata-rata 87.50', 'keterangan' => 'Melampaui KKM 75.00'],
                    ['kriteria' => 'Nilai Sekolah Akhir (Rapor 60% + US 40%)', 'status' => '88.85', 'keterangan' => 'Memenuhi ambang batas minimal kelulusan'],
                ]
            ],
            'riwayatRaport' => [
                ['id' => 1, 'tahun_ajaran' => '2024/2025', 'semester' => 'Ganjil', 'kelas' => 'X-MIPA-1', 'status_label' => 'Raport Final', 'is_ready' => true],
                ['id' => 2, 'tahun_ajaran' => '2024/2025', 'semester' => 'Genap', 'kelas' => 'X-MIPA-1', 'status_label' => 'Raport Final', 'is_ready' => true],
                ['id' => 3, 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil', 'kelas' => 'XI-MIPA-1', 'status_label' => 'Raport Final', 'is_ready' => true],
            ],
            'transkrip' => $transkrip,
        ]);
    }
}
