# Panduan Desain & Standar Antarmuka SIAKAS
**Sistem Informasi Akademik Sekolah (SIAKAS) — SMA IT Fithrah Insani**  
*Fondasi Teknis: CodeIgniter 4 &bull; AdminLTE 4 &bull; Bootstrap 5.3 &bull; Bootstrap Icons*

---

## 1. Filosofi Desain (Anti-Slop Principles)

SIAKAS dibangun untuk melayani ekosistem pendidikan nyata: guru, staf tata usaha, siswa, dan orang tua murid. Desain aplikasi menolak estetika *AI Slop*—yaitu antarmuka generik yang dipenuhi efek visual berlebihan, tombol mati tanpa aksi (*dead links*), data palsu seragam, atau ornamen tanpa fungsi.

### Prinsip Utama:
1. **Kejujuran Data (*Honest Data*)**: Jangan pernah menampilkan data palsu atau breakdown persentase identik seragam ketika data riil belum tersedia atau berbeda. Berikan keterangan jujur dan arahkan ke buku nilai atau guru pengampu.
2. **Setiap Elemen Interaktif Harus Berfungsi**: Setiap tombol (*button*), tautan (*link*), dan tab (*tab pane*) wajib terhubung ke aksi nyata, modal konfirmasi, atau dialog cetak/unduh. Tombol mati dilarang keras.
3. **Aksesibilitas Kontras (WCAG AA 4.5:1)**: Seluruh teks, lencana (*badge*), dan label input wajib memiliki rasio kontras minimum 4.5:1 terhadap latar belakangnya, baik dalam mode terang (*light mode*) maupun mode gelap (*dark mode*).
4. **Kosakata & Tipografi Natural**: Hindari tanda pisah em-dash (`—`) dalam salinan bahasa Indonesia; gunakan tanda hubung `-` atau titik dua `:`. Gunakan kata kerja spesifik pada CTA (*Call to Action*), bukan kata generik seperti "Kelola" atau "Klik di Sini".
5. **Dukungan Kondisi Kosong (*Empty States*)**: Seluruh tabel data wajib memiliki baris kondisi kosong (*empty state row*) yang informatif ketika koleksi data bernilai `[]`.

---

## 2. Setelan Dial Desain (*Design Dials*)

| Dial | Nilai (1–5) | Keterangan untuk SIAKAS |
| :--- | :---: | :--- |
| **Energy** | `2` | Tenang, fokus, formal institusi pendidikan islami. Menghindari warna neon atau animasi berlebihan. |
| **Density** | `4` | Informasi akademik padat dan efisien untuk tabel nilai, presensi, dan rekap surat. |
| **Warmth** | `2` | Bersih, seimbang antara keterbacaan teknis dan keramahan pengguna sekolah. |
| **Polish** | `4` | Terstruktur rapi, sudut konsisten (4px–8px), bayangan halus (*subtle shadow*). |
| **Rhythm** | `3` | Ritme konsisten antar kartu, jarak baris tabel yang proporsional (*table-hover align-middle*). |
| **Motion** | `1` | Minimalis; hanya transisi warna tombol dan tab Bootstrap bawaan, tanpa animasi mengambang. |

---

## 3. Palet Warna & Aksesibilitas Kontras

### Mode Terang (*Light Mode*)
- **Primary Navy**: `#1E3A5F` (Rasio kontras > 7:1 terhadap putih `#FFFFFF`).
- **Accent Emerald**: `#2CA58D` (Aksen islami modern untuk status sukses dan tuntas).
- **Surface / Latar Belakang**: `#F8FAFC` (Netral terang).
- **Lencana / Badge WCAG AA Tints**:
  - `Primary Tint`: Latar `#E2EEFE`, Teks `#0a58ca` (Rasio Kontras: **5.49:1** &bull; Lulus WCAG AA).
  - `Info Tint`: Latar `#d1ecf1`, Teks `#055160` (Rasio Kontras: **7.22:1** &bull; Lulus WCAG AA).
  - `Warning Tint`: Latar `#fff3cd`, Teks `#755200` (Rasio Kontras: **5.32:1** &bull; Lulus WCAG AA).
  - `Danger Tint`: Latar `#f8d7da`, Teks `#b02a37` (Rasio Kontras: **4.86:1** &bull; Lulus WCAG AA).
  - `Success Tint`: Latar `#d1e7dd`, Teks `#0f5132` (Rasio Kontras: **7.18:1** &bull; Lulus WCAG AA).

### Mode Gelap (*Dark Mode*)
- **Body Background**: `#0f172a` / `#1e293b`.
- **Card Background**: `#182233`.
- **Text Secondary / Muted**: `#adb5bd` (Rasio Kontras terhadap `#182233`: **7.69:1** &bull; Lulus WCAG AA).

---

## 4. Standar Tipografi

- **Font Tubuh Teks (*Body*)**: `'Montserrat', sans-serif` (Keterbacaan tinggi untuk formulir, teks panjang, dan tabel).
- **Font Judul (*Headings*)**: `'Poppins', sans-serif` (Elegan, ramah, dan terstruktur).
- **Font Monospace**: Dibatasi ketat **hanya** untuk nomor identitas resmi (`.badge-code`, `code`, `.font-monospace` untuk NIS, NIP, NISN, dan Nomor Agenda Surat). Dilarang menerapkan monospace ke seluruh lencana status.

---

## 5. Pedoman Komponen Antarmuka

### A. Tombol (*Buttons*)
- **Tanpa Ikon Panah Dekoratif**: Dilarang menambahkan ikon panah hiasan (`bi-arrow-right`, `bi-arrow-right-circle`) pada footer *small-box* atau tombol aksi.
- **Label Tombol Spesifik**: Gunakan verba tindakan jelas:
  - Buruk: `Kelola`, `Klik`, `Lihat`, `Buka`.
  - Baik: `Detail Rombel`, `Buka Berkas`, `Input Nilai`, `Cetak Presensi Kelas`.

### B. Indikator Fokus (*Focus Rings*)
- Seluruh elemen formulir dan tombol wajib menampilkan ring fokus yang jelas saat navigasi keyboard (`:focus-visible`).
- Dilarang keras menggunakan deklarasi `outline: none !important;` tanpa pengganti `box-shadow` fokus.

### C. Penyaringan Tabel Instan (*Instant Search & Filter*)
- Seluruh tabel yang memiliki input pencarian pada header kartu terhubung otomatis dengan skrip pencarian sisi klien tanpa *full-page reload*.
- Hook atribut: `.card-header input[placeholder*="Cari"]` atau `input[data-table-filter]`.

### D. Struktur Formulir & Payload
- Setiap masukan formulir (*input*, *select*, *textarea*) wajib menyertakan atribut `name` yang terstruktur dalam array (misal: `name="sikap[1][predikat]"`) agar data tersimpan lengkap ke basis data / *controller*.

---

## 6. Kebersihan Kode (*Code Hygiene*)

1. **Tanpa Komentar Banner AI**: Dilarang menggunakan pemisah komentar dekoratif berulang seperti `<!-- ================= ... ================= -->` atau `/* ================= */`. Gunakan komentar sederhana satu baris.
2. **Deduplikasi CSS**: Gaya khusus yang digunakan lintas halaman (seperti `.card-paper`, `.table-card`, `.badge-dot`) wajib didefinisikan secara terpusat di `app/Views/layouts/main.php`, bukan diduplikasi di setiap *view*.
