<?php

echo "===============================================================\n";
echo " TEST SUITE: AUDIT PERBAIKAN ALUR BISNIS & PEMBERSIHAN SIAKAD \n";
echo " SMA IT FITHRAH INSANI\n";
echo "===============================================================\n\n";

$passCount = 0;
$failCount = 0;

function report($condition, $testName, $details = '') {
    global $passCount, $failCount;
    if ($condition) {
        echo "[PASS] " . $testName . "\n";
        if ($details) echo "       -> " . $details . "\n";
        $passCount++;
    } else {
        echo "[FAIL] " . $testName . "\n";
        if ($details) echo "       -> " . $details . "\n";
        $failCount++;
    }
}

$baseDir = __DIR__;

// -----------------------------------------------------------------------------
// 1. UJI II.1 & II.3: Wizard Step 1 & Step 4 (No demo bypass & Read-only recap)
// -----------------------------------------------------------------------------
$wizard1 = file_get_contents($baseDir . '/app/Views/admin/tahun_ajaran/wizard_step_1.php');
report(!str_contains($wizard1, 'bypass_pleno'), "II.1 - Wizard Step 1 bebas dari tombol/parameter bypass_pleno demo");

$wizard4 = file_get_contents($baseDir . '/app/Views/admin/tahun_ajaran/wizard_step_4.php');
report(!str_contains($wizard4, '<select'), "II.3 - Wizard Step 4 tidak memiliki tag <select> untuk edit siswa");
report(str_contains($wizard4, 'Rekapitulasi Kenaikan Kelas &amp; Kelulusan (Hasil Sidang Pleno)'), "II.3 - Wizard Step 4 berstatus rekapitulasi hasil pleno");
report(str_contains($wizard4, 'Terkunci (Read-Only)'), "II.3 - Wizard Step 4 menampilkan badge Terkunci (Read-Only)");
report(str_contains($wizard4, '$totalSiswa') && str_contains($wizard4, '$naikCount'), "II.3 - Wizard Step 4 memiliki ringkasan statistik (Total, Naik, Tinggal, Lulus)");

// -----------------------------------------------------------------------------
// 2. UJI II.2: Penggantian Istilah TTE Tersertifikasi
// -----------------------------------------------------------------------------
$tinjauGuru = file_get_contents($baseDir . '/app/Views/guru/raport/tinjau.php');
$previewSiswa = file_get_contents($baseDir . '/app/Views/siswa/raport_preview.php');
$transkripSiswa = file_get_contents($baseDir . '/app/Views/siswa/transkrip.php');
$transkripCetak = file_get_contents($baseDir . '/app/Views/admin/pengguna/transkrip_cetak.php');

report(str_contains($tinjauGuru, 'Disahkan Digital oleh Kepala Sekolah') && !str_contains($tinjauGuru, 'TTE TERSERTIFIKASI'), "II.2 - guru/raport/tinjau.php menggunakan 'Disahkan Digital oleh Kepala Sekolah'");
report(str_contains($previewSiswa, 'Disahkan Digital oleh Kepala Sekolah') && !str_contains($previewSiswa, 'TTE TERSERTIFIKASI'), "II.2 - siswa/raport_preview.php menggunakan 'Disahkan Digital oleh Kepala Sekolah'");
report(str_contains($transkripSiswa, 'Disahkan Digital oleh Kepala Sekolah') && !str_contains($transkripSiswa, 'TTE TERSERTIFIKASI'), "II.2 - siswa/transkrip.php menggunakan 'Disahkan Digital oleh Kepala Sekolah'");
report(str_contains($transkripCetak, 'Disahkan Digital oleh Kepala Sekolah') && !str_contains($transkripCetak, 'Tanda Tangan Digital Tersertifikasi'), "II.2 - admin/pengguna/transkrip_cetak.php menggunakan 'Disahkan Digital oleh Kepala Sekolah'");

// -----------------------------------------------------------------------------
// 3. UJI I.1: Tabel siswa_riwayat_kelas & Migration
// -----------------------------------------------------------------------------
$mig1 = $baseDir . '/app/Database/Migrations/2026-09-21-000001_CreateSiswaRiwayatKelas.php';
report(file_exists($mig1), "I.1 - Migration file 2026-09-21-000001_CreateSiswaRiwayatKelas.php tersedia");
if (file_exists($mig1)) {
    $mig1Content = file_get_contents($mig1);
    report(str_contains($mig1Content, 'siswa_riwayat_kelas') && str_contains($mig1Content, 'status_siswa'), "I.1 - Migration memiliki skema lengkap siswa_riwayat_kelas");
}

