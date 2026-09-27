# DOKUMENTASI LENGKAP FITUR SETIAP ROLE - SISTEM INFORMASI AKADEMIK (SIAKAD)
**Satuan Pendidikan: SMA IT Fithrah Insani**  
**Framework & Basis Desain: CodeIgniter 4 & AdminLTE 4 / Bootstrap 5**

---

## DAFTAR ISI
1. [Ringkasan Peran dalam Sistem](#1-ringkasan-peran-dalam-sistem)
2. [Matriks Matriks Hak Akses Antar-Role](#2-matriks-hak-akses-antar-role)
3. [Fitur Detail Role 1: Administrator (Admin)](#3-fitur-detail-role-1-administrator-admin)
4. [Fitur Detail Role 2: Guru (Pendidik & Wali Kelas)](#4-fitur-detail-role-2-guru-pendidik--wali-kelas)
5. [Fitur Detail Role 3: Staff Tata Usaha (TU)](#5-fitur-detail-role-3-staff-tata-usaha-tu)
6. [Fitur Detail Role 4: Siswa (Portal Siswa & Alumni)](#6-fitur-detail-role-4-siswa-portal-siswa--alumni)
7. [Alur Integrasi & Workflow Antar-Role](#7-alur-integrasi--workflow-antar-role)
8. [Struktur Rute & Endpoint URL Lengkap](#8-struktur-rute--endpoint-url-lengkap)

---

## 1. RINGKASAN PERAN DALAM SISTEM

Sistem Informasi Akademik (SIAKAD) memiliki **4 Role Pengguna Utama** yang dirancang dengan kontrol hak akses berbasis peran (*Role-Based Access Control* / RBAC):

| No | Peran (Role) | Ruang Lingkup & Tanggung Jawab Utama | Prefix URL | Default Akun Demo |
|:---:|:---|:---|:---:|:---|
| 1 | **Administrator (Admin)** | Pengelolaan master data sekolah, tahun ajaran baru, kurikulum, KKM, rombel, penugasan guru, akun seluruh civitas, pembukaan kunci raport, serta arsip sentral. | `/admin` | `admin` |
| 2 | **Guru (Pendidik)** | Input nilai aspek pengetahuan & keterampilan, manajemen tugas harian/UH, analitik performa siswa, dan hak khusus **Wali Kelas** (penilaian sikap, ekskul, prestasi, kenaikan kelas, tinjau & finalisasi raport digital). | `/guru` | `guru.hendra` |
| 3 | **Tata Usaha (TU)** | Tata kelola administrasi persuratan resmi (pencatatan surat masuk, lembar disposisi digital pimpinan, pembuatan surat keluar otomatis dengan kode format, buku agenda terpadu, dan arsip dokumen). | `/tu` | `tu.taufik` |
| 4 | **Siswa / Alumni** | Pemantauan profil pribadi, transparansi capaian nilai pengetahuan & keterampilan secara real-time, status kenaikan kelas/kelulusan, riwayat raport per semester, dan cetak lembar raport digital (*paper view*). | `/siswa` | `siswa.raihan` |

---

## 2. MATRIKS HAK AKSES ANTAR-ROLE

| Fitur / Modul | Admin | Guru (Mapel) | Guru (Wali Kelas) | Staff TU | Siswa |
|:---|:---:|:---:|:---:|:---:|:---:|
| **Dashboard Khusus** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Kelola Profil & Master Sekolah** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Wizard Setup Tahun Ajaran 6 Langkah** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Master Kurikulum, Mapel, KKM, Bobot** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Kelola Rombel & Penugasan Guru** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Kelola Data Guru, Siswa, Ortu, Staf TU** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Input Nilai Pengetahuan & Keterampilan** | ❌ | ✅ | ✅ | ❌ | ❌ |
| **Kelola Tugas Harian & Ulangan Harian** | ❌ | ✅ | ✅ | ❌ | ❌ |
| **Analitik Nilai & Siswa Remedial** | ❌ | ✅ | ✅ | ❌ | ❌ |
| **Kelola Nilai Sikap, Ekskul, Prestasi** | Master Saja | ❌ | ✅ | ❌ | ❌ |
| **Keputusan Kenaikan Kelas / Kelulusan** | Rekap/Arsip | ❌ | ✅ | ❌ | Lihat Status |
| **Generate & Finalisasi Raport Digital** | ❌ | ❌ | ✅ | ❌ | ❌ |
| **Buka Kunci Raport Final (Revisi)** | ✅ (Otorisasi) | ❌ | ✅ (Pengajuan) | ❌ | ❌ |
| **Pencatatan Surat Masuk & Disposisi** | ❌ | ❌ | ❌ | ✅ | ❌ |
| **Pembuatan Surat Keluar & Nomor Otomatis** | ❌ | ❌ | ❌ | ✅ | ❌ |
| **Cetak Buku Agenda Surat Terpadu** | ❌ | ❌ | ❌ | ✅ | ❌ |
| **Pengaturan Format Nomor & Kategori Surat**| ✅ | ❌ | ❌ | ❌ | ❌ |
| **Modul Arsip Terpadu 7 Tab** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Lihat Rincian Nilai & Raport Digital Siswa** | ✅ | Nilai Mapel | Rombel Wali | ❌ | ✅ (Milik Sendiri) |

---

## 3. FITUR DETAIL ROLE 1: ADMINISTRATOR (ADMIN)

Role **Administrator** adalah pemegang otoritas manajerial tertinggi sistem. Administrator bertugas menyiapkan seluruh fondasi data sebelum proses akademik berjalan.

### 3.1. Dashboard Administrator (`/admin`)
- **Kartu Statistik Utama**:
  - Total Siswa Aktif (177 siswa).
  - Total Pendidik & Tenaga Kependidikan (24 guru).
  - Total Rombongan Belajar / Kelas Aktif (7 rombel).
  - Status Tahun Ajaran & Semester yang sedang aktif (`2025/2026 - Ganjil (Aktif)`).
- **Log Aktivitas Terkini (Real-time Timeline)**:
  - Memantau aktivitas guru yang baru menginput nilai.
  - Memantau surat masuk dinas yang dicatat oleh staf TU.
  - Memantau pencatatan nilai sikap oleh wali kelas.
  - Memantau perubahan penugasan dan aktivasi tahun ajaran baru.
- **Pintasan Cepat (Quick Actions)**:
  - Tombol pintas Buka Kelas Baru, Tambah Guru, Tambah Siswa, dan Jalankan Setup Wizard.

### 3.2. Data Sekolah (`/admin/sekolah`)
- **Identitas Satuan Pendidikan**:
  - Nomor Pokok Sekolah Nasional (NPSN) dan NSS.
  - Nama Resmi Sekolah (`SMA IT Fithrah Insani`).
  - Nama Kepala Sekolah beserta NIP resmi.
  - Jenjang Pendidikan & Status Akreditasi.
- **Alamat & Kontak Resmi**:
  - Jalan, RT/RW, Kelurahan/Desa, Kecamatan, Kabupaten/Kota, dan Provinsi.
  - Website sekolah, email resmi, nomor telepon, dan logo sekolah untuk kop surat serta kop raport.

### 3.3. Tahun Ajaran & Semester (`/admin/tahun-ajaran`)
- **Daftar Tahun Ajaran**:
  - Menampilkan riwayat tahun ajaran (status: *Aktif*, *Selesai*, *Draft*).
  - Pengelolaan semester (Semester Ganjil & Semester Genap) lengkap dengan tanggal mulai dan tanggal berakhir.
  - Fitur pengaktifan tahun ajaran/semester hanya dengan 1 klik.
- **Wizard Setup Tahun Ajaran Baru 6 Langkah (`/admin/wizard/1` s.d. `/admin/wizard/6`)**:
  - **Langkah 1 (Info TA & Semester)**: Menetapkan nama tahun ajaran baru serta rentang kalender akademik ganjil/genap.
  - **Langkah 2 (Salin / Buka Kelas Baru)**: Menyalin struktur rombel dari tahun sebelumnya atau membuat rombel baru per jurusan.
  - **Langkah 3 (Tetapkan Wali Kelas)**: Memilih guru aktif untuk ditugaskan sebagai wali kelas pada masing-masing rombel.
  - **Langkah 4 (Distribusi Siswa)**: Menempatkan siswa baru (kelas 10) atau siswa yang naik kelas ke rombel masing-masing.
  - **Langkah 5 (Penugasan Guru Mengajar)**: Memetakan guru pengampu untuk setiap mata pelajaran di setiap rombel.
  - **Langkah 6 (Review & Aktivasi)**: Menampilkan ringkasan konfigurasi sebelum sistem resmi diaktifkan.

### 3.4. Master Data Akademik
- **Tingkatan Kelas (`/admin/tingkatan`)**:
  - Kelola tingkatan (Kelas 10, Kelas 11, Kelas 12).
  - Pengaturan nomor urut jenjang dan pemantauan jumlah kelas di setiap jenjang.
  - Modal Tambah, Edit, dan Hapus tingkatan.
- **Jurusan / Program Peminatan (`/admin/jurusan`)**:
  - Kelola jurusan (MIPA, IPS, Bahasa dan Budaya).
  - Kode jurusan, nama lengkap, dan jumlah kelas yang aktif di jurusan tersebut.
- **Mata Pelajaran & Kelompok Mapel (`/admin/mapel`)**:
  - Pengelompokan Mapel sesuai standar nasional:
    - Kelompok A (Umum / Wajib).
    - Kelompok B (Umum / Wajib).
    - Kelompok C (Peminatan MIPA).
    - Kelompok C (Peminatan IPS).
    - Muatan Lokal (Bahasa Sunda, Bahasa Arab / Tahfidz).
  - Pengaturan nama mapel, kode mapel (PAI, MAT-W, BIO, FIS, dll.), jurusan terkait, serta nomor urut pencetakan pada raport.

### 3.5. Master Penilaian
- **Komponen Nilai & Bobot (`/admin/komponen-nilai`)**:
  - **Aspek Pengetahuan**: Ulangan Harian (UH 20%), Tugas & Kuis (20%), Ujian Tengah Semester (UTS 25%), Ujian Akhir Semester (UAS 35%). Total wajib = 100%.
  - **Aspek Keterampilan**: Praktik / Unjuk Kerja (40%), Proyek (30%), Portofolio (30%). Total wajib = 100%.
  - Dilengkapi validasi otomatis total bobot persentase.
- **KKM & Interval Predikat (`/admin/kriteria-penilaian`)**:
  - Konfigurasi nilai KKM (Kriteria Ketuntasan Minimal), misal: Standar Umum 75.00, Mulok 70.00.
  - Generator interval predikat nilai otomatis:
    - Predikat **A** (Sangat Baik): 91 – 100.
    - Predikat **B** (Baik): 83 – 90.
    - Predikat **C** (Cukup / Tuntas): 75 – 82.
    - Predikat **D** (Perlu Bimbingan / Remedial): 0 – 74.
- **Master Sikap, Ekstrakurikuler & Prestasi (`/admin/sikap`, `/admin/ekskul`, `/admin/prestasi`)**:
  - Master Jenis Sikap: Sikap Spiritual (Ketaatan beribadah, berdoa) dan Sikap Sosial (Kejujuran, disiplin, tanggung jawab, santun).
  - Master Ekstrakurikuler: Pramuka (Wajib), PMR, Paskibra, Klub Sains & Robotika, Futsal/Basket, Tahfidz.
  - Master Prestasi: Prestasi Akademik (OSN, LCC) dan Prestasi Non-Akademik (Seni, Olahraga, Tahfidz).

### 3.6. Kelas & Penugasan Mengajar
- **Kelola Kelas (`/admin/kelas`)**:
  - Daftar rombel aktif, tingkatan, jurusan, kapasitas siswa (max 32), jumlah siswa terisi, dan wali kelas terpilih.
- **Form Buka Kelas Baru (`/admin/kelas/buka`)**:
  - Pembuatan rombel baru dengan validasi penamaan rombel dan pemilihan wali kelas.
- **Detail Kelas & Siswa Rombel (`/admin/kelas/detail/{id}`)**:
  - Daftar siswa yang tergabung di rombel bersangkutan.
  - Menambahkan siswa baru dari daftar siswa yang belum memiliki kelas (*unassigned*).
  - Fitur mengeluarkan siswa atau memindahkan siswa ke rombel lain.
- **Penugasan Guru Mengajar (`/admin/penugasan`)**:
  - Matriks penugasan: Guru Pengampu + Mata Pelajaran + Kelas Rombel + Semester + Nilai KKM.
  - Filter pencarian cepat berdasarkan guru, mapel, atau kelas.
  - Modal tambah dan hapus penugasan mengajar.

### 3.7. Pengelolaan Pengguna (User Management)
- **Data Guru (`/admin/guru`, `/admin/guru/tambah`, `/admin/guru/edit/{id}`)**:
  - Database guru: NIP, Nama + Gelar, No. HP, Email, Alamat, Status Keaktifan, Status Wali Kelas, Mata Pelajaran Utama.
  - Pembuatan akun login otomatis (Username & Password).
- **Data Siswa (`/admin/siswa`, `/admin/siswa/tambah`, `/admin/siswa/edit/{id}`)**:
  - Data induk siswa: NIS, NISN, NIK, Nama Lengkap, Jenis Kelamin, Kelas Terdaftar, Status (Aktif, Lulus, Pindah, Keluar).
  - Fitur pencarian instan dan filter per rombel.
- **Detail Siswa Komprehensif (5 Tab)** (`/admin/siswa/detail/{id}/{tab}`):
  - **Tab 1 (Biodata)**: Informasi data pribadi siswa, tempat/tanggal lahir, agama, anak ke-, sekolah asal, dan foto profil.
  - **Tab 2 (Orang Tua / Wali)**: Identitas ayah, ibu, dan wali (Nama, pekerjaan, telepon, alamat).
  - **Tab 3 (Riwayat Akademik)**: Rekap perkembangan nilai semester dan riwayat kelas yang pernah ditempuh.
  - **Tab 4 (Raport Digital)**: Akses pratinjau lembar raport resmi siswa per semester.
  - **Tab 5 (Arsip & Dokumen)**: Repositori berkas pindaian siswa (Ijazah SMP, KK, Akta Kelahiran, SKL).
- **Data Orang Tua / Wali (`/admin/orang-tua`)**:
  - Rekap kontak seluruh orang tua siswa yang terhubung dengan nama anak, NIS, dan kelas untuk mempermudah komunikasi sekolah.
- **Akun & Data Staf TU (`/admin/staff-tu`)**:
  - Pengelolaan staf administrasi: NIP, Nama, Jabatan (Kepala TU, Staf Persuratan, Operator SIMS), nomor telepon, dan status akun login.

### 3.8. Manajemen Otoritas Raport
- **Buka Kunci Raport Final (`/admin/raport/buka-kunci`)**:
  - Menjamin integritas data nilai raport yang telah dikunci oleh wali kelas.
  - Memeriksa daftar raport yang berstatus terkunci (*Final*).
  - Memberikan izin buka kunci (unlock) jika ada permohonan revisi nilai resmi dari wali kelas/guru mapel disertai riwayat waktu finalisasi.

### 3.9. Konfigurasi Modul Persuratan
- **Kategori Surat (`/admin/kategori-surat`)**:
  - Pengaturan jenis surat (Undangan Resmi, Edaran Dinas, Rekomendasi/Izin, Surat Keterangan Siswa Aktif/Pindah, MoU).
  - Menentukan cakupan kategori (berlaku untuk surat masuk, surat keluar, atau keduanya).
- **Format Penomoran Surat (`/admin/format-surat`)**:
  - Penyesuaian pola nomor surat otomatis dengan kode token dinamis:
    - Format Surat Masuk: `SM-{tahun}-{nomor_urut_5}` (Contoh: `SM-2025-00145`).
    - Format Surat Keluar: `{nomor_urut}/SMA-FI/TU/{bulan_romawi}/{tahun}` (Contoh: `105/SMA-FI/TU/XII/2025`).
  - Aturan reset nomor urut (reset tahunan) dan pencatat nomor urut terakhir.

### 3.10. Modul Arsip Terpadu 7 Tab (`/admin/arsip/{tab}`)
- **Tab 1 (Alumni)**: Data siswa yang telah lulus, tahun kelulusan, kelas terakhir, dan nomor ijazah.
- **Tab 2 (Kenaikan Kelas)**: Rekam jejak riwayat kenaikan kelas seluruh siswa dari tahun ajaran lampau.
- **Tab 3 (Raport Digital)**: Repositori berkas raport digital berformat PDF yang telah difinalisasi.
- **Tab 4 (Mutasi Siswa)**: Rekam jejak siswa pindah keluar maupun siswa pindahan masuk beserta berkas rekomendasinya.
- **Tab 5 (Dokumen Sekolah & Siswa)**: Arsip dokumen legalitas (Akreditasi, Ijazah, SKL, berkas kependudukan).
- **Tab 6 (Penugasan Guru)**: Rekam jejak sejarah pengajaran guru di semester-semester terdahulu.
- **Tab 7 (Surat Masuk & Keluar)**: Arsip seluruh surat dinas yang telah selesai diproses.

---

## 4. FITUR DETAIL ROLE 2: GURU (PENDIDIK & WALI KELAS)

Role **Guru** memiliki fleksibilitas tinggi dengan sistem *Dual-Role*: berperan sebagai **Guru Pengampu Mata Pelajaran** dan dapat merangkap sebagai **Wali Kelas**.

### 4.1. Dashboard Guru (Dual View Mode) (`/guru/dashboard/wali` & `/guru/dashboard/mapel`)
- **Mode Switcher**: Beralih antara tampilan **Dashboard Wali Kelas** dan **Dashboard Guru Mapel** dalam satu tombol.
- **Statistik Mengajar**:
  - Jumlah mata pelajaran yang diampu.
  - Jumlah kelas rombel yang diajar.
  - Total siswa binaan.
  - Progres persentase pengisian raport kelas perwalian (contoh: 85% - 26 dari 31 siswa selesai).
- **Widget Pengingat & Notifikasi Tenggat (Alert Center)**:
  - Peringatan ulangan harian yang belum selesai dinilai.
  - Peringatan tugas siswa yang belum dinilai.
  - Peringatan kelengkapan nilai sikap/ekskul yang belum diinput.
  - Peringatan batas akhir finalisasi raport semester.
- **Daftar Mata Pelajaran Aktif**: Kartu pintas menuju kelas yang diajar.

### 4.2. Mata Pelajaran Saya (`/guru/mapel`)
- Menampilkan seluruh mata pelajaran dan rombel yang ditugaskan kepada guru pada semester aktif.
- Informasi KKM masing-masing mapel, jam pelajaran, dan jumlah siswa terdaftar.
- Tombol aksi cepat: Input Nilai, Kelola Tugas Harian, dan Analitik Nilai.

### 4.3. Input Nilai Siswa (`/guru/nilai/{pengajaran_id}/{aspek}`)
- **Input Aspek Pengetahuan**:
  - Form nilai Ulangan Harian (bobot 20%), Tugas & Kuis (bobot 20%), UTS (bobot 25%), dan UAS (bobot 35%).
- **Input Aspek Keterampilan**:
  - Form nilai Praktik / Unjuk Kerja (bobot 40%), Proyek (bobot 30%), dan Portofolio (bobot 30%).
- **Fitur Otomatisasi Input**:
  - **Real-time Live Calculation**: Nilai Akhir (NA) terhitung secara otomatis saat nilai komponen diketikkan.
  - **Predikat Otomatis**: Konversi nilai ke predikat A, B, C, atau D secara instan sesuai standar KKM mapel.
  - **Highlight KKM**: Nilai di bawah KKM otomatis ditandai dengan warna merah untuk memudahkan identifikasi remedial.
  - Tombol Simpan Draf dan Simpan Final.

### 4.4. Tugas Harian & Ulangan Harian (`/guru/tugas/{pengajaran_id}`)
- Manajemen evaluasi harian per Kompetensi Dasar (KD).
- Pembuatan tugas baru: Judul tugas, tanggal pelaksanaan, dan pemilihan komponen nilai (UH vs Tugas).
- Pelacak status penilaian siswa (contoh: 30/31 siswa dinilai).

### 4.5. Presensi Harian & Jurnal Mengajar (KBM) (`/guru/presensi/{pengajaran_id}`)
- **Pengelolaan Sesi Pertemuan Tatap Muka**:
  - Daftar pertemuan KBM (Pertemuan 1 s.d. 16) dilengkapi tanggal, alokasi jam pelajaran, materi pokok, dan metode pembelajaran.
  - Pembuatan sesi pertemuan baru secara dinamis dengan nomor urut otomatis.
- **Form Input Kehadiran & Jurnal Pembelajaran**:
  - Tombol cepat **"Set Semua Hadir (1-Klik)"** untuk efisiensi waktu mengajar.
  - Status kehadiran peserta didik lengkap: **Hadir (H)**, **Sakit (S)**, **Izin (I)**, **Alpa (A)**, dan **Dispensasi (D - Lomba/Dinas)**.
  - Kolom catatan personal siswa (alasan izin, surat dokter, dll.).
  - Formulir jurnal refleksi guru: pokok materi yang diajarkan, metode yang diterapkan, dan hambatan/tindak lanjut kelas.
- **Matriks Rekapitulasi Presensi Semesteran**:
  - Tabulasi kehadiran per siswa dari Pertemuan 1 s.d. Pertemuan N.
  - Akumulasi Hadir, Sakit, Izin, Alpa, Dispensasi, dan Persentase Kehadiran (%).
  - **Deteksi Kehadiran Kritis (< 85%)**: Sistem otomatis menandai siswa yang berisiko tidak memenuhi syarat kelayakan mengikuti Ujian Akhir Semester (UAS).
- **Cetak Resmi Format Dinas (`/guru/presensi/{pengajaran_id}/cetak`)**:
  - Format siap cetak (*Print-Ready*) landscape A4 ber-Kop resmi SMA IT Fithrah Insani.
  - Rekapitulasi kehadiran siswa, jurnal agenda mengajar, dan lembar pengesahan tanda tangan Guru Pengampu & Kepala Sekolah.

### 4.6. Analitik Nilai Komprehensif (`/guru/analitik/{pengajaran_id}/{variant}`)
- **Metrik Analitik Kelas**:
  - Nilai Rata-rata Kelas.
  - Nilai Tertinggi dan Terendah di kelas.
  - Jumlah siswa tuntas KKM vs jumlah siswa yang perlu bimbingan/remedial.
- **Tabel Siswa di Bawah KKM (Daftar Remedial)**:
  - NIS, Nama Siswa, Nilai Akhir, Standar KKM, serta Kolom Rekomendasi Tindak Lanjut / Materi Remedial.
- **Grafik Distribusi Nilai**: Visualisasi sebaran siswa dengan predikat A, B, C, dan D.

---

### 4.7. Fitur Khusus Wali Kelas (Eksklusif Rombel Perwalian)

Bila guru ditugaskan sebagai wali kelas (contoh: Wali Kelas XI-MIPA-1), menu tambahan berikut akan aktif secara otomatis:

#### A. Penilaian Sikap, Ekstrakurikuler & Prestasi (`/guru/perwalian/{tab}`)
- **Tab 1 (Nilai Sikap)**:
  - Penilaian Sikap Spiritual (ketaatan ibadah, berdoa) dan Sikap Sosial (disiplin, kejujuran, sopan santun).
  - Pilihan predikat: *Sangat Baik*, *Baik*, *Cukup*, *Kurang*.
  - Generator Narasi Deskripsi Otomatis sesuai predikat, dengan kebebasan bagi wali kelas untuk mengedit narasi secara manual (*custom narrative*).
- **Tab 2 (Ekstrakurikuler)**:
  - Memasukkan kegiatan ekskul yang diikuti siswa perwalian (Pramuka, PMR, Robotika, dll.).
  - Input nilai predikat (A/B/C) dan catatan capaian kegiatan.
- **Tab 3 (Prestasi Siswa)**:
  - Mencatat pencapaian kejuaraan yang diraih siswa selama semester (akademik maupun non-akademik, tingkat kota/provinsi/nasional).

#### B. Matriks Nilai Kelas (Buku Kumpulan Nilai / Leger) (`/guru/matriks-nilai` & `/guru/leger`)
- Rekapitulasi nilai akhir seluruh mata pelajaran (Kelompok A, B, C, dan Mulok) dalam satu lembar matriks besar kelas.
- Fitur interaktif: Beralih tampilan nilai Angka vs Predikat Huruf (A/B/C/D), serta pengurutan berdasarkan Peringkat Ranking vs Nomor Absen Siswa.
- Menampilkan metrik KPI: Rata-rata Kelas, Siswa Peringkat 1 Umum, Persentase Ketuntasan Seluruh Mapel, dan Rentang Nilai Rata-rata.
- Terintegrasi otomatis dengan nilai Matematika Wajib & absensi perwalian.
- Format cetak landscape A4 resmi (*Print-Ready*) untuk arsip fisik wali kelas dan rujukan rapat pleno sekolah.

#### C. Keputusan Kenaikan Kelas / Kelulusan (`/guru/kenaikan-kelas`)
- Khusus semester genap: Menetapkan keputusan kenaikan kelas bagi setiap siswa (Naik ke kelas berikutnya atau Tinggal Kelas).
- Khusus kelas 12: Menetapkan status kelulusan peserta didik.
- Menampilkan rekapitulasi nilai rata-rata seluruh mapel sebagai acuan rapat dewan guru.
- Kolom catatan keputusan wali kelas.

#### D. Generate Raport Digital (`/guru/raport/generate`)
- Fitur kompilasi otomatis (*Batch Generator*): Mengumpulkan seluruh nilai mapel dari seluruh guru pengampu, nilai sikap, ekskul, prestasi, absensi, dan catatan wali kelas menjadi satu draf raport digital.
- Indikator kesiapan kelengkapan data sebelum raport digenerate.

#### E. Tinjau Raport Digital (Paper View Raport Standar Nasional) (`/guru/raport/tinjau/{siswa_id}`)
- Pratinjau digital lembar raport tampilan kertas (Sesuai format baku buku raport nasional):
  - **Bagian A**: Identitas Peserta Didik & Penilaian Sikap (Spiritual & Sosial lengkap dengan deskripsi capaian).
  - **Bagian B**: Nilai Pengetahuan & Keterampilan (Tabel lengkap Kelompok A Wajib, Kelompok B Wajib, Kelompok C Peminatan, dan Muatan Lokal; menampilkan KKM, Nilai Angka, Predikat, dan Deskripsi Capaian Kompetensi).
  - **Bagian C**: Ekstrakurikuler.
  - **Bagian D**: Prestasi yang diraih.
  - **Bagian E**: Rekapitulasi Ketidakhadiran (Sakit, Izin, Tanpa Keterangan).
  - **Bagian F**: Catatan Wali Kelas, Tanggapan Orang Tua, dan Lembar Tanda Tangan (Wali Kelas, Orang Tua, Kepala Sekolah).
- Fitur edit langsung narasi catatan wali kelas pada halaman tinjau.
- **Finalisasi Raport**: Mengunci raport agar siap diakses siswa dan orang tua.
- Tombol Cetak PDF Raport langsung dari browser.
- Navigasi cepat berpindah ke siswa berikutnya (*Next/Previous Student*).

#### F. Buka Kunci Raport Final untuk Revisi (`/guru/raport/buka-kunci/{siswa_id}`)
- Mekanisme pengajuan buka kunci (unlock) kepada Administrator apabila ada revisi nilai mendesak setelah raport difinalisasi.

---

## 5. FITUR DETAIL ROLE 3: STAFF TATA USAHA (TU)

Role **Staff Tata Usaha (TU)** mengelola operasional administrasi persuratan resmi dan kearsipan dokumen sekolah.

### 5.1. Dashboard Tata Usaha (`/tu`)
- **Statistik Persuratan Bulan Ini**:
  - Total surat masuk yang diterima.
  - Surat masuk yang sedang menunggu disposisi pimpinan.
  - Surat keluar yang sedang menunggu tanda tangan Kepala Sekolah.
  - Surat keluar yang telah resmi dikirimkan.
- **Pelacak Tenggat Disposisi (Due Date Tracker)**:
  - Peringatan visual untuk disposisi yang mendekati batas waktu (*Mendekati Batas Waktu*) atau sudah kedaluwarsa (*Lewat Batas Waktu*).
- **Tabel Ringkasan Surat Masuk & Surat Keluar Terkini**.

### 5.2. Modul Surat Masuk
- **Daftar Surat Masuk (`/tu/surat-masuk`)**:
  - Menampilkan seluruh surat dinas masuk.
  - Kolom: Nomor Agenda, Nomor Surat Pengirim, Tanggal Diterima, Asal Pengirim, Kategori, Perihal, Sifat Surat (Biasa, Penting, Rahasia), dan Status (Didisposisikan, Selesai, Diarsipkan).
  - Filter pencarian berdasarkan kategori, asal instansi, dan rentang tanggal.
- **Form Catat Surat Masuk Baru (`/tu/surat-masuk/tambah`)**:
  - **Nomor Agenda Otomatis**: Digenerate langsung oleh sistem (misal: `SM-2025-00145`).
  - Input metadata: Nomor Surat Asli, Tanggal Surat, Tanggal Diterima, Asal Instansi Pengirim, Kategori Surat, Ringkasan Perihal, dan Sifat Surat.
  - Unggah berkas pindaian surat (PDF / Gambar lampiran).
- **Detail Surat Masuk & Lembar Disposisi Digital (`/tu/surat-masuk/detail/{id}`)**:
  - Pratinjau detail surat dan tautan unduh berkas lampiran asli.
  - **Lembar Disposisi Digital**:
    - Input penunjukan tujuan disposisi (Kepala Sekolah, Wakasek, Guru tertentu, Operator SIMS).
    - Input instruksi tindak lanjut pimpinan.
    - Menetapkan batas waktu pengerjaan (deadline) dan catatan hasil disposisi.
    - Pembaruan status disposisi (*Belum Ditindak*, *Sedang Diproses*, *Selesai*).
  - **Cetak Lembar Disposisi**: Format cetak standar dinas untuk disematkan pada map fisik surat.

### 5.3. Modul Surat Keluar
- **Daftar Surat Keluar (`/tu/surat-keluar`)**:
  - Monitoring surat keluar resmi sekolah.
  - Kolom: Nomor Surat Keluar, Tanggal Surat, Kategori, Instansi/Pihak Tujuan, Perihal, Pejabat Penandatangan, dan Status (Draft, Menunggu TTD, Terkirim, Diarsipkan).
- **Form Buat Surat Keluar Baru (`/tu/surat-keluar/tambah`)**:
  - **Generator Nomor Surat Otomatis**: Terbit secara real-time mengikuti format baku penomoran sekolah (contoh: `105/SMA-FI/TU/XII/2025`).
  - Input Tanggal Surat, Kategori Surat, Pihak/Instansi Tujuan, Perihal Surat, Sifat Surat, dan Pejabat yang menandatangani.
  - Unggah draf dokumen surat final.
- **Detail Surat Keluar & Pelacakan Status (`/tu/surat-keluar/detail/{id}`)**:
  - Pelacakan status verifikasi dan tanda tangan Kepala Sekolah.
  - Pencatatan tanggal dan bukti pengiriman surat kepada penerima.
  - Opsi pengarsipan surat keluar.

### 5.4. Arsip Surat Masuk & Keluar (`/tu/arsip`)
- Repositori pencarian arsip dokumen persuratan sekolah dengan tabulasi Surat Masuk dan Surat Keluar.
- Filter pencarian komprehensif berdasarkan tahun, kategori, perihal, atau nomor surat.
- Pengunduhan ulang pindaian berkas arsip sewaktu-waktu dibutuhkan.

### 5.5. Buku Agenda Surat Terpadu (`/tu/agenda`)
- Buku register agenda resmi yang menggabungkan rekapitulasi surat masuk dan surat keluar dalam satu periode semester/tahun ajaran.
- Nomor urut agenda teratur sesuai kronologi tanggal.
- Format tampilan *Print-Ready* (siap cetak fisik) untuk kebutuhan supervisi pengawas dinas pendidikan dan akreditasi sekolah.

---

## 6. FITUR DETAIL ROLE 4: SISWA (PORTAL SISWA & ALUMNI)

Role **Siswa** dirancang sebagai portal transparansi informasi akademik yang ramah pengguna (*user-friendly*), responsif di perangkat ponsel (*mobile-friendly*), dan mendukung kebutuhan siswa aktif maupun alumni.

### 6.1. Beranda Siswa (`/siswa`)
- **Kartu Identitas Siswa**:
  - Menampilkan Foto Resmi Siswa, Nama Lengkap, NIS, NISN, Rombel/Kelas saat ini, serta Nama Wali Kelas.
- **Ringkasan Performa Akademik Terkini**:
  - Daftar nilai mata pelajaran unggulan beserta predikat capaian (A/B/C).
- **Widget Status Raport Digital**:
  - Informasi status ketersediaan raport semester aktif (apakah masih draf dalam proses penyusunan atau sudah resmi diterbitkan).
- **Pintasan Menu**: Akses cepat menuju halaman rincian nilai, profil, dan raport.

### 6.2. Profil Saya (`/siswa/profil`)
- **Identitas Lengkap Peserta Didik**:
  - NIS, NISN, NIK, Tempat & Tanggal Lahir, Jenis Kelamin, Agama.
  - Alamat domisili tempat tinggal dan kontak siswa.
  - Asal sekolah (SMP/MTs) dan tanggal resmi diterima di SMA IT Fithrah Insani.
- **Data Orang Tua / Wali**:
  - Nama Ayah, Ibu, dan Wali.
  - Pekerjaan, nomor telepon, dan alamat orang tua.

### 6.3. Transkrip Nilai Akademik (`/siswa/nilai/{aspek}`)
- **Tab Nilai Pengetahuan**:
  - Rincian nilai seluruh mata pelajaran (Kelompok A, B, C, dan Mulok).
  - Menampilkan Angka Nilai Akhir, Standar KKM Mapel, Predikat Huruf (A, B, C, D), dan Deskripsi Capaian Pembelajaran.
- **Tab Nilai Keterampilan**:
  - Rincian nilai capaian praktik, proyek, dan portofolio seluruh mata pelajaran.
  - Menampilkan Nilai Angka, Predikat, dan Deskripsi Kemahiran Keterampilan.
- **Visualisasi Status Ketuntasan**:
  - Badge hijau untuk nilai yang melampaui KKM dan badge peringatan jika di bawah KKM.

### 6.4. Status Akademik (Kenaikan Kelas & Kelulusan) (`/siswa/status/{variant}`)
- **Mode Siswa Kelas 10 & 11 (Kenaikan Kelas)**:
  - Pengumuman resmi keputusan kenaikan kelas (contoh: *"Selamat, Anda dinyatakan NAIK ke Kelas XII-MIPA-1"*).
  - Catatan motivasi dan pesan pribadi dari wali kelas.
- **Mode Siswa Kelas 12 / Alumni (Status Kelulusan)**:
  - Pengumuman resmi kelulusan sekolah: Status **LULUS**.
  - Nomor Ijazah Nasional resmi.
  - Rekap Nilai Rata-rata Ujian Sekolah & Nilai Akhir Kelulusan.
  - Keterangan resmi tamat belajar dari satuan pendidikan.

### 6.5. Riwayat Raport Digital per Semester (`/siswa/raport`)
- Portofolio seluruh raport yang pernah ditempuh selama masa studi di sekolah:
  - Kelas 10 Semester Ganjil & Genap.
  - Kelas 11 Semester Ganjil & Genap.
  - Kelas 12 Semester Ganjil & Genap.
- Status status raport: *Sedang Diproses Wali Kelas* vs *Raport Final Siap Dilihat*.

### 6.6. Pratinjau Lembar Raport Digital (Paper View) (`/siswa/raport/preview/{id}`)
- Tampilan lembar buku raport digital format kertas resmi:
  - Bagian A: Sikap Spiritual & Sosial.
  - Bagian B: Tabel Lengkap Nilai Pengetahuan & Keterampilan (Kelompok A, B, C, Mulok).
  - Bagian C: Kegiatan Ekstrakurikuler.
  - Bagian D: Rekam Jejak Prestasi Siswa.
  - Bagian E: Rekap Ketidakhadiran (Sakit, Izin, Alpa).
  - Bagian F: Catatan Wali Kelas, Tanggapan Orang Tua, dan Kolom Tanda Tangan Digital.
- **Fitur Cetak Mandiri**: Siswa dan orang tua dapat langsung mencetak lembar raport atau menyimpannya ke format PDF resmi.

---

## 7. ALUR INTEGRASI & WORKFLOW ANTAR-ROLE

```
  +-----------------------------------------------------------------------------------+
  |                              FASE 1: SETUP AWAL TAHUN                             |
  +-----------------------------------------------------------------------------------+
  | [ADMINISTRATOR]                                                                   |
  |  1. Menjalankan Setup Wizard 6 Langkah                                            |
  |  2. Membuka Rombel Baru & Menetapkan Wali Kelas                                   |
  |  3. Menugaskan Guru Mengajar (Mata Pelajaran, Kelas, KKM)                         |
  |  4. Mendistribusikan Siswa ke Rombel                                              |
  +-----------------------------------------+-----------------------------------------+
                                            |
                                            v
  +-----------------------------------------------------------------------------------+
  |                        FASE 2: PEMBELAJARAN & PERSURATAN                          |
  +-----------------------------------------------------------------------------------+
  | [GURU MAPEL]                            | [STAFF TATA USAHA]                      |
  |  * Mengelola Tugas Harian & Ulangan     |  * Mencatat Surat Masuk & Notif Disposisi|
  |  * Input Nilai Pengetahuan & Keterampilan| * Menerbitkan Surat Keluar (Auto No)    |
  |  * Memantau Siswa Remedial (Analitik)   |  * Cetak Buku Agenda & Arsip Dokumen    |
  +-----------------------------------------+-----------------------------------------+
                                            |
                                            v
  +-----------------------------------------------------------------------------------+
  |                        FASE 3: PENILAIAN AKHIR & PERWALIAN                        |
  +-----------------------------------------------------------------------------------+
  | [GURU WALI KELAS]                                                                 |
  |  1. Menilai Sikap Spiritual & Sosial (Auto Deskripsi + Custom)                    |
  |  2. Input Nilai Ekstrakurikuler & Prestasi Siswa                                  |
  |  3. Memutuskan Kenaikan Kelas / Kelulusan (Semester Genap)                        |
  |  4. Menjalankan "Batch Generate Raport Digital"                                   |
  |  5. Meninjau Lembar Raport (Paper View Bagian A-F)                                |
  |  6. Finalisasi & Penguncian Raport                                                |
  +-----------------------------------------+-----------------------------------------+
                                            |
                                            v
  +-----------------------------------------------------------------------------------+
  |                          FASE 4: PUBLIKASI & REVISI                               |
  +-----------------------------------------------------------------------------------+
  | [SISWA / ORANG TUA]                     | [REVISI NILAI (JIKA ADA)]               |
  |  * Melihat Nilai & Transkrip Real-time  |  * Wali Kelas mengajukan buka kunci     |
  |  * Melihat Status Kenaikan / Lulus      |  * Admin menyetujui Buka Kunci Raport   |
  |  * Meninjau & Cetak Lembar Raport PDF   |  * Guru Mapel memperbaiki nilai         |
  +-----------------------------------------+-----------------------------------------+
```

---

## 8. STRUKTUR RUTE & ENDPOINT URL LENGKAP

Berikut adalah direktori rute (*routes*) CodeIgniter 4 yang aktif dalam sistem:

### Rute Autentikasi (`/auth`)
- `GET  /` & `GET  /auth/login` : Halaman form masuk (login multi-role).
- `POST /auth/login` : Pemrosesan kredensial dan alokasi sesi role.
- `GET  /auth/switch/(:segment)` : Pengalih mode peran instan untuk keperluan pengujian demo prototype.
- `GET  /auth/logout` : Mengakhiri sesi pengguna.

### Rute Administrator (`/admin`)
- `GET  /admin` & `/admin/dashboard` : Halaman dashboard utama admin.
- `GET  /admin/sekolah` : Manajemen data profil sekolah.
- `GET  /admin/tahun-ajaran` : Daftar tahun ajaran dan semester aktif.
- `GET  /admin/wizard/(:num)` : Wizard setup tahun ajaran 6 langkah (Langkah 1 s.d. 6).
- `GET  /admin/tingkatan` : Master tingkatan kelas (10, 11, 12).
- `GET  /admin/jurusan` : Master jurusan / peminatan.
- `GET  /admin/mapel` & `/admin/mapel/(:num)` : Master mata pelajaran dan kelompok mapel.
- `GET  /admin/komponen-nilai/(:segment)` : Komponen nilai dan persentase bobot.
- `GET  /admin/kriteria-penilaian` : KKM dan interval predikat huruf.
- `GET  /admin/sikap` : Master instrumen penilaian sikap.
- `GET  /admin/ekskul` : Master jenis ekstrakurikuler.
- `GET  /admin/prestasi` : Master jenis prestasi siswa.
- `GET  /admin/kelas` : Pengelolaan rombongan belajar / kelas.
- `GET  /admin/kelas/buka` : Form buka kelas baru.
- `GET  /admin/kelas/detail/(:num)` : Detail anggota rombel dan kelola plotting siswa.
- `GET  /admin/penugasan` : Matriks penugasan guru mengajar.
- `GET  /admin/guru` : Daftar direktori pendidik.
- `GET  /admin/guru/tambah` & `/admin/guru/edit/(:num)` : Formulir tambah dan perbarui guru.
- `GET  /admin/siswa` : Daftar induk siswa.
- `GET  /admin/siswa/tambah` & `/admin/siswa/edit/(:num)` : Formulir data siswa baru.
- `GET  /admin/siswa/detail/(:num)/(:segment)` : Profil komprehensif siswa (Biodata, Ortu, Akademik, Raport, Arsip).
- `GET  /admin/orang-tua` : Data rekapitulasi kontak orang tua/wali murid.
- `GET  /admin/staff-tu` : Manajemen akun staf tata usaha.
- `GET  /admin/raport/buka-kunci` : Otorisasi pembukaan kunci raport yang telah difinalisasi.
- `GET  /admin/kategori-surat` : Konfigurasi kategori surat masuk dan keluar.
- `GET  /admin/format-surat` : Konfigurasi template penomoran surat otomatis.
- `GET  /admin/arsip/(:segment)` : Modul arsip sentral 7 tab.
- `POST /admin/save-action` : Endpoint penyimpanan aksi umum simulasi sistem.

### Rute Guru (`/guru`)
- `GET  /guru` & `/guru/dashboard/(:segment)` : Dashboard guru (mode wali kelas vs mode guru mapel).
- `GET  /guru/mapel` : Daftar mata pelajaran yang diampu.
- `GET  /guru/nilai/(:num)/(:segment)` : Form input nilai siswa (pengetahuan dan keterampilan).
- `GET  /guru/tugas/(:num)` : Manajemen evaluasi tugas harian dan ulangan harian.
- `GET  /guru/presensi` & `/guru/presensi/(:num)` : Daftar pertemuan tatap muka dan rekapitulasi kehadiran kelas.
- `GET  /guru/presensi/(:num)/input/(:num)` : Form pencatatan kehadiran siswa dan jurnal KBM pertemuan.
- `POST /guru/presensi/(:num)/save/(:num)` : Simpan hasil presensi & jurnal KBM.
- `POST /guru/presensi/(:num)/tambah-pertemuan` : Tambah sesi pertemuan KBM baru.
- `GET  /guru/presensi/(:num)/cetak` : Format cetak resmi dokumen buku presensi & jurnal KBM.
- `GET  /guru/analitik/(:num)/(:segment)` : Analitik capaian nilai dan pelacak siswa remedial.
- `GET  /guru/perwalian/(:segment)` : Penilaian sikap, ekskul, dan prestasi kelas perwalian.
- `GET  /guru/matriks-nilai` & `/guru/leger` : Matriks nilai kelas (buku kumpulan nilai / leger) dan peringkat ranking siswa.
- `GET  /guru/kenaikan-kelas` : Sidang penentuan kenaikan kelas / kelulusan rombel.
- `GET  /guru/raport/generate` : Kompilasi otomatis data raport digital satu rombel.
- `GET  /guru/raport/tinjau/(:num)` : Tinjauan lembar raport cetak Bagian A s.d. F dan finalisasi.
- `GET  /guru/raport/buka-kunci/(:num)` : Pengajuan pembukaan kunci raport revisi kepada Admin.
- `POST /guru/save-action` : Endpoint penyimpanan aksi nilai dan perwalian.

### Rute Tata Usaha (`/tu`)
- `GET  /tu` & `/tu/dashboard` : Dashboard tata usaha dan pemantauan tenggat disposisi.
- `GET  /tu/surat-masuk` : Daftar surat dinas masuk.
- `GET  /tu/surat-masuk/tambah` : Pencatatan surat masuk baru dengan nomor agenda otomatis.
- `GET  /tu/surat-masuk/detail/(:num)` : Detail surat masuk dan pengisian lembar disposisi digital.
- `GET  /tu/surat-keluar` : Daftar surat keluar resmi sekolah.
- `GET  /tu/surat-keluar/tambah` : Pembuatan surat keluar baru dengan nomor urut otomatis.
- `GET  /tu/surat-keluar/detail/(:num)` : Pelacakan status tanda tangan dan pengiriman surat.
- `GET  /tu/arsip/(:segment)` : Arsip surat masuk dan keluar.
- `GET  /tu/agenda` : Cetak buku register agenda persuratan terpadu.
- `POST /tu/save-action` : Endpoint pemrosesan persuratan.

### Rute Siswa (`/siswa`)
- `GET  /siswa` & `/siswa/beranda` : Beranda portal siswa dan ringkasan nilai terkini.
- `GET  /siswa/profil` : Halaman profil identitas diri dan orang tua.
- `GET  /siswa/nilai/(:segment)` : Transkrip nilai capaian pembelajaran (pengetahuan dan keterampilan).
- `GET  /siswa/status/(:segment)` : Status akademik (pengumuman kenaikan kelas / kelulusan dan nomor ijazah).
- `GET  /siswa/raport` : Riwayat seluruh raport per semester.
- `GET  /siswa/raport/preview/(:num)` : Pratinjau lembar raport digital (*paper view*) dan cetak PDF mandiri.

---
*Dokumen ini disusun berdasarkan arsitektur modul sistem informasi akademik SMA IT Fithrah Insani (SIAKAD).*
