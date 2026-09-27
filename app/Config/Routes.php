<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('auth', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::doLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/switch/(:segment)', 'Auth::switchRole/$1');

// Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('', 'Admin::dashboard');
    $routes->get('/', 'Admin::dashboard');
    $routes->get('sekolah', 'Admin::sekolah');
    
    // Tahun Ajaran & Wizard 6 Langkah
    $routes->get('tahun-ajaran', 'Admin::tahunAjaran');
    $routes->get('wizard', 'Admin::wizard');
    $routes->get('wizard/(:num)', 'Admin::wizard/$1');
    $routes->get('aktivasi-semester-genap', 'Admin::aktivasiSemesterGenap');
    $routes->post('aktivasi-semester-genap', 'Admin::doAktivasiSemesterGenap');
    
    // Master Akademik & Penilaian
    $routes->get('tingkatan', 'Admin::tingkatan');
    $routes->get('jurusan', 'Admin::jurusan');
    $routes->get('mapel', 'Admin::mapel');
    $routes->get('mapel/(:num)', 'Admin::mapel/$1');
    $routes->get('komponen-nilai', 'Admin::komponenNilai');
    $routes->get('komponen-nilai/(:segment)', 'Admin::komponenNilai/$1');
    $routes->get('kriteria-penilaian', 'Admin::kriteriaPenilaian');
    $routes->get('sikap', 'Admin::masterSikap');
    $routes->get('ekskul', 'Admin::masterEkskul');
    $routes->get('prestasi', 'Admin::masterPrestasi');
    
    // Kelas & Penugasan
    $routes->get('kelas', 'Admin::kelas');
    $routes->get('kelas/buka', 'Admin::bukaKelas');
    $routes->get('kelas/detail/(:num)', 'Admin::detailKelas/$1');
    $routes->get('penugasan', 'Admin::penugasan');
    
    // Data Pengguna
    $routes->get('guru', 'Admin::guru');
    $routes->get('guru/tambah', 'Admin::guruForm');
    $routes->get('guru/edit/(:num)', 'Admin::guruForm/$1');
    $routes->get('siswa', 'Admin::siswa');
    $routes->get('siswa/tambah', 'Admin::siswaForm');
    $routes->get('siswa/edit/(:num)', 'Admin::siswaForm/$1');
    $routes->get('siswa/detail/(:num)', 'Admin::siswaDetail/$1');
    $routes->get('siswa/detail/(:num)/(:segment)', 'Admin::siswaDetail/$1/$2');
    $routes->get('orang-tua', 'Admin::orangTua');
    $routes->get('staff-tu', 'Admin::staffTu');
    
    // Raport & Surat & Arsip
    $routes->get('raport/buka-kunci', 'Admin::bukaKunciRaport');
    $routes->get('ujian-sekolah', 'Admin::ujianSekolah');
    $routes->get('siswa/transkrip/(:num)', 'Admin::transkripSiswa/$1');
    $routes->get('kategori-surat', 'Admin::kategoriSurat');
    $routes->get('format-surat', 'Admin::formatNomorSurat');
    $routes->get('arsip', 'Admin::arsip');
    $routes->get('arsip/(:segment)', 'Admin::arsip/$1');
    $routes->get('log-audit', 'Admin::logAudit');
    
    // Action post
    $routes->post('save-action', 'Admin::saveAction');
});