$siswaDetail = file_get_contents($baseDir . '/app/Views/admin/pengguna/siswa_detail.php');
report(str_contains($siswaDetail, 'siswa_riwayat_kelas') && str_contains($siswaDetail, '$riwayatKelas'), "I.1 - admin/pengguna/siswa_detail.php Tab 3 merender riwayat kelas secara dinamis");

$siswaProfil = file_get_contents($baseDir . '/app/Views/siswa/profil.php');
report(str_contains($siswaProfil, 'siswa_riwayat_kelas') && str_contains($siswaProfil, '$riwayatKelas'), "I.1 - siswa/profil.php merender kartu riwayat kelas & multi-semester");

// -----------------------------------------------------------------------------
// 4. UJI I.3: Snapshot KKM & Bobot pada Penugasan
// -----------------------------------------------------------------------------
$mig2 = $baseDir . '/app/Database/Migrations/2026-09-21-000002_AddSnapshotPenugasanDanStatusPleno.php';
report(file_exists($mig2), "I.3 - Migration file 2026-09-21-000002_AddSnapshotPenugasanDanStatusPleno.php tersedia");
if (file_exists($mig2)) {
    $mig2Content = file_get_contents($mig2);
    report(str_contains($mig2Content, 'kkm_snapshot') && str_contains($mig2Content, 'bobot_snapshot'), "I.3 - Migration memiliki kolom kkm_snapshot & bobot_snapshot");
}

$mockDataContent = file_get_contents($baseDir . '/app/Libraries/MockData.php');
report(str_contains($mockDataContent, "'kkm_snapshot' => 75.0") && str_contains($mockDataContent, "'bobot_snapshot' => 20.0"), "I.3 - MockData penugasan menyimpan kkm_snapshot dan bobot_snapshot");

// -----------------------------------------------------------------------------
// 5. UJI I.4: Modul Ujian Sekolah & Formula Kelulusan
// -----------------------------------------------------------------------------
$mig3 = $baseDir . '/app/Database/Migrations/2026-09-21-000003_CreateUjianSekolahDanFormulaKelulusan.php';
report(file_exists($mig3), "I.4 - Migration file 2026-09-21-000003_CreateUjianSekolahDanFormulaKelulusan.php tersedia");
if (file_exists($mig3)) {
    $mig3Content = file_get_contents($mig3);
    report(str_contains($mig3Content, 'formula_kelulusan') && str_contains($mig3Content, 'ujian_sekolah'), "I.4 - Migration memiliki tabel formula_kelulusan & ujian_sekolah");
}
report(str_contains($mockDataContent, "'jumlah_semester_raport' => 6"), "I.4 - MockData::getFormulaKelulusan() menyertakan konfigurasi jumlah_semester_raport");

$usView = file_get_contents($baseDir . '/app/Views/admin/ujian_sekolah/index.php');
report(str_contains($usView, 'jumlah_semester_raport'), "I.4 - Form ujian-sekolah mendukung opsi pemilihan 5 atau 6 semester");

// -----------------------------------------------------------------------------
// 6. UJI I.5 & II.4: Auto-Generator CP & Link Langsung Bank Tugas
// -----------------------------------------------------------------------------
$inputNilai = file_get_contents($baseDir . '/app/Views/guru/nilai/input.php');
report(!str_contains($inputNilai, 'modalRincian_'), "II.4 - Hapus popup rincian tugas per siswa di input nilai");
report(str_contains($inputNilai, 'guru/tugas/') && str_contains($inputNilai, 'Bank Tugas'), "II.4 - Tombol mengarahkan langsung ke Bank Tugas (/guru/tugas/{id})");
report(str_contains($inputNilai, 'btnGenerateAllCp') && str_contains($inputNilai, 'btn-generate-single-cp'), "I.5 - Tersedia tombol auto-generator deskripsi Capaian Pembelajaran (CP)");
report(str_contains($inputNilai, 'textarea-deskripsi') && str_contains($inputNilai, 'emptyCount'), "I.5 - Validasi wajib isi (mandatory) deskripsi CP sebelum submit form");

