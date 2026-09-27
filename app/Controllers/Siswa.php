<?php

namespace App\Controllers;

use App\Libraries\MockData;

class Siswa extends BaseController
{
    protected array $commonData;

    public function __construct()
    {
        $siswaList = MockData::getSiswaList();
        $siswa = $siswaList[0]; // Muhammad Raihan Pratama

        $activeTa = session()->get('tahun_ajaran_aktif_override') ?? '2025/2026';
        $activeSem = session()->get('semester_aktif_override') ?? 'Ganjil';

        $this->commonData = [
            'role' => 'siswa',
            'sekolah' => MockData::getSekolah(),
            'taAktif' => $activeTa . ' - ' . $activeSem . ' (Aktif)',
            'siswa' => $siswa,
        ];
    }

    public function index()
    {
        return $this->beranda();
    }

    // 1. Beranda Siswa
    public function beranda()
    {
        $raport = MockData::getRaportSiswa(1);
        $statusOverride = session()->get('raport_status_1');
        if ($statusOverride) {
            $raport['status'] = $statusOverride;
        }

        $data = array_merge($this->commonData, [
            'title' => 'Beranda Siswa',
            'menu' => 'beranda',
            'submenu' => '',
            'raport' => $raport,
            'ringkasanNilai' => [
                ['mapel' => 'Matematika (Wajib)', 'nilai' => 92.5, 'predikat' => 'A'],
                ['mapel' => 'Matematika Peminatan', 'nilai' => 93.0, 'predikat' => 'A'],
                ['mapel' => 'Bahasa Arab / Tahfidz', 'nilai' => 94.0, 'predikat' => 'A'],
                ['mapel' => 'Kimia', 'nilai' => 90.0, 'predikat' => 'B'],
                ['mapel' => 'Fisika', 'nilai' => 87.0, 'predikat' => 'B'],
            ]
        ]);

        return view('siswa/beranda', $data);
    }

    // 2. Profil Saya
    public function profil()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Profil Saya',
            'menu' => 'profil',
            'submenu' => '',
            'riwayatKelas' => MockData::getRiwayatKelasBySiswa(1),
        ]);

        return view('siswa/profil', $data);
    }

    // 3. Transparansi Nilai Semester Siswa
    public function nilai($aspek = 'pengetahuan')
    {
        $aspek = ($aspek === 'keterampilan') ? 'keterampilan' : 'pengetahuan';
        $raport = MockData::getRaportSiswa(1);

        $data = array_merge($this->commonData, [
            'title' => 'Transparansi Nilai Hasil Belajar',
            'menu' => 'nilai',
            'submenu' => '',
            'aspek' => $aspek,
            'activeAspek' => $aspek,
            'raport' => $raport,
            'komponenNilai' => MockData::getKomponenNilai()[$aspek],
        ]);

        return view('siswa/nilai', $data);
    }

    // 4-6. Status Akademik & Kenaikan / Kelulusan
    public function statusAkademik($variant = 'berjalan')
    {
        // Normalisasi varian
        if ($variant === 'biasa' || $variant === 'kenaikan') {
            $variant = 'kenaikan';
        } elseif ($variant === 'akhir' || $variant === 'kelulusan') {
            $variant = 'kelulusan';
        } else {
            $variant = 'berjalan';
        }

        $activeTa = session()->get('tahun_ajaran_aktif_override') ?? '2025/2026';
        $activeSem = session()->get('semester_aktif_override') ?? 'Ganjil';

        $data = array_merge($this->commonData, [
            'title' => 'Status Akademik Peserta Didik',
            'menu' => 'status',
            'submenu' => '',
            'variant' => $variant,
            'semesterBerjalan' => $activeSem,
            'tahunAjaranBerjalan' => $activeTa,
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
            ]
        ]);

        return view('siswa/status', $data);
    }

    // 7. Raport - List per Semester
    public function raportList()
    {
        $statusSiswa1 = session()->get('raport_status_1') ?? 'draft';
        $labelMap = [
            'draft' => 'Sedang Diproses Wali Kelas',
            'menunggu_persetujuan_kepsek' => 'Menunggu Pengesahan Kepsek',
            'final' => 'Raport Final / Diterbitkan'
        ];

        $riwayatRaport = [
            [
                'id' => 1,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2025/2026',
                'kelas' => 'XI-MIPA-1',
                'status' => $statusSiswa1,
                'status_label' => $labelMap[$statusSiswa1] ?? 'Sedang Diproses Wali Kelas',
                'is_ready' => ($statusSiswa1 === 'final')
            ],
            ['id' => 2, 'semester' => 'Genap', 'tahun_ajaran' => '2024/2025', 'kelas' => 'X-MIPA-1', 'status' => 'final', 'status_label' => 'Raport Final', 'is_ready' => true],
            ['id' => 3, 'semester' => 'Ganjil', 'tahun_ajaran' => '2024/2025', 'kelas' => 'X-MIPA-1', 'status' => 'final', 'status_label' => 'Raport Final', 'is_ready' => true],
        ];

        $data = array_merge($this->commonData, [
            'title' => 'Raport Digital per Semester',
            'menu' => 'raport',
            'submenu' => '',
            'riwayatRaport' => $riwayatRaport
        ]);

        return view('siswa/raport_list', $data);
    }

    // 8. Raport - Preview Detail (Paper View)
    public function raportPreview($id = 1)
    {
        $raport = MockData::getRaportSiswa(1);
        if ($id > 1) {
            $raport['status'] = 'final';
            $raport['approval_kepsek']['status'] = 'disahkan';
            $raport['approval_kepsek']['disahkan_pada'] = '2025-06-20 10:00:00';
        } else {
            $statusOverride = session()->get('raport_status_1');
            if ($statusOverride) {
                $raport['status'] = $statusOverride;
            }
            if ($raport['status'] === 'final') {
                $raport['approval_kepsek']['status'] = 'disahkan';
                $raport['approval_kepsek']['disahkan_pada'] = '2025-12-19 15:30:00';
            }
        }

        $data = array_merge($this->commonData, [
            'title' => 'Lembar Raport Digital: ' . $raport['siswa']['nama'],
            'menu' => 'raport',
            'submenu' => '',
            'raport' => $raport
        ]);

        return view('siswa/raport_preview', $data);
    }

    // 9. Transkrip Nilai Kumulatif 6 Semester (Akumulasi Capaian Belajar)
    public function transkrip()
    {
        $transkrip = MockData::getTranskripLengkapSiswa(1);

        $data = array_merge($this->commonData, [
            'title' => 'Transkrip Nilai Kumulatif 6 Semester',
            'menu' => 'transkrip',
            'submenu' => '',
            'transkrip' => $transkrip,
            'formula' => MockData::getFormulaKelulusan(),
        ]);

        return view('siswa/transkrip', $data);
    }

    public function transkripLengkap()
    {
        return $this->transkrip();
    }
}
