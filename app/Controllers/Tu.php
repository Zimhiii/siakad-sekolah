<?php

namespace App\Controllers;

use App\Libraries\MockData;

class Tu extends BaseController
{
    protected array $commonData;

    public function __construct()
    {
        $this->commonData = [
            'role' => 'tu',
            'sekolah' => MockData::getSekolah(),
            'taAktif' => '2025/2026 - Ganjil (Aktif)',
            'namaTu' => 'M. Taufik Hidayat, S.Sos.',
            'jabatanTu' => 'Kepala Tata Usaha',
        ];
    }

    public function index()
    {
        return $this->dashboard();
    }

    // 1. Dashboard TU
    public function dashboard()
    {
        $suratMasuk = MockData::getSuratMasuk();
        $suratKeluar = MockData::getSuratKeluar();

        $data = array_merge($this->commonData, [
            'title' => 'Dashboard Tata Usaha & Persuratan',
            'menu' => 'dashboard',
            'submenu' => '',
            'stats' => [
                'surat_masuk_bulan_ini' => 18,
                'menunggu_disposisi' => 3,
                'menunggu_ttd' => 2,
                'surat_keluar_terkirim' => 14,
            ],
            'disposisiDeadline' => [
                ['nomor_agenda' => 'SM-2025-00142', 'pengirim' => 'Dinas Pendidikan Jabar', 'penerima' => 'Drs. H. Ahmad Fauzi (Kepsek)', 'batas_waktu' => '2025-11-28', 'status' => 'Mendekati Batas Waktu', 'badge' => 'bg-warning text-dark'],
                ['nomor_agenda' => 'SM-2025-00139', 'pengirim' => 'BPJS Ketenagakerjaan', 'penerima' => 'M. Taufik Hidayat (TU)', 'batas_waktu' => '2025-11-25', 'status' => 'Lewat Batas Waktu', 'badge' => 'bg-danger'],
            ],
            'suratMasukTerbaru' => array_slice($suratMasuk, 0, 3),
            'suratKeluarTerbaru' => array_slice($suratKeluar, 0, 3),
        ]);

        return view('tu/dashboard', $data);
    }