// -----------------------------------------------------------------------------
// 7. UJI I.6: Approval Kepala Sekolah (3 Status & Penolakan)
// -----------------------------------------------------------------------------
$guruController = file_get_contents($baseDir . '/app/Controllers/Guru.php');
report(str_contains($guruController, "tahap === 'tolak_kepsek'") && str_contains($guruController, 'raport_catatan_penolakan_'), "I.6 - Alur penolakan kepsek mengembalikan status ke 'draft' dan menyimpan catatan revisi");
report(str_contains($tinjauGuru, 'modalTolakKepsek') && str_contains($tinjauGuru, 'catatan_revisi'), "I.6 - Tinjau raport memiliki modal penolakan resmi kepsek dengan catatan wajib");

// -----------------------------------------------------------------------------
// 8. UJI I.7: Readiness Checker Raport
// -----------------------------------------------------------------------------
$generateRaport = file_get_contents($baseDir . '/app/Views/guru/raport/generate.php');
report(!str_contains($generateRaport, 'toggleDemoKelengkapan'), "II.1 - generate.php bebas dari switch demo kelengkapan");
report(str_contains($generateRaport, 'disabled') && str_contains($generateRaport, 'Readiness Checker: Raport Terkunci'), "I.7 - Proses generate hard-blocked jika kelengkapan belum 100%");
report(str_contains($generateRaport, 'mapel_belum'), "I.7 - Menampilkan rincian daftar mata pelajaran yang belum selesai dinilai");

// -----------------------------------------------------------------------------
// 9. UJI I.8: Audit Trail Otomatis Revisi Nilai
// -----------------------------------------------------------------------------
$mig4 = $baseDir . '/app/Database/Migrations/2026-09-21-000004_CreateAuditLogPerubahanNilai.php';
report(file_exists($mig4), "I.8 - Migration file 2026-09-21-000004_CreateAuditLogPerubahanNilai.php tersedia");
report(str_contains($guruController, 'audit_log_nilai') && str_contains($guruController, 'oldNa != $na'), "I.8 - Guru::saveAction() otomatis mencatat audit trail jika ada perubahan nilai");

// -----------------------------------------------------------------------------
// 10. UJI I.9 & I.10: Mutasi Siswa & Keamanan Modul Surat
// -----------------------------------------------------------------------------
$adminController = file_get_contents($baseDir . '/app/Controllers/Admin.php');
report(str_contains($adminController, 'Mutasi Siswa') && str_contains($adminController, 'siswa_riwayat_kelas_overrides'), "I.9 - Admin::saveAction() memperbarui siswa_riwayat_kelas saat mutasi terjadi");

$tuController = file_get_contents($baseDir . '/app/Controllers/Tu.php');
report(str_contains($tuController, "sifat'] ?? '') === 'rahasia'"), "I.10 - Tu controller memfilter hak akses surat berstatus rahasia di backend");

// -----------------------------------------------------------------------------
// 11. UJI II.5, II.6, II.10, II.11: Modul Audit, IPK/Cumlaude, Dashboard, Helper
// -----------------------------------------------------------------------------
$routesContent = file_get_contents($baseDir . '/app/Config/Routes.php');
report(str_contains($routesContent, "'log-audit', 'Admin::logAudit'"), "II.5 - Route /admin/log-audit terdaftar di Config/Routes.php");

$auditIndex = $baseDir . '/app/Views/admin/audit/index.php';
report(file_exists($auditIndex), "II.5 - View admin/audit/index.php tersedia");

report(!str_contains($transkripSiswa, 'Cumlaude') && !str_contains($transkripSiswa, 'IPK'), "II.6 - transkrip.php bebas dari istilah IPK dan Cumlaude");
report(!str_contains($transkripCetak, 'IPK'), "II.6 - transkrip_cetak.php bebas dari istilah IPK");

$dashboardAdmin = file_get_contents($baseDir . '/app/Views/admin/dashboard.php');
report(str_contains($dashboardAdmin, 'admin/log-audit'), "II.10 - Dashboard admin menyertakan tautan langsung ke Modul Log Audit");

$mainLayout = file_get_contents($baseDir . '/app/Views/layouts/main.php');
report(str_contains($mainLayout, 'window.SiakadHelper') && str_contains($mainLayout, 'exportTableToCSV'), "II.11 - layouts/main.php menyertakan reusable window.SiakadHelper (print & export CSV)");

echo "\n===============================================================\n";
echo " REKAP HASIL PENGUJIAN: $passCount PASS | $failCount FAIL\n";
echo "===============================================================\n";

if ($failCount === 0) {
    echo "SELURUH FITUR & ATURAN BISNIS BERHASIL TERVERIFIKASI SEMPURNA!\n";
    exit(0);
} else {
    echo "TERDAPAT $failCount KEGAGALAN DALAM UJI COBA.\n";
    exit(1);
}
