# LAPORAN AUDIT TEKNIS & DOKUMENTASI LENGKAP SISTEM INFORMASI AKADEMIK (SIAKAD)
**Satuan Pendidikan:** SMA IT Fithrah Insani
**Basis Kode:** CodeIgniter 4.5+ / PHP 8.2+ / AdminLTE 4 / Bootstrap 5
**Tanggal Audit:** 21 September 2026
**Metodologi:** Audit Statis & Dinamis Berbasis Kode Sumber Aktual (*Ground Truth Inspection*)
**Status Repositori:** **In-Memory Mock Architecture** (*Seluruh data master, transaksi akademik, dan persuratan berjalan di atas in-memory array `MockData.php` dan `session()`, tanpa koneksi aktif ke basis data MySQL/MariaDB*).

---

## RINGKASAN EKSEKUTIF AUDIT (GROUND TRUTH ARSITEKTUR)
Audit teknis ini dilakukan secara komprehensif terhadap seluruh file kode sumber pada repositori SIAKAD SMA IT Fithrah Insani, mencakup direktori `app/Config/`, `app/Controllers/`, `app/Views/`, `app/Models/`, `app/Database/Migrations/`, dan pustaka mock `app/Libraries/MockData.php`.

### 1. Temuan Arsitektural Utama
1. **Ketiadaan Model dan Akses Basis Data Aktif (*Zero Database Operation*):**
   - Direktori `app/Models/` hanya berisi file `.gitkeep` tanpa satupun kelas model CodeIgniter (`CodeIgniter\Model`).
   - Seluruh konfigurasi database pada file `.env` berada dalam status ter-komentar (*commented out* `# database.default.hostname = localhost`).
   - Seluruh Controller (`Admin.php`, `Guru.php`, `Tu.php`, `Siswa.php`, `Auth.php`) **sama sekali tidak memanggil** `$this->db`, `db_connect()`, ataupun Model database. Data disuplai langsung oleh method statis `App\Libraries\MockData` (1.575 baris kode data tiruan array PHP).
   - Migrasi yang tersedia di `app/Database/Migrations/` hanya ada 4 file (membuat tabel `siswa_riwayat_kelas`, `penugasan`, alter `kelas`, `formula_kelulusan`, `ujian_sekolah`, dan `audit_log_nilai`), namun tabel-tabel ini tidak diakses oleh logika controller manapun.
2. **Mekanisme Persistensi Sementara Berbasis Session (*Session-Driven State Simulation*):**
   - Perubahan data (seperti penginputan nilai tugas, presensi pertemuan, penilaian sikap, usulan pleno, mutasi siswa, pengajuan TTD surat keluar, dan persetujuan raport) disimpan ke dalam PHP `session()`, bukan ke database relasional.
   - Ketika session kedaluwarsa atau browser di-clear cookie-nya, seluruh perubahan kembali ke data awal (*reset to static mock*).
3. **Ketiadaan Middleware Role-Based Access Control (RBAC):**
   - File `app/Config/Filters.php` **tidak mendaftarkan satupun filter otentikasi custom** pada array `$aliases` maupun `$filters` (baris 27-110).
   - Direktori `app/Filters/` hanya berisi `.gitkeep`.
   - File `app/Config/Routes.php` mendaftarkan seluruh group route (`admin`, `guru`, `tu`, `siswa`) **tanpa atribut filter apapun**.
   - Seluruh controller **tidak memeriksa** session login maupun role pengguna di dalam `__construct()` maupun method-methodnya. Akibatnya, siapapun (termasuk pengguna non-login atau role siswa) dapat membuka seluruh halaman administratif dan manipulasi nilai hanya dengan mengetikkan URL langsung pada bilah alamat browser.
4. **Rute Rusak (*Broken Route*):**
   - Rute `GET guru/tugas/(:num)/rekap` terdaftar di `app/Config/Routes.php:87` mengarah ke `Guru::rekapNilaiTugas/$1`. Method `rekapNilaiTugas` **TIDAK DITEMUKAN DI KODE** (`app/Controllers/Guru.php`), sehingga jika diakses akan menghasilkan fatal error `BadMethodCallException`.

---

## BAGIAN 1: INVENTARIS RUTE
Berikut adalah tabel lengkap seluruh rute yang terdaftar secara eksplisit di file [`app/Config/Routes.php`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Config/Routes.php) (baris 8-161).

> **Catatan Audit Keamanan Global:** Seluruh rute di bawah ini **TIDAK MEMILIKI** middleware atau filter proteksi otentikasi role (`app/Config/Filters.php` kosong; `()` tidak memiliki opsi filter). Kolom Middleware/Filter Auth Role berstatus **Tidak Ada (Publik / Unprotected)** di seluruh rute.

| No | Method HTTP | URL Rute | Controller @ Method | Middleware / Filter Auth Role | Status Rute |
|:---:|:---:|:---|:---|:---:|:---|
| 1 | `GET` | `/` | `Auth::login` | Tidak Ada (Bypass URL) | Aktif |
| 2 | `GET` | `/auth` | `Auth::login` | Tidak Ada (Bypass URL) | Aktif |
| 3 | `GET` | `/auth/login` | `Auth::login` | Tidak Ada (Bypass URL) | Aktif |
| 4 | `POST` | `/auth/login` | `Auth::doLogin` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 5 | `GET` | `/auth/logout` | `Auth::logout` | Tidak Ada (Bypass URL) | Aktif |
| 6 | `GET` | `/auth/switch/(:segment)` | `Auth::switchRole/$1` | Tidak Ada (Bypass URL) | Aktif |
| 7 | `GET` | `/admin` | `Admin::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 8 | `GET` | `/admin/` | `Admin::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 9 | `GET` | `/admin/sekolah` | `Admin::sekolah` | Tidak Ada (Bypass URL) | Aktif |
| 10 | `GET` | `/admin/tahun-ajaran` | `Admin::tahunAjaran` | Tidak Ada (Bypass URL) | Aktif |
| 11 | `GET` | `/admin/wizard` | `Admin::wizard` | Tidak Ada (Bypass URL) | Aktif |
| 12 | `GET` | `/admin/wizard/(:num)` | `Admin::wizard/$1` | Tidak Ada (Bypass URL) | Aktif |
| 13 | `GET` | `/admin/aktivasi-semester-genap` | `Admin::aktivasiSemesterGenap` | Tidak Ada (Bypass URL) | Aktif |
| 14 | `POST` | `/admin/aktivasi-semester-genap` | `Admin::doAktivasiSemesterGenap` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 15 | `GET` | `/admin/tingkatan` | `Admin::tingkatan` | Tidak Ada (Bypass URL) | Aktif |
| 16 | `GET` | `/admin/jurusan` | `Admin::jurusan` | Tidak Ada (Bypass URL) | Aktif |
| 17 | `GET` | `/admin/mapel` | `Admin::mapel` | Tidak Ada (Bypass URL) | Aktif |
| 18 | `GET` | `/admin/mapel/(:num)` | `Admin::mapel/$1` | Tidak Ada (Bypass URL) | Aktif |
| 19 | `GET` | `/admin/komponen-nilai` | `Admin::komponenNilai` | Tidak Ada (Bypass URL) | Aktif |
| 20 | `GET` | `/admin/komponen-nilai/(:segment)` | `Admin::komponenNilai/$1` | Tidak Ada (Bypass URL) | Aktif |
| 21 | `GET` | `/admin/kriteria-penilaian` | `Admin::kriteriaPenilaian` | Tidak Ada (Bypass URL) | Aktif |
| 22 | `GET` | `/admin/sikap` | `Admin::masterSikap` | Tidak Ada (Bypass URL) | Aktif |
| 23 | `GET` | `/admin/ekskul` | `Admin::masterEkskul` | Tidak Ada (Bypass URL) | Aktif |
| 24 | `GET` | `/admin/prestasi` | `Admin::masterPrestasi` | Tidak Ada (Bypass URL) | Aktif |
| 25 | `GET` | `/admin/kelas` | `Admin::kelas` | Tidak Ada (Bypass URL) | Aktif |
| 26 | `GET` | `/admin/kelas/buka` | `Admin::bukaKelas` | Tidak Ada (Bypass URL) | Aktif |
| 27 | `GET` | `/admin/kelas/detail/(:num)` | `Admin::detailKelas/$1` | Tidak Ada (Bypass URL) | Aktif |
| 28 | `GET` | `/admin/penugasan` | `Admin::penugasan` | Tidak Ada (Bypass URL) | Aktif |
| 29 | `GET` | `/admin/guru` | `Admin::guru` | Tidak Ada (Bypass URL) | Aktif |
| 30 | `GET` | `/admin/guru/tambah` | `Admin::guruForm` | Tidak Ada (Bypass URL) | Aktif |
| 31 | `GET` | `/admin/guru/edit/(:num)` | `Admin::guruForm/$1` | Tidak Ada (Bypass URL) | Aktif |
| 32 | `GET` | `/admin/siswa` | `Admin::siswa` | Tidak Ada (Bypass URL) | Aktif |
| 33 | `GET` | `/admin/siswa/tambah` | `Admin::siswaForm` | Tidak Ada (Bypass URL) | Aktif |
| 34 | `GET` | `/admin/siswa/edit/(:num)` | `Admin::siswaForm/$1` | Tidak Ada (Bypass URL) | Aktif |
| 35 | `GET` | `/admin/siswa/detail/(:num)` | `Admin::siswaDetail/$1` | Tidak Ada (Bypass URL) | Aktif |
| 36 | `GET` | `/admin/siswa/detail/(:num)/(:segment)` | `Admin::siswaDetail/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 37 | `GET` | `/admin/orang-tua` | `Admin::orangTua` | Tidak Ada (Bypass URL) | Aktif |
| 38 | `GET` | `/admin/staff-tu` | `Admin::staffTu` | Tidak Ada (Bypass URL) | Aktif |
| 39 | `GET` | `/admin/raport/buka-kunci` | `Admin::bukaKunciRaport` | Tidak Ada (Bypass URL) | Aktif |
| 40 | `GET` | `/admin/ujian-sekolah` | `Admin::ujianSekolah` | Tidak Ada (Bypass URL) | Aktif |
| 41 | `GET` | `/admin/siswa/transkrip/(:num)` | `Admin::transkripSiswa/$1` | Tidak Ada (Bypass URL) | Aktif |
| 42 | `GET` | `/admin/kategori-surat` | `Admin::kategoriSurat` | Tidak Ada (Bypass URL) | Aktif |
| 43 | `GET` | `/admin/format-surat` | `Admin::formatNomorSurat` | Tidak Ada (Bypass URL) | Aktif |
| 44 | `GET` | `/admin/arsip` | `Admin::arsip` | Tidak Ada (Bypass URL) | Aktif |
| 45 | `GET` | `/admin/arsip/(:segment)` | `Admin::arsip/$1` | Tidak Ada (Bypass URL) | Aktif |
| 46 | `GET` | `/admin/log-audit` | `Admin::logAudit` | Tidak Ada (Bypass URL) | Aktif |
| 47 | `POST` | `/admin/save-action` | `Admin::saveAction` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 48 | `GET` | `/guru` | `Guru::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 49 | `GET` | `/guru/` | `Guru::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 50 | `GET` | `/guru/dashboard` | `Guru::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 51 | `GET` | `/guru/dashboard/(:segment)` | `Guru::dashboard/$1` | Tidak Ada (Bypass URL) | Aktif |
| 52 | `GET` | `/guru/mapel` | `Guru::mapel` | Tidak Ada (Bypass URL) | Aktif |
| 53 | `GET` | `/guru/nilai` | `Guru::inputNilai` | Tidak Ada (Bypass URL) | Aktif |
| 54 | `GET` | `/guru/nilai/(:num)` | `Guru::inputNilai/$1` | Tidak Ada (Bypass URL) | Aktif |
| 55 | `GET` | `/guru/nilai/(:num)/sync-rata-rata` | `Guru::syncRataRataTugas/$1` | Tidak Ada (Bypass URL) | Aktif |
| 56 | `GET` | `/guru/nilai/(:num)/(:segment)` | `Guru::inputNilai/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 57 | `GET` | `/guru/tugas` | `Guru::tugasHarian` | Tidak Ada (Bypass URL) | Aktif |
| 58 | `GET` | `/guru/tugas/(:num)` | `Guru::tugasHarian/$1` | Tidak Ada (Bypass URL) | Aktif |
| 59 | `GET` | `/guru/tugas/(:num)/rekap` | `Guru::rekapNilaiTugas/$1` | Tidak Ada (Bypass URL) | **Controller Method Kosong / Tidak Ditemukan** (`rekapNilaiTugas` tidak ada di `Guru.php`) |
| 60 | `GET` | `/guru/tugas/(:num)/nilai/(:num)` | `Guru::inputNilaiTugas/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 61 | `POST` | `/guru/tugas/(:num)/nilai/(:num)` | `Guru::saveNilaiTugas/$1/$2` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 62 | `GET` | `/guru/tugas/nilai/(:num)` | `Guru::inputNilaiTugas/1/$1` | Tidak Ada (Bypass URL) | Aktif |
| 63 | `POST` | `/guru/tugas/nilai/(:num)` | `Guru::saveNilaiTugas/1/$1` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 64 | `GET` | `/guru/analitik` | `Guru::analitik` | Tidak Ada (Bypass URL) | Aktif |
| 65 | `GET` | `/guru/analitik/(:num)` | `Guru::analitik/$1` | Tidak Ada (Bypass URL) | Aktif |
| 66 | `GET` | `/guru/analitik/(:num)/(:segment)` | `Guru::analitik/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 67 | `GET` | `/guru/presensi` | `Guru::presensi` | Tidak Ada (Bypass URL) | Aktif |
| 68 | `GET` | `/guru/presensi/(:num)` | `Guru::presensi/$1` | Tidak Ada (Bypass URL) | Aktif |
| 69 | `GET` | `/guru/presensi/(:num)/tab/(:segment)` | `Guru::presensi/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 70 | `GET` | `/guru/presensi/(:num)/input/(:num)` | `Guru::presensiInput/$1/$2` | Tidak Ada (Bypass URL) | Aktif |
| 71 | `POST` | `/guru/presensi/(:num)/save/(:num)` | `Guru::savePresensiPertemuan/$1/$2` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 72 | `POST` | `/guru/presensi/(:num)/tambah-pertemuan` | `Guru::tambahPertemuan/$1` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 73 | `GET` | `/guru/presensi/(:num)/cetak` | `Guru::presensiCetak/$1` | Tidak Ada (Bypass URL) | Aktif |
| 74 | `GET` | `/guru/perwalian` | `Guru::perwalian` | Tidak Ada (Bypass URL) | Aktif |
| 75 | `GET` | `/guru/perwalian/absensi` | `Guru::perwalian/absensi` | Tidak Ada (Bypass URL) | Aktif |
| 76 | `POST` | `/guru/perwalian/absensi` | `Guru::saveAbsensiPerwalian` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 77 | `GET` | `/guru/perwalian/(:segment)` | `Guru::perwalian/$1` | Tidak Ada (Bypass URL) | Aktif |
| 78 | `GET` | `/guru/leger` | `Guru::legerNilai` | Tidak Ada (Bypass URL) | Aktif |
| 79 | `GET` | `/guru/matriks-nilai` | `Guru::legerNilai` | Tidak Ada (Bypass URL) | Aktif |
| 80 | `GET` | `/guru/kenaikan-kelas` | `Guru::kenaikanKelas` | Tidak Ada (Bypass URL) | Aktif |
| 81 | `POST` | `/guru/kenaikan-kelas` | `Guru::savePlenoKenaikan` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 82 | `GET` | `/guru/raport/generate` | `Guru::raportGenerate` | Tidak Ada (Bypass URL) | Aktif |
| 83 | `GET` | `/guru/raport/tinjau` | `Guru::raportTinjau` | Tidak Ada (Bypass URL) | Aktif |
| 84 | `GET` | `/guru/raport/tinjau/(:num)` | `Guru::raportTinjau/$1` | Tidak Ada (Bypass URL) | Aktif |
| 85 | `POST` | `/guru/raport/finalisasi/(:num)` | `Guru::finalisasiRaport/$1` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 86 | `GET` | `/guru/raport/buka-kunci` | `Guru::raportBukaKunci` | Tidak Ada (Bypass URL) | Aktif |
| 87 | `GET` | `/guru/raport/buka-kunci/(:num)` | `Guru::raportBukaKunci/$1` | Tidak Ada (Bypass URL) | Aktif |
| 88 | `POST` | `/guru/save-action` | `Guru::saveAction` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 89 | `GET` | `/tu` | `Tu::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 90 | `GET` | `/tu/` | `Tu::dashboard` | Tidak Ada (Bypass URL) | Aktif |
| 91 | `GET` | `/tu/surat-masuk` | `Tu::suratMasuk` | Tidak Ada (Bypass URL) | Aktif |
| 92 | `GET` | `/tu/surat-masuk/tambah` | `Tu::suratMasukTambah` | Tidak Ada (Bypass URL) | Aktif |
| 93 | `GET` | `/tu/surat-masuk/detail/(:num)` | `Tu::suratMasukDetail/$1` | Tidak Ada (Bypass URL) | Aktif |
| 94 | `GET` | `/tu/surat-keluar` | `Tu::suratKeluar` | Tidak Ada (Bypass URL) | Aktif |
| 95 | `GET` | `/tu/surat-keluar/tambah` | `Tu::suratKeluarTambah` | Tidak Ada (Bypass URL) | Aktif |
| 96 | `GET` | `/tu/surat-keluar/detail/(:num)` | `Tu::suratKeluarDetail/$1` | Tidak Ada (Bypass URL) | Aktif |
| 97 | `GET` | `/tu/surat-keluar/ajukan-ttd/(:num)` | `Tu::ajukanTtdSuratKeluar/$1` | Tidak Ada (Bypass URL) | Aktif |
| 98 | `GET` | `/tu/surat-keluar/batalkan-draft/(:num)` | `Tu::batalkanDraftSuratKeluar/$1` | Tidak Ada (Bypass URL) | Aktif |
| 99 | `GET` | `/tu/arsip` | `Tu::arsipSurat` | Tidak Ada (Bypass URL) | Aktif |
| 100 | `GET` | `/tu/arsip/(:segment)` | `Tu::arsipSurat/$1` | Tidak Ada (Bypass URL) | Aktif |
| 101 | `GET` | `/tu/agenda` | `Tu::bukuAgenda` | Tidak Ada (Bypass URL) | Aktif |
| 102 | `POST` | `/tu/save-action` | `Tu::saveAction` | Tidak Ada (Bypass URL) | Aktif (Action Endpoint / Redirect) |
| 103 | `GET` | `/siswa` | `Siswa::beranda` | Tidak Ada (Bypass URL) | Aktif |
| 104 | `GET` | `/siswa/` | `Siswa::beranda` | Tidak Ada (Bypass URL) | Aktif |
| 105 | `GET` | `/siswa/profil` | `Siswa::profil` | Tidak Ada (Bypass URL) | Aktif |
| 106 | `GET` | `/siswa/nilai` | `Siswa::nilai` | Tidak Ada (Bypass URL) | Aktif |
| 107 | `GET` | `/siswa/nilai/(:segment)` | `Siswa::nilai/$1` | Tidak Ada (Bypass URL) | Aktif |
| 108 | `GET` | `/siswa/status` | `Siswa::statusAkademik` | Tidak Ada (Bypass URL) | Aktif |
| 109 | `GET` | `/siswa/status/(:segment)` | `Siswa::statusAkademik/$1` | Tidak Ada (Bypass URL) | Aktif |
| 110 | `GET` | `/siswa/raport` | `Siswa::raportList` | Tidak Ada (Bypass URL) | Aktif |
| 111 | `GET` | `/siswa/raport/preview` | `Siswa::raportPreview` | Tidak Ada (Bypass URL) | Aktif |
| 112 | `GET` | `/siswa/raport/preview/(:num)` | `Siswa::raportPreview/$1` | Tidak Ada (Bypass URL) | Aktif |
| 113 | `GET` | `/siswa/transkrip` | `Siswa::transkripLengkap` | Tidak Ada (Bypass URL) | Aktif |

---

## BAGIAN 2: DOKUMENTASI PER HALAMAN (DIKELOMPOKKAN PER ROLE)
Dokumentasi ini membedah seluruh halaman berstatus **Aktif** berdasarkan kode aktual file View, Controller, dan Model/MockData.

---

## KELOMPOK ROLE 1: ADMINISTRATOR (ADMIN)

### 1. Dashboard Administrator
- **URL:** `/admin` atau `/admin/`
- **Controller & Method:** [`Admin::dashboard()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L28-L53)
- **Header (H1) di View:** `Dashboard Administrator` ([`admin/dashboard.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/dashboard.php#L9))
- **Subjudul:** `Pusat kendali operasional, status sistem, dan ringkasan data akademik.` ([`admin/dashboard.php:10`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/dashboard.php#L10))
- **Widget/Stat Card:**
  - *Total Siswa Aktif:* Nilai `177` (hardcoded di controller [`Admin.php:35`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L35)). Tidak ada query SQL.
  - *Total Guru & Tendik:* Nilai `24` (hardcoded di controller [`Admin.php:36`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L36)).
  - *Rombel Aktif:* Nilai `7` (hardcoded di controller [`Admin.php:37`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L37)).
  - *Status TA & Semester:* Nilai `2025/2026 Ganjil (Aktif)` (hardcoded di controller [`Admin.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L38)).