    // 2. Surat Masuk - List
    public function suratMasuk()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Daftar Surat Masuk',
            'menu' => 'surat_masuk',
            'submenu' => 'list',
            'suratMasukList' => MockData::getSuratMasuk(),
            'kategoriList' => MockData::getKategoriSurat()
        ]);

        return view('tu/surat_masuk/index', $data);
    }

    // 3. Surat Masuk - Form Tambah
    public function suratMasukTambah()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Catat Surat Masuk Baru',
            'menu' => 'surat_masuk',
            'submenu' => 'tambah',
            'kategoriList' => MockData::getKategoriSurat(),
            'nextAgenda' => 'SM-2025-00145'
        ]);

        return view('tu/surat_masuk/form', $data);
    }

    // 4-5. Surat Masuk - Detail & Disposisi
    public function suratMasukDetail($id = 1)
    {
        $list = MockData::getSuratMasuk();
        $surat = $list[0];
        foreach ($list as $s) {
            if ($s['id'] == $id) {
                $surat = $s;
                break;
            }
        }

        // Filter Akses Dokumen Rahasia
        $userRole = session()->get('role') ?? 'tu';
        if (($surat['sifat'] ?? '') === 'rahasia' && !in_array($userRole, ['admin', 'tu', 'kepsek'])) {
            return redirect()->to(base_url('tu/surat-masuk'))
                ->with('error', 'Akses ditolak: Dokumen ini berstatus RAHASIA dan hanya dapat diakses oleh Administrator, Pimpinan, dan Kepala Tata Usaha.');
        }

        $data = array_merge($this->commonData, [
            'title' => 'Detail Surat Masuk: ' . $surat['nomor_agenda'],
            'menu' => 'surat_masuk',
            'submenu' => '',
            'surat' => $surat,
            'guruList' => MockData::getGuru(),
            'staffList' => MockData::getStaffTu()
        ]);

        return view('tu/surat_masuk/detail', $data);
    }

    private function getMergedSuratKeluar()
    {
        $list = MockData::getSuratKeluar();
        $overrides = session()->get('surat_keluar_overrides') ?? [];
        foreach ($list as &$s) {
            if (isset($overrides[$s['id']])) {
                $s = array_merge($s, $overrides[$s['id']]);
            }
        }
        return $list;
    }

    // 6. Surat Keluar - List
    public function suratKeluar()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Daftar Surat Keluar',
            'menu' => 'surat_keluar',
            'submenu' => 'list',
            'suratKeluarList' => $this->getMergedSuratKeluar(),
            'kategoriList' => MockData::getKategoriSurat()
        ]);

        return view('tu/surat_keluar/index', $data);
    }

    // 7. Surat Keluar - Form Buat
    public function suratKeluarTambah()
    {
        $data = array_merge($this->commonData, [
            'title' => 'Buat Surat Keluar Baru',
            'menu' => 'surat_keluar',
            'submenu' => 'tambah',
            'kategoriList' => MockData::getKategoriSurat(),
            'nextNomor' => '104/SMA-FI/TU/XII/2025'
        ]);

        return view('tu/surat_keluar/form', $data);
    }

    // 8. Surat Keluar - Detail & Status TTD
    public function suratKeluarDetail($id = 1)
    {
        $list = $this->getMergedSuratKeluar();
        $surat = $list[0];
        foreach ($list as $s) {
            if ($s['id'] == $id) {
                $surat = $s;
                break;
            }
        }

        // Filter Akses Dokumen Rahasia (Hanya Admin, Kepala Sekolah, dan TU Berwenang)
        $userRole = session()->get('role') ?? 'tu';
        if (($surat['sifat'] ?? '') === 'rahasia' && !in_array($userRole, ['admin', 'tu', 'kepsek'])) {
            return redirect()->to(base_url('tu/surat-keluar'))
                ->with('error', 'Akses ditolak: Dokumen ini berstatus RAHASIA dan hanya dapat diakses oleh Administrator, Pimpinan, dan Kepala Tata Usaha.');
        }

        $data = array_merge($this->commonData, [
            'title' => 'Detail Surat Keluar: ' . ($surat['nomor_surat'] ?? $surat['nomor_draft']),
            'menu' => 'surat_keluar',
            'submenu' => '',
            'surat' => $surat
        ]);

        return view('tu/surat_keluar/detail', $data);
    }

    // Alur Anti-Bolong: Nomor resmi diterbitkan HANYA saat diajukan TTD
    public function ajukanTtdSuratKeluar($id = 3)
    {
        $counter = session()->get('nomor_surat_counter');
        if (!$counter) {
            $counter = 104;
        } else {
            $counter++;
        }
        session()->set('nomor_surat_counter', $counter);

        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bln = $bulanRomawi[(int)date('n')] ?? 'XII';
        $thn = date('Y');
        $nomorSurat = sprintf('%03d/SMA-FI/TU/%s/%s', $counter, $bln, $thn);

        $overrides = session()->get('surat_keluar_overrides') ?? [];
        $overrides[$id] = [
            'status' => 'menunggu_ttd',
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => date('Y-m-d')
        ];
        session()->set('surat_keluar_overrides', $overrides);

        return redirect()->to(base_url('tu/surat-keluar'))
            ->with('success', 'Draft surat berhasil diajukan untuk TTD Kepala Sekolah. Nomor surat resmi otomatis diterbitkan: ' . $nomorSurat . ' (prinsip nomor anti-bolong).');
    }

    // Alur Pembatalan Draft: Tidak mengonsumsi nomor urut dinas
    public function batalkanDraftSuratKeluar($id = 3)
    {
        $overrides = session()->get('surat_keluar_overrides') ?? [];
        $overrides[$id] = [
            'status' => 'dibatalkan',
            'nomor_surat' => null
        ];
        session()->set('surat_keluar_overrides', $overrides);

        return redirect()->to(base_url('tu/surat-keluar'))
            ->with('info', 'Draft surat dibatalkan. Tidak ada kuota nomor urut surat resmi dinas yang terbuang/bolong.');
    }

    // 9-10. Arsip Surat (Tab Masuk & Keluar)
    public function arsipSurat($tab = 'masuk')
    {
        $tab = ($tab === 'keluar') ? 'keluar' : 'masuk';

        $data = array_merge($this->commonData, [
            'title' => 'Arsip Surat Masuk & Keluar',
            'menu' => 'arsip_surat',
            'submenu' => $tab,
            'activeTab' => $tab,
            'suratMasuk' => MockData::getSuratMasuk(),
            'suratKeluar' => MockData::getSuratKeluar(),
            'kategoriList' => MockData::getKategoriSurat()
        ]);

        return view('tu/arsip/index', $data);
    }

    // 11. Cetak Buku Agenda Surat
    public function bukuAgenda()
    {
        $suratMasuk = MockData::getSuratMasuk();
        $suratKeluar = MockData::getSuratKeluar();

        $agendaItems = [];
        $no = 1;
        foreach ($suratMasuk as $sm) {
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
        foreach ($suratKeluar as $sk) {
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

        $data = array_merge($this->commonData, [
            'title' => 'Buku Agenda Surat Masuk & Keluar',
            'menu' => 'buku_agenda',
            'submenu' => '',
            'periode' => 'Semester Ganjil TA 2025/2026',
            'agendaItems' => $agendaItems
        ]);

        return view('tu/buku_agenda', $data);
    }

    public function saveAction()
    {
        $action = $this->request->getPost('action') ?? 'Surat';
        $redirectUrl = $this->request->getPost('redirect_url') ?? '/tu';
        return redirect()->to($redirectUrl)->with('success', $action . ' berhasil dicatat dan diproses.');
    }
}