// Guru Routes
$routes->group('guru', ['filter' => 'auth:guru'], function ($routes) {
    $routes->get('', 'Guru::dashboard');
    $routes->get('/', 'Guru::dashboard');
    $routes->get('dashboard', 'Guru::dashboard');
    $routes->get('dashboard/(:segment)', 'Guru::dashboard/$1');
    $routes->get('mapel', 'Guru::mapel');
    
    $routes->get('nilai', 'Guru::inputNilai');
    $routes->get('nilai/(:num)', 'Guru::inputNilai/$1');
    $routes->get('nilai/(:num)/sync-rata-rata', 'Guru::syncRataRataTugas/$1');
    $routes->get('nilai/(:num)/(:segment)', 'Guru::inputNilai/$1/$2');
    
    $routes->get('tugas', 'Guru::tugasHarian');
    $routes->get('tugas/(:num)', 'Guru::tugasHarian/$1');
    $routes->get('tugas/(:num)/rekap', 'Guru::rekapNilaiTugas/$1');
    $routes->get('tugas/(:num)/nilai/(:num)', 'Guru::inputNilaiTugas/$1/$2');
    $routes->post('tugas/(:num)/nilai/(:num)', 'Guru::saveNilaiTugas/$1/$2');
    $routes->get('tugas/nilai/(:num)', 'Guru::inputNilaiTugas/1/$1');
    $routes->post('tugas/nilai/(:num)', 'Guru::saveNilaiTugas/1/$1');
    
    $routes->get('analitik', 'Guru::analitik');
    $routes->get('analitik/(:num)', 'Guru::analitik/$1');
    $routes->get('analitik/(:num)/(:segment)', 'Guru::analitik/$1/$2');
    
    // Presensi Harian & Jurnal KBM Guru Mapel
    $routes->get('presensi', 'Guru::presensi');
    $routes->get('presensi/(:num)', 'Guru::presensi/$1');
    $routes->get('presensi/(:num)/tab/(:segment)', 'Guru::presensi/$1/$2');
    $routes->get('presensi/(:num)/input/(:num)', 'Guru::presensiInput/$1/$2');
    $routes->post('presensi/(:num)/save/(:num)', 'Guru::savePresensiPertemuan/$1/$2');
    $routes->post('presensi/(:num)/tambah-pertemuan', 'Guru::tambahPertemuan/$1');
    $routes->get('presensi/(:num)/cetak', 'Guru::presensiCetak/$1');
    
    $routes->get('perwalian', 'Guru::perwalian');
    $routes->get('perwalian/absensi', 'Guru::perwalian/absensi');
    $routes->post('perwalian/absensi', 'Guru::saveAbsensiPerwalian');
    $routes->get('perwalian/(:segment)', 'Guru::perwalian/$1');
    
    $routes->get('leger', 'Guru::legerNilai');
    $routes->get('matriks-nilai', 'Guru::legerNilai');
    $routes->get('kenaikan-kelas', 'Guru::kenaikanKelas');
    $routes->post('kenaikan-kelas', 'Guru::savePlenoKenaikan');
    
    $routes->get('raport/generate', 'Guru::raportGenerate');
    $routes->get('raport/tinjau', 'Guru::raportTinjau');
    $routes->get('raport/tinjau/(:num)', 'Guru::raportTinjau/$1');
    $routes->post('raport/finalisasi/(:num)', 'Guru::finalisasiRaport/$1');
    $routes->get('raport/buka-kunci', 'Guru::raportBukaKunci');
    $routes->get('raport/buka-kunci/(:num)', 'Guru::raportBukaKunci/$1');
    $routes->post('raport/ajukan-buka-kunci/(:num)', 'Guru::ajukanBukaKunciRaport/$1');
    $routes->post('raport/batal-buka-kunci/(:num)', 'Guru::batalBukaKunciRaport/$1');
    $routes->get('raport/batal-buka-kunci/(:num)', 'Guru::batalBukaKunciRaport/$1');
    
    // Action post
    $routes->post('save-action', 'Guru::saveAction');
});

// TU Routes
$routes->group('tu', ['filter' => 'auth:tu'], function ($routes) {
    $routes->get('', 'Tu::dashboard');
    $routes->get('/', 'Tu::dashboard');
    $routes->get('surat-masuk', 'Tu::suratMasuk');
    $routes->get('surat-masuk/tambah', 'Tu::suratMasukTambah');
    $routes->get('surat-masuk/detail/(:num)', 'Tu::suratMasukDetail/$1');
    
    $routes->get('surat-keluar', 'Tu::suratKeluar');
    $routes->get('surat-keluar/tambah', 'Tu::suratKeluarTambah');
    $routes->get('surat-keluar/detail/(:num)', 'Tu::suratKeluarDetail/$1');
    $routes->get('surat-keluar/ajukan-ttd/(:num)', 'Tu::ajukanTtdSuratKeluar/$1');
    $routes->get('surat-keluar/batalkan-draft/(:num)', 'Tu::batalkanDraftSuratKeluar/$1');
    
    $routes->get('arsip', 'Tu::arsipSurat');
    $routes->get('arsip/(:segment)', 'Tu::arsipSurat/$1');
    
    $routes->get('agenda', 'Tu::bukuAgenda');
    
    $routes->post('save-action', 'Tu::saveAction');
});

// Siswa Routes
$routes->group('siswa', ['filter' => 'auth:siswa'], function ($routes) {
    $routes->get('', 'Siswa::beranda');
    $routes->get('/', 'Siswa::beranda');
    $routes->get('profil', 'Siswa::profil');
    $routes->get('nilai', 'Siswa::nilai');
    $routes->get('nilai/(:segment)', 'Siswa::nilai/$1');
    $routes->get('status', 'Siswa::statusAkademik');
    $routes->get('status/(:segment)', 'Siswa::statusAkademik/$1');
    $routes->get('raport', 'Siswa::raportList');
    $routes->get('raport/preview', 'Siswa::raportPreview');
    $routes->get('raport/preview/(:num)', 'Siswa::raportPreview/$1');
    $routes->get('transkrip', 'Siswa::transkripLengkap');
});

// Figma Export Routes (Free of Auth Filter, Direct per-condition previews)
$routes->group('figma-export', function ($routes) {
    $routes->get('', 'FigmaExport::index');
    $routes->get('(:segment)/(:segment)', 'FigmaExport::render/$1/$2');
});