- **Tabel Data:** Tidak ada tabel data utama. Menampilkan timeline aktivitas terkini (array statis 5 item di [`Admin.php:43-49`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L43-L49)).
- **Tombol & Aksi:**
  - `Buka Kelas Baru`: Link GET ke `/admin/kelas/buka`
  - `Tambah Guru`: Link GET ke `/admin/guru/tambah`
  - `Tambah Siswa`: Link GET ke `/admin/siswa/tambah`
  - `Wizard Setup TA`: Link GET ke `/admin/wizard/1`
- **Form/Modal:** Modal Buka Kunci Cepat (jika ada unlock request pending).
- **Ketergantungan Data:** Tidak ada (merupakan landing page admin).
- **Catatan Kejujuran:** Seluruh widget angka dan linimasa log aktivitas di-hardcode di dalam controller array PHP `$data['stats']` dan `$data['aktivitas']`, bukan dari tabel database.

### 2. Data Sekolah
- **URL:** `/admin/sekolah`
- **Controller & Method:** [`Admin::sekolah()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L56-L66)
- **Header (H1) di View:** `Data Sekolah` ([`admin/sekolah.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/sekolah.php#L9))
- **Subjudul:** `Identitas resmi satuan pendidikan dan informasi kontak sekolah.` ([`admin/sekolah.php:10`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/sekolah.php#L10))
- **Widget/Stat Card:** Panel Ringkasan Profil: NPSN `20224156`, NSS `301020801001`, Akreditasi `A`, Jenjang `SMA` (dari `MockData::getSekolah()`).
- **Tabel Data:** Tidak ada tabel data tabular (tampilan card form informasi detail sekolah).
- **Tombol & Aksi:** `Simpan Perubahan Identitas Sekolah`: Form POST ke `/admin/save-action`. Controller hanya melakukan redirect dengan pesan flash success tanpa menyimpan perubahan ke file maupun database.
- **Form/Modal:** Form identitas: `nama_sekolah` (text), `npsn` (text), `nss` (text), `kepala_sekolah` (text), `alamat` (textarea), `kelurahan` (text), `kecamatan` (text), `kabupaten_kota` (text), `provinsi` (text), `website` (url), `email` (email), `telepon` (text). Validasi controller: **TIDAK ADA VALIDASI** (controller langsung redirect).
- **Ketergantungan Data:** `MockData::getSekolah()`. Jika data sekolah di database kelak dibutuhkan, harus dibuatkan migrasi tabel `sekolah`.
- **Catatan Kejujuran:** Data diambil dari array statis `MockData::getSekolah()`. Tombol submit `Simpan Perubahan` tidak menyimpan data apapun ke storage persisten.

### 3. Tahun Ajaran & Semester
- **URL:** `/admin/tahun-ajaran`
- **Controller & Method:** [`Admin::tahunAjaran()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L69-L79)
- **Header (H1) di View:** `Tahun Ajaran & Semester` ([`admin/tahun_ajaran/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/index.php#L9))
- **Subjudul:** `Kelola siklus tahun ajaran, aktivasi semester ganjil/genap, dan wizard tahun ajaran baru.` ([`admin/tahun_ajaran/index.php:10`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/index.php#L10))
- **Widget/Stat Card:** Stat ringkasan: Tahun Ajaran Aktif `2025/2026`, Semester Aktif `Ganjil`, Total Rombel `7 Kelas`, Siswa Aktif `177 Siswa`.
- **Tabel Data:** Kolom tabel: `No`, `Tahun Ajaran`, `Semester & Periode`, `Status`, `Aksi`. Sumber data: array multidimensi dari `MockData::getTahunAjaran()` ([`Admin.php:73`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L73)). Paginasi/search: tidak ada (data array statis).
- **Tombol & Aksi:**
  - `Setup Tahun Ajaran Baru`: Link GET ke `/admin/wizard/1`
  - `Aktivasi Semester Genap`: Link GET ke `/admin/aktivasi-semester-genap`
  - Tombol aksi per baris: `Aktifkan` (POST form ke `/admin/save-action` dengan hidden input `action=Aktivasi Tahun Ajaran`), `Detail/Edit` (modal mock).
- **Form/Modal:** Modal Tambah Tahun Ajaran Baru: field `nama` (text), `tanggal_mulai` (date), `tanggal_selesai` (date). Validasi controller: Tidak ada.
- **Ketergantungan Data:** Menjadi acuan seluruh filter semester dan penugasan di sistem.
- **Catatan Kejujuran:** Pengaktifan tahun ajaran melalui tombol `Aktifkan` mengirim POST ke `/admin/save-action`, yang sama sekali tidak mengubah flag aktif di array maupun database.

### 4. Setup Wizard Step 1: Informasi Tahun Ajaran
- **URL:** `/admin/wizard/1` atau `/admin/wizard`
- **Controller & Method:** [`Admin::wizard(1)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 1/6: Informasi Tahun Ajaran & Rentang Semester` ([`admin/tahun_ajaran/wizard_step_1.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_1.php#L38))
- **Subjudul:** Tidak ada subjudul terpisah.
- **Widget/Stat Card:** Banner Peringatan Gatekeeper Sidang Pleno ([`wizard_step_1.php:47-78`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_1.php#L47-L78)) menampilkan status 2 kelas yang belum tuntas pleno (`XI-MIPA-1` sedang berlangsung, `XI-IPS-1` belum mulai).
- **Tabel Data:** List group rombel belum pleno: nama rombel, wali kelas, badge status pleno.
- **Tombol & Aksi:**
  - `Lanjut ke Langkah 2`: Tombol submit form (method GET ke `/admin/wizard/2`). Menggunakan kondisi disabled jika `!`.
  - `Selesaikan Sidang Pleno`: Link GET ke `/guru/kenaikan-kelas`.
- **Form/Modal:** Form GET ke `/admin/wizard/2`: field `nama_ta` (text `2026/2027`), `ganjil_mulai` (date `2026-07-13`), `ganjil_selesai` (date `2026-12-18`), `genap_mulai` (date `2027-01-04`), `genap_selesai` (date `2027-06-18`).
- **Ketergantungan Data:** Bergantung pada status sidang pleno seluruh rombel (`MockData::isSemuaPlenoSelesai()`).
- **Catatan Kejujuran:** Form mengirim parameter via method GET ke `/admin/wizard/2`, bukan POST. Nilai tidak disimpan ke session atau database.

### 5. Setup Wizard Step 2: Kelas & Kapasitas
- **URL:** `/admin/wizard/2`
- **Controller & Method:** [`Admin::wizard(2)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 2/6: Buka Rombel & Tentukan Kapasitas` ([`admin/tahun_ajaran/wizard_step_2.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_2.php#L38))
- **Subjudul:** Tidak ada subjudul terpisah.
- **Widget/Stat Card:** Ringkasan Rombel Disiapkan: Kelas 10 (4 rombel), Kelas 11 (4 rombel), Kelas 12 (4 rombel), Total kapasitas 384 kursi.
- **Tabel Data:** Tabel rombel rencana: `Tingkat`, `Jurusan`, `Nama Rombel`, `Kapasitas Maksimal`, `Aksi Hapus/Buka`. Sumber data: `MockData::getTingkatan()`, `MockData::getJurusan()`.
- **Tombol & Aksi:** Form GET ke `/admin/wizard/3`. Tombol `Lanjut ke Langkah 3: Wali Kelas`.
- **Form/Modal:** Field input nama rombel dan kapasitas per kelas.
- **Ketergantungan Data:** Bergantung pada lolosnya validasi sidang pleno di Step 1.
- **Catatan Kejujuran:** Jika diakses langsung via URL sementara pleno belum 100% selesai, controller [`Admin.php:91-94`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L91-L94) melakukan redirect kembali ke Step 1 dengan flash error.

### 6. Setup Wizard Step 3: Penetapan Wali Kelas
- **URL:** `/admin/wizard/3`
- **Controller & Method:** [`Admin::wizard(3)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 3/6: Penetapan Wali Kelas Baru` ([`admin/tahun_ajaran/wizard_step_3.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_3.php#L38))
- **Subjudul:** Tidak ada subjudul terpisah.
- **Widget/Stat Card:** Card progres penugasan wali: `7/7 Rombel Terisi (100%)`.
- **Tabel Data:** Tabel penugasan wali: `No`, `Nama Rombel`, `Tingkat/Jurusan`, `Pilih Guru Wali Kelas`, `Beban Mengajar Saat Ini`.
- **Tombol & Aksi:** Form GET ke `/admin/wizard/4`. Tombol `Lanjut ke Langkah 4: Kenaikan Kelas`.
- **Form/Modal:** Tag `<select>` guru untuk masing-masing rombel.
- **Ketergantungan Data:** Data guru aktif dari `MockData::getGuru()`.
- **Catatan Kejujuran:** Pilihan select wali kelas tidak disimpan ke database.

### 7. Setup Wizard Step 4: Rekapitulasi Kenaikan Kelas
- **URL:** `/admin/wizard/4`
- **Controller & Method:** [`Admin::wizard(4)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 4/6: Rekapitulasi Kenaikan Kelas & Kelulusan (Hasil Sidang Pleno)` ([`admin/tahun_ajaran/wizard_step_4.php:50`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_4.php#L50))
- **Subjudul:** `Single Source of Truth: Data bersumber langsung dari hasil Sidang Pleno Wali Kelas & Kepala Sekolah.` ([`admin/tahun_ajaran/wizard_step_4.php:52`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_4.php#L52))
- **Widget/Stat Card:** Ringkasan hasil pleno: `Total Siswa` (177), `Naik Kelas` (116), `Tinggal Kelas` (1), `Lulus` (59). Badge: `Terkunci (Read-Only)`.
- **Tabel Data:** Kolom tabel: `No`, `NIS/NISN`, `Nama Siswa`, `Kelas Asal`, `Keputusan Pleno`, `Rombel Tujuan (TA Baru)`, `Tanggal Pengesahan`, `Catatan`. Sumber data: `MockData::getKenaikanKelasList()` ([`Admin.php:109`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L109)).
- **Tombol & Aksi:** Link GET ke `/admin/wizard/5` (`Lanjut ke Langkah 5: Penugasan Guru`).
- **Form/Modal:** Tidak ada form input atau select (tampilan murni read-only).
- **Ketergantungan Data:** Hasil pengesahan sidang pleno wali kelas dan kepala sekolah.
- **Catatan Kejujuran:** Tampilan data ini tidak terhubung ke tabel riwayat kelas yang baru (`siswa_riwayat_kelas`), melainkan membaca array statis `MockData::getKenaikanKelasList()`.

### 8. Setup Wizard Step 5: Penugasan Guru Mengajar
- **URL:** `/admin/wizard/5`
- **Controller & Method:** [`Admin::wizard(5)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 5/6: Distribusi Penugasan Guru Mengajar` ([`admin/tahun_ajaran/wizard_step_5.php:41`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_5.php#L41))
- **Subjudul:** Tidak ada subjudul terpisah.
- **Widget/Stat Card:** Card total beban: 12 Rombel x 14 Mapel = 168 Jam Pelajaran/minggu.
- **Tabel Data:** Matriks penugasan guru per mapel dan rombel.
- **Tombol & Aksi:** Form GET ke `/admin/wizard/6` (`Lanjut ke Langkah 6: Ringkasan & Aktivasi`).
- **Form/Modal:** Form select penugasan guru.
- **Ketergantungan Data:** Data mapel dan rombel baru.
- **Catatan Kejujuran:** Pemetaan guru pengampu bersifat simulasi mock.

### 9. Setup Wizard Step 6: Ringkasan & Aktivasi Sistem
- **URL:** `/admin/wizard/6`
- **Controller & Method:** [`Admin::wizard(6)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L82-L114)
- **Header (H1) di View:** `Langkah 6/6: Tinjau & Aktivasi Tahun Ajaran Baru` ([`admin/tahun_ajaran/wizard_step_6.php:36`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_6.php#L36))
- **Subjudul:** Tidak ada subjudul terpisah.
- **Widget/Stat Card:** Checklist 6 prasyarat aktivasi: Info TA (Terverifikasi), Kelas & Kapasitas (Terverifikasi), Wali Kelas (Terverifikasi), Kenaikan Kelas (Belum Terpenuhi/Tuntas), Penugasan Guru (Belum Lengkap). Mode Prototype: Toggle switch demo simulasi semua prasyarat terpenuhi.
- **Tabel Data:** Tabel rekap konfigurasi akhir sebelum aktivasi.
- **Tombol & Aksi:** Form POST ke `/admin/save-action` dengan hidden input `action=Aktivasi Tahun Ajaran 2026/2027` dan `redirect_url=/admin/tahun-ajaran`. Tombol `Aktivasi Tahun Ajaran Baru Sekarang` dinonaktifkan secara default oleh JavaScript sampai seluruh prasyarat terpenuhi.
- **Form/Modal:** Modal Konfirmasi Aktivasi Sistem.
- **Ketergantungan Data:** Semua langkah 1-5.
- **Catatan Kejujuran:** Saat tombol submit ditekan, request dikirim ke `Admin::saveAction()`. Controller tersebut tidak menjalankan transaksi database, tidak melakukan INSERT ke tabel tahun ajaran, dan tidak memindahkan siswa; hanya redirect dengan flash success.

### 10. Aktivasi Semester Genap
- **URL:** `/admin/aktivasi-semester-genap`
- **Controller & Method:** [`Admin::aktivasiSemesterGenap()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L117-L140) (GET) dan [`Admin::doAktivasiSemesterGenap()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L142-L146) (POST)
- **Header (H1) di View:** `Aktivasi Semester Genap TA 2025/2026` ([`admin/tahun_ajaran/aktivasi_semester_genap.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/aktivasi_semester_genap.php#L12))
- **Subjudul:** `Transisi semester aktif dalam tahun ajaran yang sama tanpa mutasi rombel.`
- **Widget/Stat Card:** Card Checklist Prasyarat: Raport Ganjil 100% Final (Terpenuhi), Tidak Ada Permohonan Buka Kunci Pending (Terpenuhi), Kalender Genap Siap (Terpenuhi).
- **Tabel Data:** Tabel daftar permohonan buka kunci pending (kosong/terpenuhi).
- **Tombol & Aksi:** Form POST ke `/admin/aktivasi-semester-genap`. Tombol `Aktifkan Semester Genap Sekarang`. Controller `doAktivasiSemesterGenap()` hanya melakukan redirect ke `/admin/tahun-ajaran` dengan flash success.
- **Form/Modal:** Form aktivasi: checkbox persetujuan syarat.
- **Ketergantungan Data:** Raport semester ganjil seluruh rombel berstatus final.
- **Catatan Kejujuran:** Method `doAktivasiSemesterGenap()` hanya berisi 4 baris kode redirect dengan flash message tanpa eksekusi update kolom `is_active` di tabel manapun.

### 11. Master Tingkatan Kelas
- **URL:** `/admin/tingkatan`
- **Controller & Method:** [`Admin::tingkatan()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L148-L158)
- **Header (H1) di View:** `Tingkatan Kelas` ([`admin/master/tingkatan.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/tingkatan.php#L9))
- **Subjudul:** `Kelola jenjang dan tingkatan kelas yang berlaku di sekolah.`
- **Widget/Stat Card:** Total Tingkatan: `3 Tingkatan (Kelas 10, 11, 12)`, Total Rombel: `7 Rombel`.
- **Tabel Data:** Kolom: `No`, `Nama Tingkatan`, `Urutan Jenjang`, `Jumlah Kelas Aktif`, `Aksi`. Sumber data: `MockData::getTingkatan()` ([`Admin.php:153`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L153)). Paginasi: tidak ada.
- **Tombol & Aksi:** `Tambah Tingkatan` (Membuka modal), Tombol `Edit` & `Hapus` per baris.
- **Form/Modal:** Modal Tambah Tingkatan: `nama` (text), `urutan` (number). Form POST ke `/admin/save-action` (`action=Tambah Tingkatan`). Validasi: Tidak ada.
- **Ketergantungan Data:** Menjadi referensi penjenjangan rombel.
- **Catatan Kejujuran:** Data tingkatan murni dari array `MockData::getTingkatan()`. Aksi simpan/hapus tidak menyentuh database.

### 12. Master Jurusan / Program Peminatan
- **URL:** `/admin/jurusan`
- **Controller & Method:** [`Admin::jurusan()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L161-L171)
- **Header (H1) di View:** `Jurusan / Peminatan` ([`admin/master/jurusan.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/jurusan.php#L9))
- **Subjudul:** `Kelola program peminatan dan penjurusan akademik siswa.`
- **Widget/Stat Card:** Total Jurusan: `3 Jurusan` (MIPA, IPS, Bahasa).
- **Tabel Data:** Kolom: `No`, `Kode Jurusan`, `Nama Lengkap Jurusan`, `Jumlah Kelas Aktif`, `Aksi`. Sumber data: `MockData::getJurusan()`.
- **Tombol & Aksi:** `Tambah Jurusan` (Buka modal), `Edit`, `Hapus`. Form POST ke `/admin/save-action`.
- **Form/Modal:** Modal Form: `kode` (text), `nama_jurusan` (text). Validasi: Tidak ada.
- **Ketergantungan Data:** Referensi peminatan rombel dan kelompok mapel C.
- **Catatan Kejujuran:** Mock array in-memory.

### 13. Master Mata Pelajaran & Kelompok Mapel
- **URL:** `/admin/mapel` atau `/admin/mapel/(:num)`
- **Controller & Method:** [`Admin::mapel()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L174-L206)
- **Header (H1) di View:** `Mata Pelajaran & Kelompok Mapel` ([`admin/master/mapel.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/mapel.php#L9))
- **Subjudul:** `Struktur kurikulum mata pelajaran nasional, peminatan, dan muatan lokal.`
- **Widget/Stat Card:** Navigasi Tab Kelompok: Kelompok A (6 Mapel), Kelompok B (3 Mapel), Kelompok C MIPA (4 Mapel), Kelompok C IPS (4 Mapel), Mulok (2 Mapel).
- **Tabel Data:** Kolom: `No`, `Kode Mapel`, `Nama Mata Pelajaran`, `Kelompok`, `Jurusan Terkait`, `Urutan Raport`, `Aksi`. Sumber data: `MockData::getMapel()` difilter berdasarkan ``.
- **Tombol & Aksi:** `Tambah Mapel Baru` (Modal), `Edit`, `Hapus`. Form POST ke `/admin/save-action`.
- **Form/Modal:** Modal Form: `kode_mapel`, `nama_mapel`, `kelompok_mapel_id`, `jurusan_id`, `urutan_raport`. Validasi: Tidak ada.
- **Ketergantungan Data:** Menjadi acuan modul penugasan guru, buku nilai, dan raport.
- **Catatan Kejujuran:** Filter kelompok berfungsi di level controller melalui fungsi PHP `array_filter`, bukan SQL WHERE clause.

### 14. Master Komponen Nilai & Bobot
- **URL:** `/admin/komponen-nilai` atau `/admin/komponen-nilai/(:segment)`
- **Controller & Method:** [`Admin::komponenNilai()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L209-L223)
- **Header (H1) di View:** `Komponen Nilai & Bobot` ([`admin/master/komponen_nilai.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/komponen_nilai.php#L9))
- **Subjudul:** `Atur bobot persentase perhitungan nilai akhir pengetahuan dan keterampilan.`
- **Widget/Stat Card:** Tab Aspek Pengetahuan (Total Bobot 100%) & Aspek Keterampilan (Total Bobot 100%).
- **Tabel Data:** Kolom: `No`, `Kode`, `Nama Komponen`, `Bobot (%)`, `Wajib Diisi?`, `Keterangan`, `Aksi`. Sumber data: `MockData::getKomponenNilai()`.
- **Tombol & Aksi:** `Simpan Perubahan Bobot`. Form POST ke `/admin/save-action`.
- **Form/Modal:** Input number bobot per komponen (UH 20%, Tugas 20%, UTS 25%, UAS 35% pada Pengetahuan; Praktik 40%, Proyek 30%, Portofolio 30% pada Keterampilan). Validasi JavaScript: Total bobot harus 100%.
- **Ketergantungan Data:** Menjadi dasar rumus kalkulasi nilai akhir di controller Guru.
- **Catatan Kejujuran:** Nilai bobot di-hardcode di `MockData::getKomponenNilai()`. Perubahan melalui form POST tidak disimpan ke database.

### 15. Kriteria Ketuntasan Minimal (KKM) & Interval Predikat
- **URL:** `/admin/kriteria-penilaian`
- **Controller & Method:** [`Admin::kriteriaPenilaian()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L226-L236)
- **Header (H1) di View:** `Kriteria Penilaian & KKM` ([`admin/master/kriteria_penilaian.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/kriteria_penilaian.php#L9))
- **Subjudul:** `Standar KKM sekolah, interval predikat nilai (A/B/C/D), dan deskripsi capaian kompetensi.`
- **Widget/Stat Card:** Card Standar KKM Umum: `75.00`, Interval Predikat: A (92-100), B (83-91), C (75-82), D (<75).
- **Tabel Data:** Tabel interval predikat nilai dan rentang skor.
- **Tombol & Aksi:** Form POST `Simpan Pengaturan KKM` ke `/admin/save-action`.
- **Form/Modal:** Field input angka KKM.
- **Ketergantungan Data:** Master mapel.
- **Catatan Kejujuran:** Nilai KKM dan rumus interval predikat dihitung menggunakan logika PHP in-memory.

### 16. Master Sikap Spiritual & Sosial
- **URL:** `/admin/sikap`
- **Controller & Method:** [`Admin::masterSikap()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L239-L250)
- **Header (H1) di View:** `Master Sikap Spiritual & Sosial` ([`admin/master/sikap.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/sikap.php#L9))
- **Subjudul:** `Indikator penilaian sikap kurikulum merdeka/k13.`
- **Widget/Stat Card:** Indikator Sikap Spiritual (4 butir), Sikap Sosial (6 butir).
- **Tabel Data:** Kolom: `No`, `Jenis Sikap`, `Butir Sikap / Indikator`, `Deskripsi Default`, `Aksi`. Sumber data: `MockData::getMasterSikap()`.
- **Tombol & Aksi:** `Tambah Butir Sikap` (Modal), `Edit`, `Hapus`.
- **Form/Modal:** Modal Form Tambah Sikap.
- **Ketergantungan Data:** Menjadi opsi penilaian sikap di menu perwalian guru.
- **Catatan Kejujuran:** Data statis dari MockData.

### 17. Master Ekstrakurikuler
- **URL:** `/admin/ekskul`
- **Controller & Method:** [`Admin::masterEkskul()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L253-L264)
- **Header (H1) di View:** `Master Ekstrakurikuler` ([`admin/master/ekskul.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/ekskul.php#L9))
- **Subjudul:** `Daftar kegiatan ekstrakurikuler resmi dan guru pembina.`
- **Widget/Stat Card:** Total Ekskul: `6 Kegiatan` (Pramuka Wajib, PMR, Paskibra, Klub Sains, Futsal, Tahfidz).
- **Tabel Data:** Kolom: `No`, `Nama Kegiatan Ekstrakurikuler`, `Kategori`, `Guru Pembina`, `Jumlah Anggota`, `Aksi`. Sumber: `MockData::getMasterEkskul()`.
- **Tombol & Aksi:** `Tambah Ekskul` (Modal), `Edit`, `Hapus`.
- **Form/Modal:** Modal Form Ekskul: nama, pembina, kategori.
- **Ketergantungan Data:** Terhubung ke penilaian ekstrakurikuler di raport.
- **Catatan Kejujuran:** Data statis.

### 18. Master Prestasi Siswa
- **URL:** `/admin/prestasi`
- **Controller & Method:** [`Admin::masterPrestasi()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L267-L278)
- **Header (H1) di View:** `Master Kategori Prestasi` ([`admin/master/prestasi.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/master/prestasi.php#L9))
- **Subjudul:** `Kategori perlombaan dan tingkat prestasi siswa (Kabupaten/Provinsi/Nasional).`
- **Widget/Stat Card:** Kategori Akademik & Non-Akademik.
- **Tabel Data:** Kolom: `No`, `Nama Prestasi/Perlombaan`, `Bidang`, `Tingkat`, `Aksi`. Sumber: `MockData::getMasterPrestasi()`.
- **Tombol & Aksi:** `Tambah Kategori Prestasi` (Modal).
- **Form/Modal:** Modal input kategori prestasi.
- **Ketergantungan Data:** Digunakan di tab prestasi perwalian.
- **Catatan Kejujuran:** Data statis.

### 19. Kelola Rombongan Belajar / Kelas
- **URL:** `/admin/kelas`
- **Controller & Method:** [`Admin::kelas()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L281-L294)
- **Header (H1) di View:** `Rombongan Belajar (Kelas)` ([`admin/kelas/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/kelas/index.php#L9))
- **Subjudul:** `Manajemen daftar kelas, kapasitas, dan wali kelas aktif tahun ajaran 2025/2026.`
- **Widget/Stat Card:** Total Rombel: `7 Rombel Aktif`, Total Kapasitas: `224 Kursi`, Siswa Terdaftar: `177 Siswa`.
- **Tabel Data:** Kolom: `No`, `Nama Rombel`, `Tingkat`, `Jurusan`, `Wali Kelas`, `Kapasitas / Terisi`, `Status`, `Aksi`. Sumber data: `MockData::getKelas()`.
- **Tombol & Aksi:**
  - `Buka Kelas Baru`: Link GET ke `/admin/kelas/buka`
  - Tombol baris: `Detail Kelas & Siswa` (Link GET ke `/admin/kelas/detail/{id}`), `Edit`, `Hapus`.
- **Form/Modal:** Modal edit kelas (mock).
- **Ketergantungan Data:** Tahun ajaran aktif, data guru (untuk wali kelas).
- **Catatan Kejujuran:** Data dibaca dari `MockData::getKelas()`.

### 20. Form Buka Kelas Baru
- **URL:** `/admin/kelas/buka`
- **Controller & Method:** [`Admin::bukaKelas()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L297-L309)
- **Header (H1) di View:** `Buka Rombel (Kelas) Baru` ([`admin/kelas/form_buka_kelas.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/kelas/form_buka_kelas.php#L9))
- **Subjudul:** `Buka rombongan belajar baru pada tahun ajaran aktif.`
- **Widget/Stat Card:** Panel Panduan Pembukaan Kelas.
- **Tabel Data:** Tidak ada tabel data.
- **Tombol & Aksi:** Form POST ke `/admin/save-action` (`action=Buka Kelas Baru`). Tombol `Simpan & Buka Rombel`.
- **Form/Modal:** Form fields: `nama_kelas` (text), `tingkatan_id` (select), `jurusan_id` (select), `wali_kelas_id` (select guru), `kapasitas` (number max 36). Validasi server: Tidak ada.
- **Ketergantungan Data:** Master tingkatan, jurusan, guru.
- **Catatan Kejujuran:** Submit form hanya redirect dengan flash message tanpa insert ke tabel `kelas`.

### 21. Detail Kelas & Anggota Siswa
- **URL:** `/admin/kelas/detail/(:num)` (contoh: `/admin/kelas/detail/4`)
- **Controller & Method:** [`Admin::detailKelas()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L312-L336)
- **Header (H1) di View:** Dinamis: `Detail Rombel: {kelas['nama_kelas']}` ([`admin/kelas/detail.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/kelas/detail.php#L9))
- **Subjudul:** `Informasi rombel, penugasan wali kelas, dan daftar siswa terdaftar.`
- **Widget/Stat Card:** Wali Kelas: `Ustadz Hendra Gunawan, M.Pd.`, Kapasitas: `31 / 32 Siswa`, Status Pleno: `Sedang Berlangsung`.
- **Tabel Data:** Kolom: `No`, `NIS`, `NISN`, `Nama Lengkap Siswa`, `Jenis Kelamin`, `Status Keaktifan`, `Aksi`. Sumber: `MockData::getSiswaByKelas()`.
- **Tombol & Aksi:** `Tambah Siswa ke Rombel` (Modal), `Keluarkan dari Kelas`, `Pindah Rombel`.
- **Form/Modal:** Modal Pilih Siswa Unassigned.
- **Ketergantungan Data:** Data siswa dan kelas.
- **Catatan Kejujuran:** Tindakan mengeluarkan/memindahkan siswa tidak memutakhirkan kolom `kelas_id` di database.

### 22. Matriks Penugasan Guru Mengajar
- **URL:** `/admin/penugasan`
- **Controller & Method:** [`Admin::penugasan()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L339-L353)
- **Header (H1) di View:** `Penugasan Guru Mengajar` ([`admin/penugasan/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/penugasan/index.php#L9))
- **Subjudul:** `Pemetaan guru pengampu mata pelajaran pada setiap rombongan belajar.`
- **Widget/Stat Card:** Total Penugasan: `14 Penugasan Aktif`, Beban Jam Mengajar: `42 Jam/Minggu`.
- **Tabel Data:** Kolom: `No`, `Nama Guru Pengampu`, `NIP`, `Mata Pelajaran`, `Kelas Rombel`, `Beban Jam`, `KKM Snapshot`, `Bobot Snapshot`, `Aksi`. Sumber: `MockData::getPengajaran()`.
- **Tombol & Aksi:** `Tambah Penugasan Mengajar` (Modal), `Hapus Penugasan`.
- **Form/Modal:** Modal Tambah Penugasan: select `guru_id`, select `mapel_id`, select `kelas_id`, input `jam_per_minggu`, input `kkm_snapshot` (75.00), input `bobot_snapshot` (20.00).
- **Ketergantungan Data:** Guru, Mapel, Kelas.
- **Catatan Kejujuran:** Data penugasan dibaca dari `MockData::getPengajaran()`. Snapshot KKM dan Bobot telah ada di array mock, namun tabel `penugasan` di MySQL tidak digunakan.

### 23. Data Pendidik & Tenaga Kependidikan (Guru)
- **URL:** `/admin/guru`
- **Controller & Method:** [`Admin::guru()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L356-L366)
- **Header (H1) di View:** `Data Pendidik & Tenaga Kependidikan` ([`admin/pengguna/guru_index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/guru_index.php#L9))
- **Subjudul:** `Database resmi guru, wali kelas, dan informasi kepegawaian.`
- **Widget/Stat Card:** Total Pendidik: `24 Guru`, Guru PNS/Yayasan: `18`, Guru Honorer: `6`.
- **Tabel Data:** Kolom: `No`, `NIP / NUPTK`, `Nama Lengkap & Gelar`, `Mata Pelajaran Utama`, `Status Keaktifan`, `Status Wali Kelas`, `No. Telepon / WhatsApp`, `Aksi`. Sumber data: `MockData::getGuru()`.
- **Tombol & Aksi:**
  - `Tambah Guru Baru`: Link GET ke `/admin/guru/tambah`
  - `Edit`: Link GET ke `/admin/guru/edit/{id}`
  - `Hapus`: Form POST konfirmasi
- **Form/Modal:** Modal Konfirmasi Hapus Akun Guru.
- **Ketergantungan Data:** Tidak ada.
- **Catatan Kejujuran:** Data guru dibaca dari array statis `MockData::getGuru()`.

### 24. Form Tambah / Edit Guru
- **URL:** `/admin/guru/tambah` atau `/admin/guru/edit/(:num)`
- **Controller & Method:** [`Admin::guruForm()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L369-L390)
- **Header (H1) di View:** Dinamis: `Tambah Pendidik Baru` atau `Edit Data Pendidik: {guru['nama']}` ([`admin/pengguna/guru_form.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/guru_form.php#L12))
- **Subjudul:** `Lengkapi data identitas resmi, kepegawaian, dan akun login portal guru.`
- **Widget/Stat Card:** Tidak ada widget stat.
- **Tabel Data:** Tidak ada tabel.
- **Tombol & Aksi:** Form POST ke `/admin/save-action` (`action=Data Guru`). Tombol `Simpan Data Guru`.
- **Form/Modal:** Form inputs: `nip`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `email`, `no_hp`, `alamat`, `mapel_utama`, `status_kepegawaian`, `username`, `password`. Validasi controller: Tidak ada validasi.
- **Ketergantungan Data:** Master mapel.
- **Catatan Kejujuran:** Submit form hanya memicu flash message sukses tanpa menyimpan record guru baru ke database.

### 25. Buku Induk Data Siswa
- **URL:** `/admin/siswa`
- **Controller & Method:** [`Admin::siswa()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L393-L404)
- **Header (H1) di View:** `Buku Induk Data Siswa` ([`admin/pengguna/siswa_index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/siswa_index.php#L9))
- **Subjudul:** `Pusat pengelolaan data induk peserta didik, rombel terdaftar, dan status keaktifan.`
- **Widget/Stat Card:** Total Siswa: `177`, Siswa Laki-laki: `89`, Siswa Perempuan: `88`, Siswa Aktif: `176`, Mutasi: `1`.
- **Tabel Data:** Kolom: `No`, `NIS`, `NISN`, `Nama Lengkap Siswa`, `L/P`, `Kelas Saat Ini`, `Status`, `Aksi`. Sumber data: `MockData::getSiswaList()`.
- **Tombol & Aksi:**
  - `Tambah Siswa Baru`: Link GET ke `/admin/siswa/tambah`
  - `Lihat Profil 5 Tab`: Link GET ke `/admin/siswa/detail/{id}`
  - `Edit`: Link GET ke `/admin/siswa/edit/{id}`
- **Form/Modal:** Filter pencarian berdasarkan nama, NIS, dan rombel.
- **Ketergantungan Data:** Rombel kelas.
- **Catatan Kejujuran:** Filter pencarian di view dieksekusi melalui client-side JavaScript / DataTables, controller tidak memproses parameter filter.

### 26. Form Tambah / Edit Siswa
- **URL:** `/admin/siswa/tambah` atau `/admin/siswa/edit/(:num)`
- **Controller & Method:** [`Admin::siswaForm()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L407-L429)
- **Header (H1) di View:** Dinamis: `Pendaftaran Siswa Baru` atau `Edit Data Siswa: {siswa['nama']}` ([`admin/pengguna/siswa_form.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/siswa_form.php#L12))
- **Subjudul:** `Lengkapi identitas pokok siswa sesuai akta kelahiran dan dokumen kependudukan.`
- **Widget/Stat Card:** Panel Petunjuk Input NIS/NISN.
- **Tabel Data:** Tidak ada tabel.
- **Tombol & Aksi:** Form POST ke `/admin/save-action` (`action=Data Siswa`). Tombol `Simpan Data Siswa`.
- **Form/Modal:** Form fields: `nis`, `nisn`, `nik`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `alamat`, `nama_ayah`, `nama_ibu`, `pekerjaan_ayah`, `no_hp_ortu`, `kelas_id`. Validasi server: Tidak ada.
- **Ketergantungan Data:** Data kelas.
- **Catatan Kejujuran:** Form tidak menyimpan record baru ke database.

### 27. Detail Siswa Komprehensif (5 Tab Profil)
- **URL:** `/admin/siswa/detail/(:num)` atau `/admin/siswa/detail/(:num)/(:segment)` (contoh: `/admin/siswa/detail/1/biodata`)
- **Controller & Method:** [`Admin::siswaDetail(, )`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L432-L457)
- **Header (H1) di View:** Dinamis: `Profil Siswa: {siswa['nama']}` ([`admin/pengguna/siswa_detail.php:10`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/siswa_detail.php#L10))
- **Subjudul:** `NIS: {siswa['nis']} &bull; NISN: {siswa['nisn']} &bull; Rombel: {siswa['kelas']}`
- **Widget/Stat Card:** Panel identitas siswa, foto profil, dan navigasi 5 tab: Tab 1 (Biodata), Tab 2 (Orang Tua / Wali), Tab 3 (Riwayat Kelas & Multi-Semester), Tab 4 (Nilai & Raport), Tab 5 (Dokumen & Berkas).
- **Tabel Data:**
  - *Tab 3 (Riwayat Kelas):* Kolom `Tahun Ajaran`, `Semester`, `Kelas Rombel`, `Wali Kelas`, `Status Siswa`, `Peringkat`, `Catatan Mutasi/Kenaikan`. Sumber: `MockData::getSiswaRiwayatKelas()` digabung dengan `session('siswa_riwayat_kelas_overrides')`.
  - *Tab 4 (Nilai Raport):* Kolom `Mata Pelajaran`, `KKM`, `Nilai Pengetahuan`, `Predikat`, `Nilai Keterampilan`, `Predikat`.
  - *Tab 5 (Dokumen):* Kolom `Jenis Dokumen`, `Nomor Dokumen`, `Status Verifikasi`, `Aksi Download/Preview`.
- **Tombol & Aksi:**
  - `Cetak Lembar Biodata`: Window.print()
  - `Cetak Transkrip Kumulatif`: Link GET ke `/admin/siswa/transkrip/{id}`
  - `Proses Mutasi Siswa`: Form modal POST ke `/admin/save-action` (`action=Mutasi Siswa`). Pada controller [`Admin.php:605-620`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L605-L620), aksi ini menyimpan override catatan mutasi ke session key `siswa_riwayat_kelas_overrides`!
- **Form/Modal:** Modal Catat Mutasi Siswa: field `jenis_mutasi` (keluar/masuk), `sekolah_terkait`, `tanggal_mutasi`, `alasan`.
- **Ketergantungan Data:** Riwayat kelas dan nilai siswa.
- **Catatan Kejujuran:** Tab 3 telah mengimplementasikan integrasi skema tabel `siswa_riwayat_kelas`, namun penyimpanan mutasi baru disimpan ke dalam PHP `session()`, bukan query SQL INSERT ke database.

### 28. Data Orang Tua / Wali Siswa
- **URL:** `/admin/orang-tua`
- **Controller & Method:** [`Admin::orangTua()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L460-L489)
- **Header (H1) di View:** `Data Orang Tua & Wali Siswa` ([`admin/pengguna/ortu_index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/ortu_index.php#L9))
- **Subjudul:** `Direktori kontak orang tua siswa untuk komunikasi sekolah dan presensi harian.`
- **Widget/Stat Card:** Total Kontak Orang Tua: `177 Data Terdaftar`.
- **Tabel Data:** Kolom: `No`, `Nama Siswa`, `Kelas`, `Nama Ayah`, `Nama Ibu`, `Pekerjaan Ayah/Ibu`, `No. WhatsApp / Telepon`, `Alamat Tinggal`. Sumber data: diekstrak dari `MockData::getSiswaList()`.
- **Tombol & Aksi:** `Hubungi via WhatsApp` (Link protokol `https://wa.me/`), `Export Kontak` (simulasi button).
- **Form/Modal:** Filter rombel kelas.
- **Ketergantungan Data:** Data siswa.
- **Catatan Kejujuran:** Data orang tua di-derive secara langsung dari field `nama_ayah`, `nama_ibu`, dan `no_ortu` pada array siswa.

### 29. Data Akun & Staf Tata Usaha
- **URL:** `/admin/staff-tu`
- **Controller & Method:** [`Admin::staffTu()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L492-L502)
- **Header (H1) di View:** `Data Staf Tata Usaha` ([`admin/pengguna/staff_tu.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/staff_tu.php#L9))
- **Subjudul:** `Manajemen staf administrasi sekolah, operator SIMS, dan akun persuratan.`
- **Widget/Stat Card:** Total Staf TU: `3 Pegawai`.
- **Tabel Data:** Kolom: `No`, `NIP / NIK`, `Nama Lengkap`, `Jabatan / Peran`, `No. Telepon`, `Email Resmi`, `Status Akun`, `Aksi`. Sumber: `MockData::getStaffTu()`.
- **Tombol & Aksi:** `Tambah Staf TU` (Modal), `Edit`, `Reset Password`.
- **Form/Modal:** Modal input staf TU baru.
- **Ketergantungan Data:** Tidak ada.
- **Catatan Kejujuran:** Data statis.

### 30. Buka Kunci Raport Final & Jejak Rekam Revisi
- **URL:** `/admin/raport/buka-kunci`
- **Controller & Method:** [`Admin::bukaKunciRaport()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L505-L521)
- **Header (H1) di View:** `Buka Kunci Raport Final & Audit Trail` ([`admin/raport/buka_kunci.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/raport/buka_kunci.php#L9))
- **Subjudul:** `Otorisasi pembukaan kunci raport final yang diajukan oleh wali kelas dan riwayat revisi nilai.`
- **Widget/Stat Card:** Status Otorisasi: `1 Permohonan Pending`, Raport Terkunci: `3 Raport`, Total Audit Log Revisi: `5 Catatan Perubahan`.
- **Tabel Data:**
  - *Tabel Permohonan Pending:* Kolom `No`, `NIS`, `Nama Siswa`, `Kelas`, `Diajukan Oleh`, `Alasan Revisi Nilai`, `Waktu Pengajuan`, `Aksi Otorisasi`.
  - *Tabel Audit Log Perubahan Nilai:* Kolom `No`, `Waktu Perubahan`, `Nama Siswa & NIS`, `Kelas/Mapel`, `Komponen`, `Nilai Sebelum`, `Nilai Sesudah`, `Diubah Oleh`, `Disetujui Oleh`, `Alasan`.
- **Tombol & Aksi:** Form POST ke `/admin/save-action`: Tombol `Setujui Buka Kunci` dan `Tolak Permohonan`.
- **Form/Modal:** Modal Form Persetujuan Pembukaan Kunci.
- **Ketergantungan Data:** Permohonan dari menu guru `Guru::raportBukaKunci()`.
- **Catatan Kejujuran:** Saat tombol `Setujui Buka Kunci` ditekan, form mengirim POST ke `/admin/save-action`. Controller hanya melakukan redirect tanpa mengubah status raport di database.

### 31. Ujian Sekolah & Formula Kelulusan (Kelas 12)
- **URL:** `/admin/ujian-sekolah`
- **Controller & Method:** [`Admin::ujianSekolah()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L524-L535)
- **Header (H1) di View:** `Ujian Sekolah & Formula Kelulusan` ([`admin/ujian_sekolah/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/ujian_sekolah/index.php#L12))
- **Subjudul:** `Konfigurasi pembobotan nilai akhir kelulusan (Rapor vs Ujian Sekolah) dan pemantauan nilai US siswa kelas 12.`
- **Widget/Stat Card:** Card Konfigurasi Aktif: Bobot Rapor `60%`, Bobot Ujian Sekolah `40%`, Akumulasi Semester: `6 Semester`, KKM Kelulusan: `75.00`.
- **Tabel Data:** Tabel Rekap Nilai Ujian Sekolah: Kolom `No`, `NIS`, `Nama Siswa`, `Kelas`, `Mapel`, `Nilai Teori`, `Nilai Praktik`, `Nilai Akhir US`, `Status Kelulusan Mapel`.
- **Tombol & Aksi:** Form POST `Simpan Formula Kelulusan` ke `/admin/save-action`. Tombol `Cetak Transkrip` per siswa.
- **Form/Modal:** Form pengaturan formula: `bobot_rapor` (number), `bobot_us` (number), `jumlah_semester_raport` (select 5 atau 6 semester), `kkm_kelulusan` (number).
- **Ketergantungan Data:** Telah disiapkan migrasi skema tabel `formula_kelulusan` dan `ujian_sekolah`.
- **Catatan Kejujuran:** Data dibaca dari method statis `MockData::getFormulaKelulusan()` dan `MockData::getUjianSekolahData()`, belum tersambung ke query SQL.

### 32. Lembar Transkrip Nilai Siswa (Print View)
- **URL:** `/admin/siswa/transkrip/(:num)` (contoh: `/admin/siswa/transkrip/1`)
- **Controller & Method:** [`Admin::transkripSiswa()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L538-L550)
- **Header (H1) di View:** `TRANSKRIP NILAI RESMI SISWA` ([`admin/pengguna/transkrip_cetak.php:40`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/pengguna/transkrip_cetak.php#L40))
- **Subjudul:** `KOP RESMI: SMA IT FITHRAH INSANI &bull; NSS / NPSN: 20224156`
- **Widget/Stat Card:** Panel Identitas Lulusan: Nama, NIS/NISN, Tempat Tanggal Lahir, Program Peminatan, Tanggal Kelulusan.
- **Tabel Data:** Tabel Matriks Capaian Belajar: Kolom `No`, `Mata Pelajaran`, `Sem 1`, `Sem 2`, `Sem 3`, `Sem 4`, `Sem 5`, `Sem 6`, `Rata-rata Rapor (60%)`, `Ujian Sekolah (40%)`, `Nilai Akhir Sekolah`.
- **Tombol & Aksi:** Tombol `Cetak Transkrip Resmi` (`window.print()`), `Kembali ke Detail Siswa`.
- **Form/Modal:** Tidak ada form (lembar cetak dokumen resmi).
- **Ketergantungan Data:** Rekap nilai 6 semester dan nilai ujian sekolah siswa.
- **Catatan Kejujuran:** Format tanda tangan menggunakan istilah valid *'Disahkan Digital oleh Kepala Sekolah'* dengan barcode verifikasi simulasi.

### 33. Konfigurasi Kategori Surat Dinas
- **URL:** `/admin/kategori-surat`
- **Controller & Method:** [`Admin::kategoriSurat()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L553-L563)
- **Header (H1) di View:** `Kategori Surat Dinas` ([`admin/surat/kategori.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/surat/kategori.php#L9))
- **Subjudul:** `Klasifikasi perihal surat masuk dan surat keluar resmi sekolah.`
- **Widget/Stat Card:** Total Kategori: `5 Kategori` (Undangan Resmi, Edaran Dinas, Rekomendasi/Izin, Keterangan Siswa, MoU/Kerjasama).
- **Tabel Data:** Kolom: `No`, `Kode Kategori`, `Nama Kategori Surat`, `Jenis Penerapan`, `Aksi`. Sumber data: `MockData::getKategoriSurat()`.
- **Tombol & Aksi:** `Tambah Kategori` (Modal), `Edit`, `Hapus`.
- **Form/Modal:** Modal Form Kategori Surat.
- **Ketergantungan Data:** Modul persuratan tata usaha.
- **Catatan Kejujuran:** Data statis mock array.

### 34. Format Penomoran Surat Resmi
- **URL:** `/admin/format-surat`
- **Controller & Method:** [`Admin::formatNomorSurat()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L566-L576)
- **Header (H1) di View:** `Format Penomoran Surat Resmi` ([`admin/surat/format_nomor.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/surat/format_nomor.php#L9))
- **Subjudul:** `Pengaturan pola token nomor surat keluar dinas dan aturan reset nomor urut.`
- **Widget/Stat Card:** Preview Format Aktif: `{nomor_urut}/SMA-FI/TU/{bulan_romawi}/{tahun}` (Contoh: `104/SMA-FI/TU/XII/2025`).
- **Tabel Data:** Tabel daftar token yang tersedia (`{nomor_urut}`, `{kode_kategori}`, `{bulan_romawi}`, `{tahun}`, `{sekolah}`).
- **Tombol & Aksi:** Form POST ke `/admin/save-action` (`action=Format Surat`). Tombol `Simpan Pengaturan Pola Nomor`.
- **Form/Modal:** Form input template pola nomor dan aturan reset tahunan.
- **Ketergantungan Data:** Modul persuratan tata usaha.
- **Catatan Kejujuran:** Format nomor surat resmi di modul TU masih di-hardcode string `'104/SMA-FI/TU/XII/2025'`, bukan digenerate secara dinamis dari pola konfigurasi ini.

### 35. Modul Arsip Sentral Terpadu (7 Tab)
- **URL:** `/admin/arsip` atau `/admin/arsip/(:segment)` (contoh: `/admin/arsip/alumni`, `/admin/arsip/raport`)
- **Controller & Method:** [`Admin::arsip()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L579-L597)
- **Header (H1) di View:** `Arsip Sentral Terpadu` ([`admin/arsip/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/arsip/index.php#L9))
- **Subjudul:** `Pusat repositori dokumen historis sekolah: alumni, kenaikan kelas, raport digital, mutasi, dokumen kesiswaan, penugasan, dan persuratan.`
- **Widget/Stat Card:** 7 Tab Navigasi Arsip dengan badge counter berkas.
- **Tabel Data:**
  - *Tab Alumni:* Kolom `No`, `Tahun Lulus`, `NISN`, `Nama Siswa`, `Jurusan`, `No. Seri Ijazah`, `Aksi`.
  - *Tab Kenaikan:* Kolom `Tahun Ajaran`, `Kelas Asal`, `Kelas Tujuan`, `Total Siswa Naik`, `Tinggal`, `Aksi Unduh Berita Acara`.
  - *Tab Raport:* Kolom `Tahun Ajaran`, `Semester`, `Kelas`, `Wali Kelas`, `Jumlah Berkas PDF`, `Aksi Download ZIP`.
  - *Tab Mutasi:* Kolom `Tanggal Mutasi`, `NIS`, `Nama Siswa`, `Jenis (Masuk/Keluar)`, `Sekolah Asal/Tujuan`, `Surat Rekomendasi`.
  - *Tab Dokumen:* Kolom `Kategori Dokumen`, `Nama Berkas`, `Tanggal Unggah`, `Ukuran File`, `Aksi`.
  - *Tab Penugasan:* Kolom `Tahun Ajaran`, `Semester`, `Nama Guru`, `Mata Pelajaran`, `Kelas`.
  - *Tab Surat:* Kolom `Jenis Surat`, `Nomor Surat`, `Tanggal`, `Pengirim / Tujuan`, `Perihal`.
- **Tombol & Aksi:** Filter pencarian per tahun ajaran, tombol `Unduh Dokumen / PDF` (link mock).
- **Form/Modal:** Modal filter arsip.
- **Ketergantungan Data:** Semua data historis akademik.
- **Catatan Kejujuran:** Seluruh data pada 7 tab arsip di-generate dari array mock statis di `Admin.php:586-592`.

### 36. Log Audit Sistem & Jejak Rekam Revisi Nilai
- **URL:** `/admin/log-audit`
- **Controller & Method:** [`Admin::logAudit()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L626-L646)
- **Header (H1) di View:** `Pusat Log Audit & Jejak Rekam Sistem` ([`admin/audit/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/audit/index.php#L9))
- **Subjudul:** `Transparansi dan akuntabilitas perubahan data nilai, status raport, persuratan, dan aktivasi sistem.`
- **Widget/Stat Card:** Total Log Tercatat: `10 Aktivitas`, Log Revisi Nilai: `5 Catatan`, Log Operasional: `5 Catatan`.
- **Tabel Data:**
  - *Tabel 1: Log Revisi Nilai Raport Pasca Buka Kunci:* Kolom `No`, `Waktu Revisi`, `Siswa & NIS`, `Kelas & Mapel`, `Komponen Nilai`, `Nilai Sebelum`, `Nilai Sesudah`, `Pelaku Perubahan`, `Disetujui Oleh (Kepsek)`, `Alasan Perubahan`.
  - *Tabel 2: Log Operasional Sistem:* Kolom `No`, `Waktu`, `Kategori`, `Aktivitas`, `Pelaku`, `Status`, `Detail Keterangan`.
- **Tombol & Aksi:** `Ekspor Log Audit (Excel/CSV)` (simulasi button), Filter kategori log.
- **Form/Modal:** Form filter tanggal dan kategori.
- **Ketergantungan Data:** Data session `audit_log_nilai` yang dihasilkan saat guru menginput revisi nilai pasca buka kunci.
- **Catatan Kejujuran:** Menggunakan sumber data gabungan `session('audit_log_nilai')` dan array default `MockData::getLogPerubahanNilai()`. Belum tersambung ke tabel database migrasi `audit_log_nilai`.

---

## KELOMPOK ROLE 2: GURU (PENDIDIK & WALI KELAS)

### 37. Dashboard Guru (Dual-Mode: Wali Kelas & Guru Mapel)
- **URL:** `/guru`, `/guru/dashboard`, `/guru/dashboard/wali`, atau `/guru/dashboard/mapel`
- **Controller & Method:** [`Guru::dashboard($variant)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L30-L53)
- **Header (H1) di View:** Dinamis: `Dashboard Guru & Wali Kelas` (mode wali) atau `Dashboard Guru Mata Pelajaran` (mode mapel) ([`guru/dashboard.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/dashboard.php#L12))
- **Subjudul:** `Selamat datang kembali, Ustadz Hendra Gunawan, M.Pd. | Semester Ganjil TA 2025/2026`
- **Widget/Stat Card:**
  - *Mapel Diampu:* `2 Mapel` (hardcoded di [`Guru.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L38))
  - *Kelas Diajar:* `3 Kelas` (hardcoded di [`Guru.php:39`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L39))
  - *Total Siswa Diajar:* `92 Siswa` (hardcoded di [`Guru.php:40`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L40))
  - *Progres Raport Rombel:* `85% (26/31 Siswa Selesai)` (hardcoded di [`Guru.php:41`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L41))
- **Tabel Data:** Tabel Pengingat & Agenda Akademik Mendatang (4 item array statis di [`Guru.php:43-48`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L43-L48)).
- **Tombol & Aksi:**
  - Switcher Mode Tampilan: Tombol `Mode Wali Kelas` (GET `/guru/dashboard/wali`) dan `Mode Guru Mapel` (GET `/guru/dashboard/mapel`)
  - Tombol pintas: `Input Nilai Mapel`, `Buku Leger`, `Sidang Pleno Kenaikan`, `Tinjau Raport`
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Penugasan guru dan kelas perwalian.
- **Catatan Kejujuran:** Angka statistik di-hardcode dalam array controller PHP.

### 38. Daftar Mata Pelajaran Saya
- **URL:** `/guru/mapel`
- **Controller & Method:** [`Guru::mapel()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L56-L66)
- **Header (H1) di View:** `Mata Pelajaran Saya` ([`guru/mapel.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/mapel.php#L9))
- **Subjudul:** `Daftar kelas dan mata pelajaran yang Anda ampu pada semester aktif.`
- **Widget/Stat Card:** Card per pengajaran: Nama Mapel, Rombel Kelas, Beban Jam, Jumlah Siswa, Progres Penilaian.
- **Tabel Data:** Menampilkan kartu-kartu mapel (Matematika Wajib XI-MIPA-1, Matematika Peminatan XI-MIPA-1, Matematika Wajib XI-MIPA-2). Sumber: `MockData::getPengajaran()` (3 item pertama).
- **Tombol & Aksi:**
  - `Buku Nilai (Input Nilai)`: Link GET ke `/guru/nilai/{id}/pengetahuan`
  - `Bank Tugas & UH`: Link GET ke `/guru/tugas/{id}`
  - `Presensi KBM`: Link GET ke `/guru/presensi/{id}`
  - `Analitik Nilai`: Link GET ke `/guru/analitik/{id}/mapel`
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Penugasan pengajaran dari Admin.
- **Catatan Kejujuran:** Data dibaca dari array statis `MockData::getPengajaran()`.

### 39. Buku Nilai Mapel (Pengetahuan & Keterampilan)
- **URL:** `/guru/nilai`, `/guru/nilai/(:num)`, atau `/guru/nilai/(:num)/(:segment)` (contoh: `/guru/nilai/1/pengetahuan`, `/guru/nilai/1/keterampilan`)
- **Controller & Method:** [`Guru::inputNilai($pengajaran_id, )`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L138-L177)
- **Header (H1) di View:** Dinamis: `Buku Nilai: {pengajaran['mapel_nama']} - {pengajaran['kelas_nama']}` ([`guru/nilai/input.php:14`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/nilai/input.php#L14))
- **Subjudul:** `Pengelolaan nilai aspek pengetahuan (UH, Tugas, UTS, UAS) dan aspek keterampilan (Praktik, Proyek, Portofolio).`
- **Widget/Stat Card:** Ringkasan Kelas: KKM `75.00`, Rata-rata Kelas `82.4`, Tuntas `4/5 Siswa (80%)`, Perlu Remedial `1 Siswa (Aldi Kurniawan - 71.8)`.
- **Tabel Data:**
  - *Aspek Pengetahuan:* Kolom `No`, `NIS`, `Nama Siswa`, `Rata2 UH (20%)`, `Rata2 Tugas (20%)`, `UTS (25%)`, `UAS (35%)`, `Nilai Akhir (NA)`, `Predikat`, `Deskripsi Capaian Pembelajaran (CP)`, `Aksi Remedial`.
  - *Aspek Keterampilan:* Kolom `No`, `NIS`, `Nama Siswa`, `Praktik (40%)`, `Proyek (30%)`, `Portofolio (30%)`, `Nilai Akhir (NA)`, `Predikat`, `Deskripsi Capaian Kompetensi`.
  - *Sumber Data:* Data matriks siswa dari `Guru::getSiswaNilaiMatrixData($pengajaran_id)` ([`Guru.php:81-90`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L81-L90)) yang tersinkronisasi otomatis dengan rata-rata nilai tugas di session `tugas_scores_{id}`.
- **Tombol & Aksi:**
  - `Sinkronkan Rata-rata Tugas & UH`: Link GET ke `/guru/nilai/{id}/sync-rata-rata`. Menghitung ulang rata-rata tugas dan menyimpan ke `session('siswa_nilai_matrix_{id}')`.
  - `Buka Bank Tugas & UH`: Link GET ke `/guru/tugas/{id}`.
  - `Generate Seluruh Deskripsi CP`: JavaScript generator otomatis berdasarkan KKM dan nilai akhir.
  - `Simpan Nilai`: Form POST ke `/guru/save-action` (`action=Input Nilai`). Menyimpan nilai dan otomatis mencatat jejak rekam perubahan nilai ke `session('audit_log_nilai')` jika nilai final diubah ([`Guru.php:920-970`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L920-L970)).
- **Form/Modal:** Form tabel matriks nilai: input number `uts`, `uas` (pada pengetahuan) atau `praktik`, `proyek`, `portofolio` (pada keterampilan), serta textarea `deskripsi_cp` per siswa.
- **Ketergantungan Data:** Penugasan pengajaran dan daftar siswa rombel.
- **Catatan Kejujuran:** Kalkulasi nilai akhir dilakukan secara live di PHP (`$na = round(($uh * 0.20) + ($tugas * 0.20) + ($uts * 0.25) + ($uas * 0.35), 1)`). Nilai yang di-submit disimpan ke dalam `session('siswa_nilai_matrix_{id}')`, bukan database MySQL.

### 40. Bank Tugas Harian & Ulangan Harian (Index)
- **URL:** `/guru/tugas` atau `/guru/tugas/(:num)`
- **Controller & Method:** [`Guru::tugasHarian($pengajaran_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L190-L232)
- **Header (H1) di View:** Dinamis: `Tugas Harian & Ulangan - {pengajaran['mapel_nama']}` ([`guru/tugas/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/tugas/index.php#L12))
- **Subjudul:** `Rombel: {pengajaran['kelas_nama']} &bull; Semester Ganjil TA 2025/2026`
- **Widget/Stat Card:** Total Penugasan: `4 Tugas / UH Terbit`, Kategori: `2 Tugas Mandiri, 2 Ulangan Harian`, Rata-rata Penilaian Selesai: `100% (5/5 Siswa Dinilai)`.
- **Tabel Data:**
  - *Tabel 1: Daftar Tugas/UH:* Kolom `No`, `Judul Tugas / UH`, `Kategori`, `KD / Materi Pokok`, `Tanggal Terbit`, `Tenggat Waktu`, `Status Dinilai`, `Aksi`.
  - *Tabel 2: Rekapitulasi Rata-rata:* Kolom `No`, `NIS`, `Nama Siswa`, `Tugas 1`, `Tugas 2`, `Rata-rata Tugas`, `UH 1`, `UH 2`, `Rata-rata UH`.
  - *Sumber Data:* `MockData::getTugasHarian($pengajaran_id)` dan `Guru::getTugasScores($pengajaran_id)`.
- **Tombol & Aksi:**
  - `Buat Tugas / UH Baru`: Modal Form Tambah Tugas
  - `Input Nilai`: Link GET ke `/guru/tugas/{pengajaran_id}/nilai/{tugas_id}`
  - `Lihat Rekap Rata-rata`: Tab / Anchor ke tabel rekapitulasi
- **Form/Modal:** Modal Form Buat Tugas Baru: field `judul`, `kategori` (tugas/uh), `materi_pokok`, `tanggal_penugasan`, `tenggat_waktu`, `keterangan`.
- **Ketergantungan Data:** Penugasan pengajaran.
- **Catatan Kejujuran:** Rute pendamping `/guru/tugas/(:num)/rekap` yang tercantum di Routes.php mengalami error karena method `rekapNilaiTugas` tidak dibuat di controller.

### 41. Form Khusus Input Nilai Tugas / Ulangan Terpilih
- **URL:** `/guru/tugas/(:num)/nilai/(:num)` (contoh: `/guru/tugas/1/nilai/1`) atau `/guru/tugas/nilai/(:num)`
- **Controller & Method:** [`Guru::inputNilaiTugas($pengajaran_id, $tugas_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L235-L293) (GET) dan [`Guru::saveNilaiTugas($pengajaran_id, $tugas_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L295-L326) (POST)
- **Header (H1) di View:** Dinamis: `Input Nilai: {tugas['judul']}` ([`guru/tugas/nilai.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/tugas/nilai.php#L12))
- **Subjudul:** `Mapel: {pengajaran['mapel_nama']} &bull; Kelas: {pengajaran['kelas_nama']}`
- **Widget/Stat Card:** Card Info Tugas: Kategori `Tugas Harian`, Bobot Snapshot `20.00%`, KKM Snapshot `75.00`, Rata-rata Kelas `86.6`.
- **Tabel Data:** Kolom: `No`, `NIS`, `Nama Lengkap Siswa`, `Nilai (0-100)`, `Status KKM`, `Catatan Evaluasi Guru`. Sumber data: gabungan siswa kelas dan skor tugas dari `Guru::getTugasScores()`.
- **Tombol & Aksi:** Form POST ke `/guru/tugas/{pengajaran_id}/nilai/{tugas_id}`. Tombol `Simpan Seluruh Nilai Tugas`. Method controller memproses input array `nilai`, menyimpan ke `session('tugas_scores_{id}')`, dan **secara otomatis mengkalkulasi ulang** rata-rata tugas serta nilai akhir di buku nilai ([`Guru.php:313-322`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L313-L322))!
- **Form/Modal:** Input number `nilai[{siswa_id}]` (min 0 max 100), text `catatan[{siswa_id}]`.
- **Ketergantungan Data:** Tugas harian yang telah dibuat.
- **Catatan Kejujuran:** Fitur ini berfungsi dinamis dan tersinkronisasi dua arah ke Buku Nilai, namun persistensinya berada di PHP session.

### 42. Presensi Siswa & Jurnal KBM Guru Mapel
- **URL:** `/guru/presensi`, `/guru/presensi/(:num)`, atau `/guru/presensi/(:num)/tab/(:segment)` (contoh: `/guru/presensi/1/tab/pertemuan`, `/guru/presensi/1/tab/rekap`)
- **Controller & Method:** [`Guru::presensi($pengajaran_id, $tab)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L352-L390)
- **Header (H1) di View:** Dinamis: `Presensi & Jurnal KBM: {pengajaran['mapel_nama']}` ([`guru/presensi/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/presensi/index.php#L12))
- **Subjudul:** `Rombel: {pengajaran['kelas_nama']} &bull; Semester Ganjil TA 2025/2026`
- **Widget/Stat Card:** Total Pertemuan: `16 Pertemuan`, Rata-rata Kehadiran: `95.4%`, Siswa Kritis (<85%): `1 Siswa (Aldi Kurniawan)`.
- **Tabel Data:**
  - *Tab 1 (Daftar Pertemuan & Jurnal):* Kolom `Pertemuan Ke-`, `Hari, Tanggal`, `Jam Ke-`, `Materi Pokok / Jurnal Pembelajaran`, `Hadir`, `Sakit`, `Izin`, `Alpa`, `Aksi Input/Edit`.
  - *Tab 2 (Rekapitulasi Kehadiran per Siswa):* Kolom `No`, `NIS`, `Nama Siswa`, `Total Hadir`, `Sakit`, `Izin`, `Alpa`, `% Kehadiran`, `Status Kelayakan Ujian`.
- **Tombol & Aksi:**
  - `Tambah Pertemuan Baru`: Form Modal POST ke `/guru/presensi/{id}/tambah-pertemuan` ([`Guru.php:513-560`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L513-L560)). Menambahkan pertemuan baru ke session!
  - `Input Presensi`: Link GET ke `/guru/presensi/{id}/input/{pertemuan_id}`
  - `Cetak Jurnal & Rekap Presensi`: Link GET ke `/guru/presensi/{id}/cetak`
- **Form/Modal:** Modal Form Tambah Pertemuan: `pertemuan_ke`, `tanggal`, `jam_ke`, `materi_pembelajaran`.
- **Ketergantungan Data:** Penugasan pengajaran dan daftar siswa.
- **Catatan Kejujuran:** Pertemuan dan rekap kehadiran tersimpan di session (`pertemuan_list_{id}` dan `presensi_detail_map_{id}`).

### 43. Form Input Presensi Pertemuan
- **URL:** `/guru/presensi/(:num)/input/(:num)` (contoh: `/guru/presensi/1/input/16`)
- **Controller & Method:** [`Guru::presensiInput($pengajaran_id, $pertemuan_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L392-L447) (GET) dan [`Guru::savePresensiPertemuan($pengajaran_id, $pertemuan_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L449-L511) (POST)
- **Header (H1) di View:** Dinamis: `Input Presensi Pertemuan Ke-{pertemuan['pertemuan_ke']}` ([`guru/presensi/input.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/presensi/input.php#L12))
- **Subjudul:** `Mapel: {pengajaran['mapel_nama']} &bull; Tanggal: {pertemuan['tanggal']}`
- **Widget/Stat Card:** Card Detail Jurnal: Materi Pokok, Jam Pelajaran, Guru Pengampu.
- **Tabel Data:** Kolom: `No`, `NIS`, `Nama Lengkap Siswa`, `Opsi Kehadiran (Radio: Hadir, Sakit, Izin, Alpa)`, `Catatan Individual Guru`.
- **Tombol & Aksi:** Form POST ke `/guru/presensi/{pengajaran_id}/save/{pertemuan_id}`. Tombol `Simpan Presensi Pertemuan`. Method controller memvalidasi radio button kehadiran, menghitung agregat, dan menyimpan ke session `presensi_detail_map_{id}`.
- **Form/Modal:** Radio buttons `kehadiran[{siswa_id}]` (H/S/I/A), textarea `jurnal_materi`, textarea `catatan_kbm`.
- **Ketergantungan Data:** Data pertemuan KBM.
- **Catatan Kejujuran:** Validasi form memeriksa keberadaan input kehadiran seluruh siswa sebelum menyimpan data ke session.

### 44. Lembar Cetak Jurnal & Rekap Presensi Siswa
- **URL:** `/guru/presensi/(:num)/cetak` (contoh: `/guru/presensi/1/cetak`)
- **Controller & Method:** [`Guru::presensiCetak($pengajaran_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L562-L585)
- **Header (H1) di View:** `JURNAL MENGAJAR & REKAP PRESENSI KBM` ([`guru/presensi/cetak.php:24`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/presensi/cetak.php#L24))
- **Subjudul:** `KOP RESMI: SMA IT FITHRAH INSANI &bull; SEMESTER GANJIL TA 2025/2026`
- **Widget/Stat Card:** Panel Identitas: Nama Guru, NIP, Mapel, Rombel, Total Pertemuan Terealisasi.
- **Tabel Data:**
  - *Bagian A: Log Jurnal Harian KBM (Pertemuan 1 s.d. 16)*
  - *Bagian B: Matriks Rekapitulasi Presensi Siswa per Pertemuan*
- **Tombol & Aksi:** Tombol `Cetak Dokumen Presensi` (`window.print()`), `Kembali ke Halaman Presensi`.
- **Form/Modal:** Tidak ada form (tampilan cetak kertas).
- **Ketergantungan Data:** Jurnal pertemuan dan presensi siswa.
- **Catatan Kejujuran:** Data di-render dari session `pertemuan_list_{id}` dan `presensi_detail_map_{id}`.

### 45. Analitik Nilai & Diagnostik Remedial
- **URL:** `/guru/analitik`, `/guru/analitik/(:num)`, atau `/guru/analitik/(:num)/(:segment)` (contoh: `/guru/analitik/1/mapel`, `/guru/analitik/1/wali`)
- **Controller & Method:** [`Guru::analitik($pengajaran_id, $variant)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L588-L613)
- **Header (H1) di View:** Dinamis: `Analitik Hasil Belajar: {pengajaran['mapel_nama']}` ([`guru/analitik/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/analitik/index.php#L12))
- **Subjudul:** `Distribusi nilai siswa, analisis ketuntasan KKM, dan daftar siswa berstatus remedial.`
- **Widget/Stat Card:** Nilai Tertinggi: `93.2 (Muhammad Raihan Pratama)`, Nilai Terendah: `71.8 (Aldi Kurniawan)`, Rata-rata Kelas: `82.4`, Ketuntasan Klasikal: `80.0% (4/5 Tuntas)`.
- **Tabel Data:**
  - *Tabel Siswa Remedial:* Kolom `No`, `NIS`, `Nama Siswa`, `Nilai Akhir`, `Selisih dari KKM 75`, `Komponen Terendah`, `Rencana Tindak Lanjut / Remedial`.
  - *Distribusi Predikat:* A: 1 siswa, B: 2 siswa, C: 1 siswa, D (Belum Tuntas): 1 siswa.
- **Tombol & Aksi:** Switcher Tampilan (Mode Mapel vs Mode Wali), Tombol `Cetak Laporan Analitik`.
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Nilai akhir dari buku nilai siswa.
- **Catatan Kejujuran:** Angka analitik dihitung dari array matriks nilai siswa.

### 46. Perwalian Terpadu (4 Tab: Sikap, Ekskul, Prestasi, Absensi)
- **URL:** `/guru/perwalian` atau `/guru/perwalian/(:segment)` (contoh: `/guru/perwalian/sikap`, `/guru/perwalian/absensi`)
- **Controller & Method:** [`Guru::perwalian($tab)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L616-L644) (GET) dan [`Guru::saveAbsensiPerwalian()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L646-L668) (POST)
- **Header (H1) di View:** `Perwalian Terpadu: Kelas XI-MIPA-1` ([`guru/perwalian/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/perwalian/index.php#L12))
- **Subjudul:** `Wali Kelas: Ustadz Hendra Gunawan, M.Pd. &bull; Kelola nilai non-akademik raport.`
- **Widget/Stat Card:** 4 Tab: Tab 1 Sikap (100% Terisi), Tab 2 Ekstrakurikuler (100% Terisi), Tab 3 Prestasi Siswa (2 Prestasi Dicatat), Tab 4 Rekap Kehadiran/Absensi (5 Siswa).
- **Tabel Data:**
  - *Tab 1 (Sikap):* Kolom `No`, `Nama Siswa`, `Predikat Sikap Spiritual`, `Deskripsi Sikap Spiritual`, `Predikat Sikap Sosial`, `Deskripsi Sikap Sosial`.
  - *Tab 2 (Ekskul):* Kolom `No`, `Nama Siswa`, `Kegiatan Ekstrakurikuler 1`, `Nilai`, `Ekstrakurikuler 2`, `Nilai`, `Keterangan`.
  - *Tab 3 (Prestasi):* Kolom `No`, `Nama Siswa`, `Jenis Prestasi`, `Tingkat Perlombaan`, `Peringkat / Capaian`, `Keterangan`.
  - *Tab 4 (Absensi):* Kolom `No`, `Nama Siswa`, `Sakit (Hari)`, `Izin (Hari)`, `Tanpa Keterangan / Alpa (Hari)`, `Catatan Wali Kelas`.
- **Tombol & Aksi:** Form POST ke `/guru/perwalian/absensi`. Tombol `Simpan Rekap Kehadiran (Absensi)`. Controller menyimpan array `sakit`, `izin`, `tanpa_keterangan`, `catatan` ke `session('absensi_perwalian_4')` yang otomatis disinkronkan ke Raport Digital Bagian E ([`Guru.php:664`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L664))!
- **Form/Modal:** Form inputs: number `sakit[{id}]`, `izin[{id}]`, `tanpa_keterangan[{id}]`, text `catatan[{id}]`.
- **Ketergantungan Data:** Siswa rombel perwalian.
- **Catatan Kejujuran:** Fitur absensi perwalian bekerja penuh dengan sinkronisasi ke lembar raport, disimpan di session.

### 47. Leger Nilai Kelas (Matriks Nilai Rombel)
- **URL:** `/guru/leger` atau `/guru/matriks-nilai`
- **Controller & Method:** [`Guru::legerNilai()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L671-L699)
- **Header (H1) di View:** `Leger Nilai Kelas: XI-MIPA-1` ([`guru/leger/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/leger/index.php#L12))
- **Subjudul:** `Wali Kelas: Ustadz Hendra Gunawan, M.Pd. &bull; Tahun Ajaran 2025/2026 Semester Ganjil`
- **Widget/Stat Card:** Peringkat 1 Umum: `Muhammad Raihan Pratama (Rata-rata 89.6)`, Peringkat 2: `Aisyah Azzahra Putri (87.4)`, Peringkat 3: `Farhan Ramadhan (84.2)`, Rata-rata Kelas: `83.1`.
- **Tabel Data:** Matriks Leger Komprehensif: Kolom `No`, `NIS`, `Nama Siswa`, `PAI`, `PPKN`, `IND`, `MAT-W`, `SEJ`, `ING`, `MAT-P`, `BIO`, `FIS`, `KIM`, `SND`, `ARAB`, `Total Nilai`, `Rata-rata`, `Peringkat Kelas`.
- **Tombol & Aksi:** `Cetak Leger Nilai Resmi` (`window.print()`), `Ekspor Excel (CSV)` (simulasi button).
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Nilai seluruh mata pelajaran dari guru-guru pengampu.
- **Catatan Kejujuran:** Data nilai seluruh mapel dihitung dari `MockData::getLegerNilaiKelas()`. Seluruh nilai mapel lain telah terisi dari mock data.

### 48. Keputusan Kenaikan Kelas & Sidang Pleno
- **URL:** `/guru/kenaikan-kelas`
- **Controller & Method:** [`Guru::kenaikanKelas()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L702-L747) (GET) dan [`Guru::savePlenoKenaikan()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L749-L773) (POST)
- **Header (H1) di View:** `Keputusan Kenaikan Kelas & Sidang Pleno` ([`guru/kenaikan/index.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/kenaikan/index.php#L12))
- **Subjudul:** `Sidang penetapan kenaikan kelas rombel XI-MIPA-1 oleh Wali Kelas, Dewan Guru, dan Kepala Sekolah.`
- **Widget/Stat Card:** Status Pleno Rombel: `Sedang Berlangsung`, Ringkasan Usulan: Total `5 Siswa`, Usulan Naik: `4 Siswa`, Usulan Tinggal Kelas: `1 Siswa (Aldi Kurniawan)`.
- **Tabel Data:** Kolom: `No`, `NIS`, `Nama Siswa`, `Rata-rata Nilai`, `Kehadiran (%)`, `Mapel Bawah KKM`, `Predikat Sikap`, `Keputusan Usulan Wali Kelas (Select)`, `Rombel Tujuan (Select)`, `Status Pengesahan Pleno`, `Catatan Sidang Pleno`.
- **Tombol & Aksi:**
  - `Simpan Usulan Wali Kelas`: Form POST ke `/guru/kenaikan-kelas` (`tindakan=simpan_usulan`). Menyimpan usulan ke `session('pleno_kenaikan_data')` dengan status pleno tetap `belum_disahkan`.
  - `Sahkan Sidang Pleno Resmi`: Form POST ke `/guru/kenaikan-kelas` (`tindakan=sahkan_pleno`). Menyimpan keputusan ke `session('pleno_kenaikan_data')` dan mengubah flag status pleno siswa menjadi `disahkan_pleno` ([`Guru.php:762`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L762)).
- **Form/Modal:** Form inputs: select `status_usulan[{id}]` (naik/tinggal_kelas/lulus), select `kelas_tujuan[{id}]`, text `catatan[{id}]`, hidden `tindakan`.
- **Ketergantungan Data:** Nilai akhir, absensi, dan sikap siswa.
- **Catatan Kejujuran:** Pengesahan pleno di sini **TIDAK TERHUBUNG** ke pemeriksaan gatekeeper di `Admin::wizard()`, karena `Admin::wizard()` memeriksa static array `MockData::isSemuaPlenoSelesai()` dan mengabaikan session `pleno_kenaikan_data`.

### 49. Generate & Ringkasan Kelayakan Raport Digital
- **URL:** `/guru/raport/generate`
- **Controller & Method:** [`Guru::raportGenerate()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L776-L799)
- **Header (H1) di View:** `Generate & Ringkasan Raport Digital` ([`guru/raport/generate.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/raport/generate.php#L12))
- **Subjudul:** `Rombel: XI-MIPA-1 &bull; Periksa kelengkapan nilai sebelum finalisasi raport.`
- **Widget/Stat Card:** Kesiapan Raport: `4/5 Siswa Siap Terbit (80%)`, Nilai Belum Lengkap: `1 Siswa (Aldi Kurniawan - Nilai UAS Matematika belum masuk)`.
- **Tabel Data:** Kolom: `No`, `NIS`, `Nama Siswa`, `Nilai Akademik`, `Sikap`, `Ekskul`, `Absensi`, `Catatan Wali`, `Kelayakan Terbit`, `Status Raport`, `Aksi`.
- **Tombol & Aksi:** `Tinjau Raport`: Link GET ke `/guru/raport/tinjau/{id}`.
- **Form/Modal:** Modal Konfirmasi Generate Massal.
- **Ketergantungan Data:** Seluruh modul nilai mapel, perwalian, dan absensi.
- **Catatan Kejujuran:** Data kelayakan dihitung dari kelengkapan nilai di MockData.

### 50. Tinjau Raport Digital Siswa (Paper View Section A-F)
- **URL:** `/guru/raport/tinjau` atau `/guru/raport/tinjau/(:num)` (contoh: `/guru/raport/tinjau/1`)
- **Controller & Method:** [`Guru::raportTinjau($siswa_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L802-L829) (GET) dan [`Guru::finalisasiRaport($siswa_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L831-L855) (POST)
- **Header (H1) di View:** Dinamis: `Tinjau Raport: {raport['siswa']['nama']}` ([`guru/raport/tinjau.php:14`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/raport/tinjau.php#L14))
- **Subjudul:** `NIS: {raport['siswa']['nis']} &bull; Rombel: {raport['siswa']['kelas']}`
- **Widget/Stat Card:** Status Dokumen Raport: Badge `Draft`, `Menunggu Persetujuan Kepala Sekolah`, atau `Final (Disahkan Resmi)`.
- **Tabel Data:** Format Resmi Standar Raport Paper View:
  - *Bagian A: Identitas Peserta Didik & Sekolah*
  - *Bagian B: Sikap Spiritual & Sikap Sosial*
  - *Bagian C: Capaian Nilai Pengetahuan & Keterampilan (Seluruh Mapel Kurikulum)*
  - *Bagian D: Kegiatan Ekstrakurikuler & Prestasi*
  - *Bagian E: Ketidakhadiran (Sakit, Izin, Tanpa Keterangan) (terhubung ke `session('absensi_perwalian_4')`)*
  - *Bagian F: Catatan Perkembangan Karakter Wali Kelas & Keputusan Kenaikan/Kelulusan*
  - *Bagian Lembar Tanda Tangan: Tanda Tangan Orang Tua, Wali Kelas, dan Kepala Sekolah (Disahkan Digital)*
- **Tombol & Aksi:**
  - `Kunci & Ajukan ke Kepala Sekolah`: Form POST ke `/guru/raport/finalisasi/{id}` (`tahap=ajukan_kepsek`). Mengubah session status menjadi `menunggu_persetujuan_kepsek`.
  - `Sahkan Raport Resmi (Kepala Sekolah)`: Form POST ke `/guru/raport/finalisasi/{id}` (`tahap=sahkan_kepsek`). Mengubah session status menjadi `final`.
  - `Tolak / Kembalikan ke Draft`: Form POST ke `/guru/raport/finalisasi/{id}` (`tahap=tolak_kepsek`). Mengembalikan session status ke `draft` dan mencatat catatan penolakan.
  - `Ajukan Buka Kunci Raport`: Link GET ke `/guru/raport/buka-kunci/{id}`.
- **Form/Modal:** Modal Konfirmasi Pengesahan Raport dan Modal Penolakan / Revisi.
- **Ketergantungan Data:** Seluruh nilai dan rekap perwalian.
- **Catatan Kejujuran:** Transisi status raport berpindah antar status di dalam `session('raport_status_{id}')`. Tidak ada middleware yang membatasi role; siapapun dapat mengeksekusi request POST `tahap=sahkan_kepsek`.

### 51. Permohonan Buka Kunci Raport Final (Revisi Nilai)
- **URL:** `/guru/raport/buka-kunci` atau `/guru/raport/buka-kunci/(:num)`
- **Controller & Method:** [`Guru::raportBukaKunci($siswa_id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L858-L887)
- **Header (H1) di View:** Dinamis: `Buka Kunci Raport Final - {raport['siswa']['nama']}` ([`guru/raport/buka_kunci.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/guru/raport/buka_kunci.php#L12))
- **Subjudul:** `Pengajuan permohonan resmi kepada Kepala Sekolah / Administrator untuk membuka kembali raport yang telah final.`
- **Widget/Stat Card:** Status Raport: `Final (Terkunci)`. Status Permohonan: `Menunggu Persetujuan Admin` (jika sudah diajukan).
- **Tabel Data:** Riwayat permohonan buka kunci dan jejak revisi nilai terdahulu.
- **Tombol & Aksi:** Form POST ke `/guru/save-action` (`action=Permohonan Buka Kunci Raport`). Tombol `Kirim Permohonan Buka Kunci`.
- **Form/Modal:** Form inputs: `alasan_revisi` (textarea), `komponen_nilai_diubah` (checkboxes: UH/Tugas/UTS/UAS/Sikap/Ekskul).
- **Ketergantungan Data:** Raport yang telah berstatus final.
- **Catatan Kejujuran:** Submit form permohonan ini hanya memicu redirect flash message tanpa menyimpan record permohonan ke database.

---

## KELOMPOK ROLE 3: TATA USAHA (TU)

### 52. Dashboard Tata Usaha (TU)
- **URL:** `/tu` atau `/tu/`
- **Controller & Method:** [`Tu::dashboard()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L28-L52)
- **Header (H1) di View:** `Dashboard Tata Usaha` ([`tu/dashboard.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/dashboard.php#L9))
- **Subjudul:** `Pusat kendali persuratan resmi, disposisi pimpinan, dan buku agenda sekolah.`
- **Widget/Stat Card:** Surat Masuk Bulan Ini: `12 Berkas`, Surat Keluar Terbit: `8 Surat`, Menunggu Disposisi Pimpinan: `3 Surat`, Draft Surat Keluar: `2 Draft`.
- **Tabel Data:** Tabel Surat Masuk Terbaru yang Memerlukan Tindak Lanjut (3 item dari `MockData::getSuratMasuk()`).
- **Tombol & Aksi:**
  - `Catat Surat Masuk Baru`: Link GET ke `/tu/surat-masuk/tambah`
  - `Buat Surat Keluar Baru`: Link GET ke `/tu/surat-keluar/tambah`
  - `Cetak Buku Agenda`: Link GET ke `/tu/agenda`
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Modul persuratan.
- **Catatan Kejujuran:** Data ringkasan dihitung dari array `MockData::getSuratMasuk()` dan `MockData::getSuratKeluar()`.

### 53. Buku Registrasi Surat Masuk
- **URL:** `/tu/surat-masuk`
- **Controller & Method:** [`Tu::suratMasuk()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L55-L66)
- **Header (H1) di View:** `Buku Registrasi Surat Masuk` ([`tu/surat_masuk/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_masuk/index.php#L9))
- **Subjudul:** `Pencatatan dan pemantauan surat masuk dinas serta status disposisi pimpinan.`
- **Widget/Stat Card:** Total Surat Masuk: `4 Surat Dicatat`, Sifat: 3 Biasa/Penting, 1 Rahasia.
- **Tabel Data:** Kolom: `No. Agenda`, `No. Surat & Asal Pengirim`, `Tanggal Surat / Diterima`, `Perihal`, `Sifat Surat`, `Status Disposisi`, `Aksi`. Sumber data: `MockData::getSuratMasuk()`.
- **Tombol & Aksi:**
  - `Catat Surat Masuk Baru`: Link GET ke `/tu/surat-masuk/tambah`
  - `Detail & Lembar Disposisi`: Link GET ke `/tu/surat-masuk/detail/{id}`
- **Form/Modal:** Filter sifat dan status disposisi.
- **Ketergantungan Data:** Kategori surat.
- **Catatan Kejujuran:** Pada tabel daftar ini, dokumen berstatus 'Rahasia' tetap ditampilkan ke seluruh user yang membuka halaman ini tanpa penyaringan role.

### 54. Form Pencatatan Surat Masuk Baru
- **URL:** `/tu/surat-masuk/tambah`
- **Controller & Method:** [`Tu::suratMasukTambah()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L69-L80)
- **Header (H1) di View:** `Pencatatan Surat Masuk Baru` ([`tu/surat_masuk/form.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_masuk/form.php#L9))
- **Subjudul:** `Catat surat masuk dinas, berikan nomor agenda otomatis, dan lampirkan pindaian berkas.`
- **Widget/Stat Card:** Nomor Agenda Otomatis Berikutnya: `SM-2025-00145` (hardcoded di controller [`Tu.php:75`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L75)).
- **Tabel Data:** Tidak ada tabel.
- **Tombol & Aksi:** Form POST ke `/tu/save-action` (`action=Pencatatan Surat Masuk`). Tombol `Simpan & Cetak Lembar Disposisi`.
- **Form/Modal:** Form inputs: `nomor_agenda` (readonly), `nomor_surat` (text), `pengirim` (text), `tanggal_surat` (date), `tanggal_diterima` (date), `perihal` (text), `sifat` (select: Biasa/Penting/Rahasia), `file_lampiran` (file upload). Validasi server: Tidak ada.
- **Ketergantungan Data:** Tidak ada.
- **Catatan Kejujuran:** Nomor agenda di-hardcode string di controller. Submit form hanya redirect dengan flash message tanpa insert ke tabel `surat_masuk`.

### 55. Detail Surat Masuk & Lembar Disposisi Digital
- **URL:** `/tu/surat-masuk/detail/(:num)` (contoh: `/tu/surat-masuk/detail/1`)
- **Controller & Method:** [`Tu::suratMasukDetail($id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L83-L111)
- **Header (H1) di View:** Dinamis: `Detail Surat Masuk: {surat['nomor_agenda']}` ([`tu/surat_masuk/detail.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_masuk/detail.php#L12))
- **Subjudul:** `Nomor Surat: {surat['nomor_surat']} &bull; Asal: {surat['pengirim']}`
- **Widget/Stat Card:** Status Disposisi: `Sudah Didisposisikan` / `Menunggu Instruksi Kepala Sekolah`. Sifat: `Biasa` / `Rahasia`.
- **Tabel Data:** Informasi detail surat dan log instruksi disposisi (Tujuan Disposisi: Waka Kurikulum, Instruksi: Hadiri dan tindak lanjuti).
- **Tombol & Aksi:**
  - `Cetak Lembar Disposisi Resmi`: `window.print()`
  - `Simpan Lembar Disposisi`: Form POST ke `/tu/save-action` (`action=Disposisi Surat Masuk`)
- **Form/Modal:** Form pengisian disposisi oleh pimpinan: checkbox tujuan disposisi (Waka Kurikulum, Waka Kesiswaan, Guru Pembina, dll.), textarea instruksi/catatan pimpinan.
- **Ketergantungan Data:** Surat masuk terdaftar.
- **Catatan Kejujuran:** Filter dokumen rahasia di controller [`Tu.php:95-99`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L95-L99) menggunakan `$userRole = session()->get('role') ?? 'tu'`. Karena default-nya adalah `'tu'`, siapapun yang mengakses URL tanpa login akan lolos pengecekan.

### 56. Buku Registrasi Surat Keluar
- **URL:** `/tu/surat-keluar`
- **Controller & Method:** [`Tu::suratKeluar()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L126-L137)
- **Header (H1) di View:** `Buku Registrasi Surat Keluar` ([`tu/surat_keluar/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_keluar/index.php#L9))
- **Subjudul:** `Pengelolaan penerbitan surat dinas, nomor surat resmi otomatis, dan tracking status TTD Kepala Sekolah.`
- **Widget/Stat Card:** Total Surat Keluar: `3 Surat`, Draft (Belum Mengonsumsi Nomor): `1 Draft`, Menunggu TTD: `1 Surat`, Disahkan Resmi: `1 Surat`.
- **Tabel Data:** Kolom: `Nomor Surat / Draft`, `Tujuan Surat`, `Perihal`, `Kategori`, `Tanggal Surat`, `Status Penerbitan`, `Aksi`. Sumber data: `Tu::getMergedSuratKeluar()` ([`Tu.php:113-123`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L113-L123)) yang menggabungkan mock data dengan `session('surat_keluar_overrides')`.
- **Tombol & Aksi:**
  - `Buat Surat Keluar Baru`: Link GET ke `/tu/surat-keluar/tambah`
  - `Detail & Status TTD`: Link GET ke `/tu/surat-keluar/detail/{id}`
  - `Ajukan TTD Pimpinan`: Link GET ke `/tu/surat-keluar/ajukan-ttd/{id}` ([`Tu.php:183-195`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L183-L195)). Mengubah status menjadi `menunggu_ttd` dan **menerbitkan nomor resmi di session** (`104/SMA-FI/TU/XII/2025`).
  - `Batalkan Draft`: Link GET ke `/tu/surat-keluar/batalkan-draft/{id}` ([`Tu.php:198-209`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L198-L209)). Mengubah status menjadi `dibatalkan` tanpa mengonsumsi nomor urut.
- **Form/Modal:** Filter kategori dan status.
- **Ketergantungan Data:** Kategori surat.
- **Catatan Kejujuran:** Alur 'anti-nomor bolong' disimulasikan menggunakan array session PHP. Nomor resmi `104/SMA-FI/TU/XII/2025` di-hardcode string.

### 57. Form Pembuatan Surat Keluar Baru
- **URL:** `/tu/surat-keluar/tambah`
- **Controller & Method:** [`Tu::suratKeluarTambah()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L140-L151)
- **Header (H1) di View:** `Buat Surat Keluar Baru` ([`tu/surat_keluar/form.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_keluar/form.php#L9))
- **Subjudul:** `Form pembuatan konsep surat dinas, penentuan nomor draft sementara, dan permohonan TTD pimpinan.`
- **Widget/Stat Card:** Banner Informasi Alur Anti-Bolong: Nomor resmi dinas baru diterbitkan saat diajukan ke Kepala Sekolah.
- **Tabel Data:** Tidak ada tabel.
- **Tombol & Aksi:** Form POST ke `/tu/save-action` (`action=Pembuatan Surat Keluar`). Tombol `Simpan Sebagai Draft` dan `Simpan & Ajukan TTD Langsung`.
- **Form/Modal:** Form inputs: `nomor_draft` (readonly `DRAFT-2025-003`), `kategori_id` (select), `tujuan` (text), `perihal` (text), `sifat` (select), `lampiran` (text), `isi_ringkas` (textarea).
- **Ketergantungan Data:** Kategori surat.
- **Catatan Kejujuran:** Form submit mengirim request ke `/tu/save-action` yang hanya me-redirect.

### 58. Detail Surat Keluar & Pengajuan TTD
- **URL:** `/tu/surat-keluar/detail/(:num)` (contoh: `/tu/surat-keluar/detail/1`)
- **Controller & Method:** [`Tu::suratKeluarDetail($id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L154-L180)
- **Header (H1) di View:** Dinamis: `Detail Surat Keluar: {surat['nomor_surat'] ?? surat['nomor_draft']}` ([`tu/surat_keluar/detail.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/surat_keluar/detail.php#L12))
- **Subjudul:** `Tujuan: {surat['tujuan']} &bull; Perihal: {surat['perihal']}`
- **Widget/Stat Card:** Status Dokumen: Badge `Draft`, `Menunggu TTD Pimpinan`, atau `Disahkan Resmi`.
- **Tabel Data:** Rincian surat dinas, pembuat draft, penandatangan (Drs. H. Ahmad Fauzi, M.Pd.), barcode verifikasi digital.
- **Tombol & Aksi:**
  - `Ajukan TTD Pimpinan`: Link GET ke `/tu/surat-keluar/ajukan-ttd/{id}`
  - `Batalkan Draft`: Link GET ke `/tu/surat-keluar/batalkan-draft/{id}`
  - `Cetak Dokumen Surat`: `window.print()`
- **Form/Modal:** Modal Batalkan Surat.
- **Ketergantungan Data:** Data surat keluar.
- **Catatan Kejujuran:** Pengecekan surat rahasia di controller [`Tu.php:166-170`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L166-L170) juga default ke `'tu'` jika session kosong.

### 59. Arsip Surat Terpadu (Masuk & Keluar)
- **URL:** `/tu/arsip` atau `/tu/arsip/(:segment)` (contoh: `/tu/arsip/masuk`, `/tu/arsip/keluar`)
- **Controller & Method:** [`Tu::arsipSurat($tab)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L212-L227)
- **Header (H1) di View:** `Arsip Surat Masuk & Keluar` ([`tu/arsip/index.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/arsip/index.php#L9))
- **Subjudul:** `Repositori arsip dokumen surat dinas yang telah selesai diproses.`
- **Widget/Stat Card:** Tab Navigasi: Arsip Surat Masuk (4 Berkas), Arsip Surat Keluar (3 Berkas).
- **Tabel Data:** Kolom: `No`, `Nomor Surat / Agenda`, `Tanggal`, `Pengirim / Tujuan`, `Perihal`, `Kategori`, `Aksi Unduh Berkas / Detail`.
- **Tombol & Aksi:** Filter pencarian per rentang tanggal dan kategori surat.
- **Form/Modal:** Modal filter arsip.
- **Ketergantungan Data:** Data surat masuk dan keluar.
- **Catatan Kejujuran:** Data statis dari MockData.

### 60. Cetak Buku Agenda Surat Terpadu
- **URL:** `/tu/agenda`
- **Controller & Method:** [`Tu::bukuAgenda()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L230-L271)
- **Header (H1) di View:** `BUKU AGENDA PERSURATAN RESMI SEKOLAH` ([`tu/buku_agenda.php:14`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/tu/buku_agenda.php#L14))
- **Subjudul:** `KOP RESMI: SMA IT FITHRAH INSANI &bull; PERIODE: SEMESTER GANJIL TA 2025/2026`
- **Widget/Stat Card:** Total Catatan Agenda: `7 Surat (4 Masuk, 3 Keluar)`.
- **Tabel Data:** Kolom: `No. Urut`, `Jenis Surat`, `No. Agenda`, `No. Surat Resmi`, `Tanggal Diterima/Surat`, `Asal Pengirim / Tujuan`, `Perihal`, `Status Terakhir`.
- **Tombol & Aksi:** Tombol `Cetak Buku Agenda Resmi` (`window.print()`), `Ekspor Format Laporan (CSV)`.
- **Form/Modal:** Form filter rentang tanggal agenda.
- **Ketergantungan Data:** Seluruh surat masuk dan keluar.
- **Catatan Kejujuran:** Seluruh data surat digabungkan dalam array PHP oleh controller tanpa query SQL relasional.

---

## KELOMPOK ROLE 4: SISWA & ALUMNI

### 61. Beranda Portal Siswa
- **URL:** `/siswa` atau `/siswa/`
- **Controller & Method:** [`Siswa::beranda()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L30-L50)
- **Header (H1) di View:** `Beranda Portal Siswa` ([`siswa/beranda.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/beranda.php#L9))
- **Subjudul:** `Selamat datang di portal akademik SMA IT Fithrah Insani, Muhammad Raihan Pratama.`
- **Widget/Stat Card:**
  - *Status Akademik:* `Siswa Aktif (Tingkat 11 - XI-MIPA-1)`
  - *Rata-rata Semester Ini:* `89.6 (Peringkat 1 Kelas)`
  - *Kehadiran:* `96.8% (Hadir 15, Sakit 1, Izin 0, Alpa 0)`
  - *Status Raport:* `Final (Sudah Terbit)`
- **Tabel Data:** Ringkasan Nilai 5 Mata Pelajaran Utama Teratas (PAI, MAT-W, BIO, FIS, ING).
- **Tombol & Aksi:**
  - `Lihat Transparansi Nilai`: Link GET ke `/siswa/nilai`
  - `Pratinjau Raport Digital`: Link GET ke `/siswa/raport/preview/1`
  - `Status Kenaikan Kelas`: Link GET ke `/siswa/status`
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Nilai dan raport siswa yang bersangkutan.
- **Catatan Kejujuran:** Profil siswa di-hardcode ke Siswa ID 1 (Muhammad Raihan Pratama) di controller [`Siswa.php:16-20`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L16-L20).

### 62. Profil Siswa & Riwayat Akademik
- **URL:** `/siswa/profil`
- **Controller & Method:** [`Siswa::profil()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L52-L62)
- **Header (H1) di View:** `Profil Pribadi & Riwayat Akademik` ([`siswa/profil.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/profil.php#L9))
- **Subjudul:** `Informasi data induk siswa, data orang tua, dan histori perjalanan kelas.`
- **Widget/Stat Card:** Panel Identitas Diri, Wali Kelas (`Ustadz Hendra Gunawan, M.Pd.`), Sekolah Asal (`SMP IT Fithrah Insani`).
- **Tabel Data:** Tabel Riwayat Kelas & Multi-Semester (Tabel `siswa_riwayat_kelas`): Kolom `Tahun Ajaran`, `Semester`, `Kelas Rombel`, `Wali Kelas`, `Status`, `Rata-rata`, `Peringkat`. Sumber data: `MockData::getSiswaRiwayatKelas(1)`.
- **Tombol & Aksi:** `Unduh Kartu Pelajar Digital` (simulasi button).
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Data induk siswa.
- **Catatan Kejujuran:** Data riwayat kelas telah diintegrasikan di view sesuai skema migrasi tabel `siswa_riwayat_kelas`, namun datanya bersumber dari static mock library.

### 63. Transparansi Nilai Semester Siswa
- **URL:** `/siswa/nilai` atau `/siswa/nilai/(:segment)` (contoh: `/siswa/nilai/pengetahuan`, `/siswa/nilai/keterampilan`)
- **Controller & Method:** [`Siswa::nilai()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L65-L79)
- **Header (H1) di View:** `Transparansi Nilai Hasil Belajar` ([`siswa/nilai.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/nilai.php#L9))
- **Subjudul:** `Pemantauan nilai harian, ulangan, tugas, dan ujian secara real-time.`
- **Widget/Stat Card:** Navigasi Tab: Aspek Pengetahuan (12 Mapel Tuntas) & Aspek Keterampilan (12 Mapel Tuntas).
- **Tabel Data:** Kolom: `No`, `Mata Pelajaran`, `Guru Pengampu`, `KKM`, `Rata-rata UH`, `Rata-rata Tugas`, `UTS`, `UAS`, `Nilai Akhir`, `Predikat`, `Status Kelulusan KKM`.
- **Tombol & Aksi:** Tab switcher (Pengetahuan vs Keterampilan), tombol `Rincian Tugas`.
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Buku nilai guru.
- **Catatan Kejujuran:** Data nilai dibaca dari `MockData::getNilaiSiswa(1)`.

### 64. Status Akademik & Keputusan Kenaikan / Kelulusan
- **URL:** `/siswa/status` atau `/siswa/status/(:segment)` (contoh: `/siswa/status/biasa`, `/siswa/status/akhir`)
- **Controller & Method:** [`Siswa::statusAkademik($variant)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L82-L113)
- **Header (H1) di View:** `Status Akademik & Kenaikan Kelas` ([`siswa/status.php:12`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/status.php#L12))
- **Subjudul:** `Pengumuman resmi hasil Sidang Pleno Kenaikan Kelas Dewan Guru dan Kepala Sekolah.`
- **Widget/Stat Card:** Banner Status Utama: `SELAMAT! Anda Dinyatakan NAIK KE KELAS XII (XII-MIPA-1)` dengan lencana verifikasi hijau.
- **Tabel Data:** Tabel Parameter Kelayakan Kenaikan Kelas: Kriteria Ketuntasan Belajar (Memenuhi KKM), Nilai Sikap Minimal (Sangat Baik), Kehadiran Kumulatif (96.8% > 85%).
- **Tombol & Aksi:** Switcher Simulasi Pengujian: Tombol `[Simulasi] Siswa Kelas 10/11` (GET `/siswa/status/biasa`) dan `[Simulasi] Siswa Kelas 12 (Kelulusan)` (GET `/siswa/status/akhir`).
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Keputusan sidang pleno.
- **Catatan Kejujuran:** Halaman ini menyediakan tombol simulator UI untuk menguji tampilan kelulusan vs kenaikan kelas.

### 65. Riwayat Lembar Raport Digital Siswa
- **URL:** `/siswa/raport`
- **Controller & Method:** [`Siswa::raportList()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L116-L132)
- **Header (H1) di View:** `Riwayat Raport Digital Siswa` ([`siswa/raport_list.php:9`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/raport_list.php#L9))
- **Subjudul:** `Daftar buku raport resmi per semester yang telah disahkan digital oleh Kepala Sekolah.`
- **Widget/Stat Card:** Total Raport Tersedia: `3 Semester Terbit`.
- **Tabel Data:** Kolom: `Tahun Ajaran`, `Semester`, `Kelas Rombel`, `Wali Kelas`, `Peringkat Kelas`, `Tanggal Disahkan`, `Status Dokumen`, `Aksi Pratinjau & Cetak`.
- **Tombol & Aksi:** `Buka Lembar Raport`: Link GET ke `/siswa/raport/preview/{id}`.
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Raport yang berstatus final.
- **Catatan Kejujuran:** Data riwayat raport diambil dari mock array.

### 66. Pratinjau Lembar Raport Digital Resmi (Paper View Siswa)
- **URL:** `/siswa/raport/preview` atau `/siswa/raport/preview/(:num)` (contoh: `/siswa/raport/preview/1`)
- **Controller & Method:** [`Siswa::raportPreview($id)`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L135-L151)
- **Header (H1) di View:** `RAPOR PESERTA DIDIK DAN PROFIL PESERTA DIDIK` ([`siswa/raport_preview.php:15`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/raport_preview.php#L15))
- **Subjudul:** `KOP RESMI: SMA IT FITHRAH INSANI &bull; SEMESTER GANJIL TA 2025/2026`
- **Widget/Stat Card:** Status Dokumen: Badge Hijau `Disahkan Digital oleh Kepala Sekolah`.
- **Tabel Data:** Seluruh Bagian Raport Paper View (Bagian A Biodata, Bagian B Sikap, Bagian C Pengetahuan & Keterampilan, Bagian D Ekskul, Bagian E Absensi, Bagian F Catatan Wali & Kenaikan).
- **Tombol & Aksi:** Tombol `Cetak Raport Lengkap` (`window.print()`), `Unduh Berkas PDF Resmi` (simulasi button).
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Data raport final.
- **Catatan Kejujuran:** Frasa tanda tangan digital pada view telah dibersihkan menjadi istilah formal *'Disahkan Digital oleh Kepala Sekolah'* dengan kode verifikasi sha256 simulasi.

### 67. Transkrip Nilai Kumulatif 6 Semester
- **URL:** `/siswa/transkrip`
- **Controller & Method:** [`Siswa::transkripLengkap()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L169-L173) (memanggil [`Siswa::transkrip()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Siswa.php#L154-L167))
- **Header (H1) di View:** `TRANSKRIP NILAI RESMI KELULUSAN (KUMULATIF)` ([`siswa/transkrip.php:18`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/siswa/transkrip.php#L18))
- **Subjudul:** `Akumulasi nilai raport 6 semester dan integrasi nilai Ujian Sekolah (US).`
- **Widget/Stat Card:** Formula Kelulusan Aktif: `Rapor 60% + Ujian Sekolah 40%`. Rata-rata Nilai Sekolah Akhir: `88.85`.
- **Tabel Data:** Matriks Kumulatif Seluruh Mapel dari Semester 1 s.d. Semester 6, Nilai Ujian Sekolah, dan Nilai Sekolah Akhir.
- **Tombol & Aksi:** Tombol `Cetak Transkrip Kelulusan` (`window.print()`).
- **Form/Modal:** Tidak ada form.
- **Ketergantungan Data:** Nilai semester 1-6 dan nilai ujian sekolah.
- **Catatan Kejujuran:** Transkrip kumulatif di-generate dari `MockData::getTranskripLengkapSiswa(1)`.

---

## KELOMPOK ROLE 5: AUTHENTIKASI & KONTROL AKSES (AUTH)

### 68. Halaman Masuk Akun SIAKAD (Login Portal)
- **URL:** `/`, `/auth`, atau `/auth/login`
- **Controller & Method:** [`Auth::login()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Auth.php#L14-L27) (GET) dan [`Auth::doLogin()`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Auth.php#L29-L65) (POST)
- **Header (H1) di View:** `SIAKAD SMA IT Fithrah Insani` ([`auth/login.php:38`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/auth/login.php#L38))
- **Subjudul:** `Sistem Informasi Akademik & Tata Kelola Terpadu Sekolah`
- **Widget/Stat Card:** Panel Akun Demo Cepat (1-Click Fill): Admin (`admin`), Guru (`guru.hendra`), TU (`tu.taufik`), Siswa (`siswa.raihan`).
- **Tabel Data:** Tidak ada tabel.
- **Tombol & Aksi:**
  - `Masuk ke Sistem`: Form POST ke `/auth/login`
  - Tombol pintas demo: Mengisi form secara instan via JavaScript
- **Form/Modal:** Form inputs: `username` (text), `password` (password), `role` (hidden/select). Validasi controller [`Auth.php:35-37`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Auth.php#L35-L37): Hanya memeriksa `if ($username === 'salah' || $password === 'salah')` untuk menghasilkan error; selain string tersebut, **semua kombinasi username/password dianggap valid dan berhasil masuk**!
- **Ketergantungan Data:** Data sekolah.
- **Catatan Kejujuran:** Tidak ada pencocokan hash password (`password_verify`), tidak ada query ke tabel `users` database. Role pengguna ditentukan secara otomatis berdasarkan prefix username (`admin*` -> admin, `guru*` -> guru, `tu*` -> tu, `siswa*` -> siswa) dan disimpan ke `session()`.

---

## BAGIAN 3: ALUR BISNIS DETAIL END-TO-END (BERDASARKAN KODE, BUKAN ASUMSI)

Bagian ini membedah alur nyata sistem dari hulu ke hilir berdasarkan bukti kode sumber aktual (*ground truth code execution*), membongkar perbedaan antara apa yang tampak di antarmuka (UI) dengan apa yang benar-benar dieksekusi di backend.

### 3.1. Transisi Tahun Ajaran & Setup Wizard 6 Langkah
#### Pertanyaan 1: Tabel apa saja yang benar-benar di-INSERT/UPDATE saat Wizard dijalankan?
- **Fakta Kode Sumber:** **TIDAK ADA SATUPUN TABEL DATABASE YANG DI-INSERT ATAU DI-UPDATE**.
- **Bukti Eksekusi:**
  - Form final pada Step 6 ([`app/Views/admin/tahun_ajaran/wizard_step_6.php:40-44`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Views/admin/tahun_ajaran/wizard_step_6.php#L40-L44)) mengirimkan request method POST ke endpoint `/admin/save-action`:
    ```html
    <form action="<?= base_url('admin/save-action') ?>" method="post">
      <input type="hidden" name="action" value="Aktivasi Tahun Ajaran 2026/2027">
      <input type="hidden" name="redirect_url" value="/admin/tahun-ajaran">
    ```
  - Pada [`app/Controllers/Admin.php:600-623`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L600-L623), method `saveAction()` diimplementasikan sebagai berikut:
    ```php
    public function saveAction()
    {
        $action = $this->request->getPost('action') ?? 'Data';
        $redirectUrl = $this->request->getPost('redirect_url') ?? '/admin';

        if ($action === 'Mutasi Siswa') {
            // hanya memproses mutasi siswa ke session...
        }

        return redirect()->to($redirectUrl)->with('success', $action . ' berhasil disimpan dan diperbarui.');
    }
    ```
  - Tidak ditemukan satupun query SQL seperti `INSERT INTO tahun_ajaran`, tidak ada pemanggilan model (misal `TahunAjaranModel::insert()`), dan tidak ada perubahan array pada `MockData.php`.

#### Pertanyaan 2: Apakah data siswa lama dipindahkan dengan aman atau ada risiko tertimpa (overwrite)? Apakah ada DB Transaction / Rollback?
- **Fakta Kode Sumber:**
  - **Tidak ada risiko overwrite pada level database fisik**, karena proses migrasi database memang **belum terjadi sama sekali** di backend.
  - **DB Transaction dan Rollback: TIDAK DIGUNAKAN** (`$this->db->transStart()`, `transComplete()`, atau `transRollback()` **TIDAK DITEMUKAN DI KODE**).
  - Data riwayat kelas siswa (`MockData::getSiswaRiwayatKelas()`) dan data siswa aktif (`MockData::getSiswaList()`) adalah dua array statis terpisah yang tidak terhubung secara relasional. Pada Step 4 Wizard, antarmuka hanya menampilkan tabel *read-only* dari `MockData::getKenaikanKelasList()` tanpa memicu mutasi atau pemindahan baris data apapun.

#### Pertanyaan 3: Apakah validasi 'pleno kenaikan kelas harus selesai' benar-benar mem-block di controller (server-side), atau cuma disabled di UI?
- **Fakta Kode Sumber:**
  - Pada rute GET wizard (`/admin/wizard/2` s.d. `/admin/wizard/6`), **terdapat proteksi server-side** pada [`app/Controllers/Admin.php:90-94`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L90-L94):
    ```php
    // Proteksi Server-Side: Blokir akses ke step berikutnya jika pleno belum 100% selesai
    if ($step > 1 && !$isSemuaPlenoSelesai) {
        return redirect()->to(base_url('admin/wizard/1'))
            ->with('error', 'Validasi Kunci Urutan Sistem: Tidak dapat melanjutkan wizard tahun ajaran baru sebelum seluruh rombel menyelesaikan Sidang Pleno Kenaikan Kelas.');
    }
    ```
  - **Namun Terdapat Celah Kritis Bypass:**
    1. Proteksi ini memeriksa method `MockData::isSemuaPlenoSelesai()` ([`app/Libraries/MockData.php:1391-1400`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Libraries/MockData.php#L1391-L1400)), yang membaca array statis `MockData::getStatusPlenoRombel()`. Karena di array tersebut kelas `XI-MIPA-1` dan `XI-IPS-1` di-hardcode belum selesai, maka nilai `$isSemuaPlenoSelesai` **selalu bernilai `false` secara permanen**.
    2. Meskipun akses GET ke wizard diblokir, pengguna dapat langsung mengirimkan HTTP POST ke `/admin/save-action` dengan payload `action=Aktivasi Tahun Ajaran 2026/2027`. Method `saveAction()` **tidak memiliki pengecekan `isSemuaPlenoSelesai()`**, sehingga aktivasi 'berhasil' (menampilkan flash success) meskipun wizard belum pernah diselesaikan!

### 3.2. Kenaikan Kelas & Sidang Pleno
#### Pertanyaan 1: Alur data dari 'Usulan Wali Kelas' sampai 'Disahkan Pleno' (tabel dan status apa yang berubah?)
- **Fakta Kode Sumber:**
  - **Tabel Basis Data:** Tidak ada tabel database yang berubah (`tableExists` migrasi tidak pernah di-UPDATE).
  - **Status yang Berubah di Session:** Perubahan status murni terjadi di dalam PHP session `pleno_kenaikan_data` melalui controller [`app/Controllers/Guru.php:749-766`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L749-L766):
    ```php
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
    ```
  - **Tahap 1 (Usulan Wali Kelas):** Ketika tombol `Simpan Usulan Wali Kelas` ditekan (`tindakan=simpan_usulan`), status usulan siswa (`status_usulan`) diubah menjadi `'naik'`, `'tinggal_kelas'`, atau `'lulus'`, namun `status_pleno` tetap bernilai `'belum_disahkan'`.
  - **Tahap 2 (Pengesahan Pleno):** Ketika tombol `Sahkan Sidang Pleno Resmi` ditekan (`tindakan=sahkan_pleno`), field `status_pleno` berubah dari `'belum_disahkan'` menjadi `'disahkan_pleno'`.

#### Pertanyaan 2: Apa yang terjadi secara teknis saat status berubah jadi 'Disahkan' (apakah otomatis membuka akses ke Wizard TA Baru?)
- **Fakta Kode Sumber:** **TIDAK OTOMATIS MEMBUKA AKSES KE WIZARD**.
- **Mekanisme Terputus (*Decoupled Disconnection*):**
  - Pada `Guru::savePlenoKenaikan()`, status pengesahan disimpan ke dalam `session('pleno_kenaikan_data')`.
  - Namun, pada `Admin::wizard()` ([`Admin.php:86-88`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Admin.php#L86-L88)), pengecekan kelengkapan pleno dilakukan melalui pemanggilan langsung method statis:
    ```php
    $plenoList = MockData::getStatusPlenoRombel();
    $isSemuaPlenoSelesai = MockData::isSemuaPlenoSelesai();
    ```
  - Method `MockData::isSemuaPlenoSelesai()` **sama sekali tidak membaca session `pleno_kenaikan_data`**! Method tersebut mengevaluasi array statis bawaan `MockData::getStatusPlenoRombel()` di mana rombel 4 dan 5 masih berstatus `'sedang_berlangsung'` dan `'belum_mulai'`.
  - Akibatnya, meskipun wali kelas dan kepala sekolah telah menekan tombol pengesahan pleno dan session terisi, Wizard Tahun Ajaran Baru di sisi Admin **tetap terblokir di Langkah 1**.

### 3.3. Modul Nilai & Raport Digital
#### Pertanyaan 1: Bagaimana Nilai Akhir dihitung persis (rumus, kolom, SQL vs PHP)?
- **Fakta Kode Sumber:** Seluruh rumus Nilai Akhir (NA) dihitung **murni di dalam logika aplikasi PHP**, bukan di dalam query SQL ataupun trigger database.
- **Rumus Nilai Akhir Pengetahuan (`Guru.php:118-131`):**
  ```php
  $uh    = (float)$row['pengetahuan']['uh'];    // Rata-rata Ulangan Harian (bobot 20%)
  $tugas = (float)$row['pengetahuan']['tugas']; // Rata-rata Tugas Harian (bobot 20%)
  $uts   = (float)$row['pengetahuan']['uts'];   // Ujian Tengah Semester (bobot 25%)
  $uas   = (float)$row['pengetahuan']['uas'];   // Ujian Akhir Semester (bobot 35%)

  $na = round(($uh * 0.20) + ($tugas * 0.20) + ($uts * 0.25) + ($uas * 0.35), 1);
  ```
- **Rumus Nilai Akhir Keterampilan (`Guru.php:948-950`):**
  ```php
  $p1 = (float)$vals['praktik'];    // Kinerja Praktik (bobot 40%)
  $p2 = (float)$vals['proyek'];     // Penilaian Proyek (bobot 30%)
  $p3 = (float)$vals['portofolio']; // Dokumen Portofolio (bobot 30%)

  $na = round(($p1 * 0.40) + ($p2 * 0.30) + ($p3 * 0.30), 1);
  ```
- **Penentuan Predikat (KKM 75.00):**
  - `NA >= 92.0` : **A** (Sangat Baik)
  - `83.0 <= NA < 92.0` : **B** (Baik)
  - `75.0 <= NA < 83.0` : **C** (Cukup / Tuntas KKM)
  - `NA < 75.0` : **D** (Kurang / Belum Tuntas KKM)

#### Pertanyaan 2: Bagaimana status raport berpindah (Draft → Menunggu Kepsek → Final)? Apakah ada middleware/validasi role?
- **Fakta Kode Sumber:**
  - Transisi status raport diatur dalam method [`app/Controllers/Guru.php:831-855`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L831-L855) (`finalisasiRaport($siswa_id)`):
    - `tahap === 'ajukan_kepsek'` -> `session()->set('raport_status_' . $siswa_id, 'menunggu_persetujuan_kepsek')`
    - `tahap === 'sahkan_kepsek'` -> `session()->set('raport_status_' . $siswa_id, 'final')`
    - `tahap === 'tolak_kepsek'`  -> `session()->set('raport_status_' . $siswa_id, 'draft')`
  - **Ketiadaan Validasi Role & Middleware:**
    - Rute `POST guru/raport/finalisasi/(:num)` **tidak dilindungi oleh middleware/filter apapun**.
    - Di dalam method `finalisasiRaport()`, **tidak ada pengecekan session role** (tidak ada `if (session()->get('role') !== 'kepsek')`).
    - Celah: Siapapun (termasuk user non-login, siswa, atau guru biasa) dapat mengirim POST ke endpoint ini dengan payload `tahap=sahkan_kepsek` untuk mengesahkan raport menjadi final secara sepihak.

#### Pertanyaan 3: Saat 'Buka Kunci Raport' disetujui admin, apa yang benar-benar terjadi ke nilai final? Apakah ada backup/log otomatis?
- **Fakta Kode Sumber:**
  - Ketika tombol `Setujui Buka Kunci` ditekan di `/admin/raport/buka-kunci`, request dikirim via POST ke `/admin/save-action`.
  - Method `Admin::saveAction()` **tidak mengeksekusi logika apapun terkait pembukaan kunci raport** (tidak ada backup snapshot nilai, tidak ada pencatatan log di sisi admin, dan status raport di mock/session tidak diubah). Admin hanya menerima flash message.
  - **Log Audit Perubahan Nilai:** Log perubahan baru tercatat secara otomatis di sisi **Guru** ([`app/Controllers/Guru.php:920-936`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Guru.php#L920-L936)) saat guru melakukan *submit ulang* nilai yang sudah pernah difinalisasi:
    ```php
    if ($oldNa > 0 && $oldNa != $na) {
        $auditLogs = session()->get('audit_log_nilai') ?? MockData::getLogPerubahanNilai();
        $auditLogs[] = [
            'id' => count($auditLogs) + 1,
            'siswa_id' => $sId,
            'nilai_sebelum' => $oldNa,
            'nilai_sesudah' => $na,
            'diubah_oleh' => 'Ustadz Hendra Gunawan, M.Pd.',
            'alasan' => 'Revisi nilai setelah pembukaan kunci oleh Kepala Sekolah',
            'disetujui_oleh' => 'Drs. H. Ahmad Fauzi, M.Pd. (Kepala Sekolah)',
            'waktu_perubahan' => date('Y-m-d H:i:s')
        ];
        session()->set('audit_log_nilai', $auditLogs);
    }
    ```
  - Log ini disimpan ke dalam **PHP session `audit_log_nilai`**, bukan ke dalam tabel database migrasi `audit_log_nilai`.

### 3.4. Modul Persuratan Dinas & Tata Usaha
#### Pertanyaan 1: Bagaimana nomor surat resmi dijamin tidak duplikat/bolong secara teknis? Bagaimana risiko race condition?
- **Fakta Kode Sumber:**
  - Penomoran surat resmi **TIDAK MENGGUNAKAN** `auto_increment` database dan **TIDAK MENGGUNAKAN** sequence tabel.
  - Nomor surat resmi di-hardcode string secara manual di dalam controller [`app/Controllers/Tu.php:188`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L188):
    ```php
    public function ajukanTtdSuratKeluar($id = 3)
    {
        $overrides = session()->get('surat_keluar_overrides') ?? [];
        $overrides[$id] = [
            'status' => 'menunggu_ttd',
            'nomor_surat' => '104/SMA-FI/TU/XII/2025',
            'tanggal_surat' => date('Y-m-d')
        ];
        session()->set('surat_keluar_overrides', $overrides);
        return redirect()->to(base_url('tu/surat-keluar'))->with('success', '...');
    }
    ```
  - **Risiko Race Condition:**
    - Karena nomor surat `'104/SMA-FI/TU/XII/2025'` bersifat statis dan disimpan di dalam session lokal masing-masing pengguna, tidak ada mekanisme locking (`SELECT ... FOR UPDATE`), transaksi terisolasi, ataupun unique constraint di database.
    - Jika dua staf TU membuat surat secara bersamaan, sistem akan menerbitkan nomor yang persis sama kepada kedua surat tersebut ketika diimplementasikan ke database multi-user.

#### Pertanyaan 2: Apakah pembatasan akses surat 'Rahasia' difilter di query controller (WHERE clause) atau cuma disembunyikan di view?
- **Fakta Kode Sumber:**
  - **Pada Halaman Detail:** Di method `suratMasukDetail()` ([`Tu.php:95-99`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L95-L99)) dan `suratKeluarDetail()` ([`Tu.php:166-170`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L166-L170)), terdapat pengecekan role:
    ```php
    $userRole = session()->get('role') ?? 'tu';
    if (($surat['sifat'] ?? '') === 'rahasia' && !in_array($userRole, ['admin', 'tu', 'kepsek'])) {
        return redirect()->to(base_url('tu/surat-masuk'))->with('error', 'Akses ditolak: Dokumen ini berstatus RAHASIA...');
    }
    ```
  - **Kelemahan Kritis Server-Side:** Variabel `$userRole` memiliki nilai bawaan fallback `'tu'` (`?? 'tu'`). Jika seorang penyerang atau pengguna guest yang sama sekali belum login mengakses URL `/tu/surat-masuk/detail/2` secara langsung, session `role` bernilai `null` sehingga controller menganggap perannya adalah `'tu'` dan **mengizinkan pembacaan dokumen rahasia**.
  - **Pada Halaman Index & Buku Agenda:** Pada method `suratMasuk()`, `suratKeluar()`, dan `bukuAgenda()` ([`Tu.php:230-261`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Tu.php#L230-L261)), **sama sekali tidak ada pemfilteran sifat surat**. Surat rahasia tetap dimasukkan ke dalam daftar tabel dan buku agenda.

### 3.5. Arsitektur Otentikasi & Kontrol Akses (Role & RBAC)
#### Pertanyaan: Bagaimana sistem RBAC bekerja secara teknis? Apakah dicek via Filter atau manual? Apakah ada celah akses langsung via URL?
- **Fakta Kode Sumber:**
  1. **Konfigurasi Filters CodeIgniter 4 (`app/Config/Filters.php`):**
     - Array `$aliases` ([`Filters.php:27-37`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Config/Filters.php#L27-L37)) hanya berisi filter standar bawaan framework (`csrf`, `toolbar`, `honeypot`, `invalidchars`, `secureheaders`, `cors`, `forcehttps`, `pagecache`, `performance`). Tidak ada alias filter otentikasi (misal `'auth'` atau `'role'`).
     - Array `$filters` ([`Filters.php:109`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Config/Filters.php#L109)) kosong melompong: `public array $filters = [];`.
  2. **Registrasi Rute (`app/Config/Routes.php`):**
     - Seluruh group rute (`$routes->group('admin', ...)`, `$routes->group('guru', ...)`, `$routes->group('tu', ...)`, `$routes->group('siswa', ...)`) didefinisikan tanpa opsi filter.
  3. **Pemeriksaan di Controller:**
     - File `BaseController.php` tidak melakukan verifikasi session.
     - Controller `Admin.php`, `Guru.php`, `Tu.php`, dan `Siswa.php` **tidak memiliki pengecekan login atau role** di method `__construct()` maupun action method.
  4. **Celah Keamanan Penuh (*Full Authorization Bypass*):**
     - Siapapun dapat mengakses dashboard dan seluruh fitur administratif dari peran apapun hanya dengan mengetikkan URL di peramban.
     - Contoh nyata: Seorang siswa yang belum login dapat langsung membuka `/admin/wizard/1`, mengubah nilai di `/guru/nilai/1/pengetahuan`, atau melihat surat dinas di `/tu/surat-masuk`.
     - Endpoint `/auth/switch/(:segment)` ([`app/Controllers/Auth.php:67-92`](file:///c:/xampp/htdocs/siakas-adminlte/siakas-adminlte%20-%20Copy/app/Controllers/Auth.php#L67-L92)) memungkinkan pergantian identitas dan peran ke role apapun secara instan tanpa memerlukan autentikasi ulang.

---

## BAGIAN 4: DAFTAR TEMUAN & KETIDAKSESUAIAN
Tabel audit komparatif berikut membandingkan secara jujur dan transparan antara apa yang didokumentasikan sebelumnya (pada `FITUR_ROLE_SIAKAD.md`), implementasi riil yang ditemukan pada kode sumber, serta kesenjangan (*gap*) teknis yang harus dituntaskan.

| Halaman / Fitur | Yang Didokumentasikan Sebelumnya (`FITUR_ROLE_SIAKAD.md`) | Yang Benar-Benar Ada di Kode Sumber | Kesenjangan & Rekomendasi Tindak Lanjut |
|:---|:---|:---|:---|
| **Arsitektur Basis Data & Model ORM** | Sistem beroperasi di atas database MySQL/MariaDB dengan relasi antar-tabel penuh (users, siswa, kelas, guru, nilai, surat, dll.). | Direktori `app/Models/` kosong (`.gitkeep`). Konfigurasi database `.env` nonaktif. Seluruh data berjalan di atas array in-memory `MockData.php` dan `session()`. | **Kritis:** Belum ada layer persistence relasional. Seluruh master data dan transaksi akan hilang jika session di-clear atau server direstart. Perlu pembuatan kelas model CodeIgniter dan migrasi database terpadu. |
| **Sistem Keamanan & RBAC (Role-Based Access Control)** | Sistem memiliki 4 level hak akses pengguna yang ketat dengan otorisasi berbasis peran (Admin, Guru, TU, Siswa) dan sesi login aman. | File `app/Config/Filters.php` dan direktori `app/Filters/` kosong dari filter auth. Controller tidak memeriksa session role. Rute bersifat publik dan dapat diakses bebas. | **Kritis:** Terdapat celah keamanan *Broken Access Control*. Siapapun dapat mengakses URL halaman role lain tanpa login. Perlu pembuatan `AuthFilter` dan `RoleFilter` di `app/Filters/` serta penugasan ke route group. |
| **Wizard Setup Tahun Ajaran Baru (`/admin/wizard/*`)** | Wizard 6 langkah mengeksekusi pemindahan siswa, penetapan wali kelas baru, pembukaan rombel baru, dan aktivasi kalender akademik ke database. | Langkah 1-5 mengirimkan form via GET tanpa menyimpan data. Langkah 6 mengirim POST ke `Admin::saveAction()` yang hanya melakukan redirect dengan flash message tanpa insert database. | **Tinggi:** Wizard saat ini berfungsi sebagai alur navigasi visual (*interactive prototype*). Logika pemindahan siswa ke rombel baru dan pencatatan tahun ajaran baru perlu diimplementasikan di model dan controller. |
| **Gatekeeper Validasi Sidang Pleno Kenaikan Kelas** | Tahun ajaran baru terkunci dan hanya dapat dibuka setelah seluruh rombel kelas menyelesaikan Sidang Pleno Kenaikan Kelas. | Controller `Admin::wizard()` memblokir akses GET Step > 1 via server-side, tetapi memeriksa array statis `MockData::isSemuaPlenoSelesai()` yang terputus dari session `pleno_kenaikan_data`. Selain itu, endpoint POST `admin/save-action` dapat ditembak langsung untuk membypass. | **Tinggi:** Hubungkan pengecekan kelengkapan pleno ke tabel database `kelas.status_pleno`. Tambahkan validasi kelengkapan pleno di dalam method POST `saveAction()`. |
| **Pengesahan Sidang Pleno Guru (`/guru/kenaikan-kelas`)** | Pengesahan pleno oleh Wali Kelas dan Kepala Sekolah secara resmi menetapkan kenaikan/kelulusan siswa dan membuka gerbang pembukaan TA baru. | Method `savePlenoKenaikan()` hanya menyimpan status usulan dan pleno ke dalam `session('pleno_kenaikan_data')`. Data tidak terhubung ke tabel `siswa_riwayat_kelas` maupun gatekeeper Admin. | **Tinggi:** Sinkronkan pengesahan pleno ke tabel `siswa_riwayat_kelas` (mengubah kolom `status_siswa` menjadi `naik`/`tinggal_kelas`/`lulus`) dan ubah `kelas.status_pleno` menjadi `selesai`. |
| **Rute Rekap Nilai Tugas (`/guru/tugas/(:num)/rekap`)** | Rute didokumentasikan dan terdaftar di `Routes.php` baris 87 untuk menampilkan rekapitulasi nilai tugas. | Method `rekapNilaiTugas` **TIDAK DITEMUKAN DI KODE** (`app/Controllers/Guru.php`). Mengakses URL ini menghasilkan fatal error `BadMethodCallException`. | **Sedang:** Rute broken. Rekap tugas sebenarnya telah disatukan di halaman `Guru::tugasHarian()`. Hapus rute mati ini dari `Routes.php` atau buat method alias di `Guru.php`. |
| **Sinkronisasi Nilai Tugas ke Buku Nilai Mapel** | Nilai tugas harian dan ulangan terintegrasi otomatis ke buku nilai aspek pengetahuan. | Telah diimplementasikan dan berfungsi dinamis melalui method `Guru::applyTugasAveragesToMatrix()` dan tombol sinkronisasi manual `/guru/nilai/{id}/sync-rata-rata`. | **Sesuai Rencana:** Logika kalkulasi berfungsi presisi, namun data masih tersimpan di dalam `session('tugas_scores_{id}')` dan `session('siswa_nilai_matrix_{id}')`. |
| **Tanda Tangan Digital Raport & Transkrip** | Dokumentasi lama sempat menyebutkan \"Tanda Tangan Elektronik (TTE) Tersertifikasi BSrE/BSSN\". | Kode tampilan di seluruh view (`tinjau.php`, `raport_preview.php`, `transkrip.php`, `transkrip_cetak.php`) telah dibersihkan dan menggunakan istilah formal valid: *\"Disahkan Digital oleh Kepala Sekolah\"*. | **Sesuai Standar:** Istilah telah realistis sesuai kapabilitas aplikasi internal sekolah (menggunakan kode hash verifikasi digital internal). |
| **Otorisasi Buka Kunci Raport Final (`/admin/raport/buka-kunci`)** | Admin menyetujui permohonan buka kunci revisi nilai raport dari guru dengan pencatatan jejak audit otomatis. | Form persetujuan admin mengirim POST ke `/admin/save-action` yang tidak mengeksekusi logika apapun. Audit log perubahan nilai justru baru dicatat di level Guru saat nilai di-submit ulang ke session. | **Tinggi:** Buat endpoint khusus `Admin::approveUnlockRaport(\$id)` yang mengubah status raport kembali ke `draft` dan mencatat peristiwa otorisasi ke tabel `audit_log_nilai`. |
| **Penomoran Surat Resmi Dinas Anti-Nomor Bolong (`/tu/surat-keluar`)** | Nomor resmi surat keluar dijamin urut, tidak duplikat, dan tidak terbuang saat draft dibatalkan menggunakan pola kode dinamis. | Alur status draft (`menunggu_ttd` dan `dibatalkan`) telah diimplementasikan di `Tu.php` via session, namun nomor resmi di-hardcode string (`'104/SMA-FI/TU/XII/2025'`). Format nomor dinamis dari `/admin/format-surat` belum terhubung. | **Sedang:** Integrasikan generator nomor surat dengan query sequence `MAX(nomor_urut) + 1` dari tabel `surat_keluar` berdasar tahun dan kategori surat saat status diajukan. |
| **Proteksi Dokumen Persuratan Rahasia** | Surat berstatus RAHASIA hanya dapat dibuka oleh Admin, Kepala Sekolah, dan Kepala Tata Usaha. | Filter controller di `Tu.php:95-99` menggunakan fallback `\$userRole = session()->get('role') ?? 'tu'`, sehingga request guest tanpa session login otomatis dianggap sebagai TU dan dapat membaca dokumen rahasia. Selain itu, daftar tabel index dan buku agenda tidak menyaring surat rahasia. | **Tinggi:** Ubah fallback otentikasi menjadi penolakan (`if (!session()->get('isLoggedIn')) return redirect()`) dan tambahkan filter WHERE pada query daftar surat masuk/keluar. |
| **Tabel Riwayat Kelas Siswa (`siswa_riwayat_kelas`)** | Riwayat penempatan kelas siswa per tahun ajaran dan semester terdokumentasi historis lengkap. | Migrasi `2026-09-21-000001_CreateSiswaRiwayatKelas.php` telah dibuat. Tampilan Tab 3 Detail Siswa dan Profil Siswa telah terhubung ke `MockData::getSiswaRiwayatKelas()`. Aksi mutasi siswa di `Admin.php:605-620` telah mencatat override ke session. | **Sesuai Rencana Sebagian:** UI dan controller telah siap, tinggal menghubungkan pembacaan dan penyimpanan ke query database relasional. |
| **Modul Ujian Sekolah & Formula Kelulusan** | Pengelolaan nilai US dan konfigurasi bobot kelulusan kelas 12 (Rapor 60% + US 40%). | Migrasi `2026-09-21-000003_CreateUjianSekolahDanFormulaKelulusan.php` telah tersedia. Halaman `/admin/ujian-sekolah` dan `/siswa/transkrip` telah berfungsi membaca konfigurasi dari `MockData`. | **Sesuai Rencana Sebagian:** Struktur tabel dan antarmuka telah selaras, tinggal mengalihkan sumber data dari array mock ke model database. |
| **Log Audit Perubahan Nilai (`audit_log_nilai`)** | Pencatatan riwayat revisi nilai raport pasca finalisasi untuk integritas data nilai sekolah. | Migrasi `2026-09-21-000004_CreateAuditLogPerubahanNilai.php` tersedia. Logika pencatatan perubahan nilai di `Guru::saveAction()` (baris 920-970) dan tampilan `/admin/log-audit` telah berfungsi via session `audit_log_nilai`. | **Sesuai Rencana Sebagian:** Alur pencatatan jejak audit (nilai sebelum, sesudah, pelaku, persetujuan kepsek, alasan) telah lengkap di kode aplikasi, siap dihubungkan ke tabel database fisik. |

---

### KESIMPULAN AUDITOR & RENCANA TAHAP BERIKUTNYA
1. **Status Kesiapan Antarmuka (UI/UX):** Sistem SIAKAD SMA IT Fithrah Insani telah memiliki struktur antarmuka (View) yang sangat matang, rapi, responsif, dan konsisten (menggunakan AdminLTE 4 / Bootstrap 5). Seluruh 68 halaman aktif telah terhubung dengan alur navigasi yang jelas.
2. **Status Logika Bisnis (Business Logic):** Logika kalkulasi nilai (rumus NA pengetahuan UH+Tugas+UTS+UAS, rumus keterampilan, KKM 75, predikat A/B/C/D, auto-generator CP, sinkronisasi kehadiran ke raport, dan status pleno) telah berhasil diuji dan berfungsi secara presisi di level memori PHP.
3. **Kebutuhan Esensial Menuju Produksi (*Production Readiness*):**
   - Mengaktifkan koneksi database MySQL pada `.env`.
   - Membuat kelas-kelas Model CodeIgniter 4 di `app/Models/` untuk seluruh entitas master dan transaksi.
   - Mengimplementasikan `AuthFilter` dan `RoleFilter` di `app/Filters/` untuk mengunci seluruh rute dari akses liar.
   - Mengalihkan penyimpanan data sementara dari `session()` ke query model database relasional yang dilengkapi transaksi database (`transBegin`, `transCommit`, `transRollback`).

*Laporan audit ini dibuat secara independen berdasarkan pemeriksaan baris kode sumber repositori pada tanggal 21 September 2026.*
