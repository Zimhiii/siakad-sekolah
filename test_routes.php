<?php

$routes = [
    '/',
    '/auth/login',
    '/auth/login?error=1',
    '/auth/switch/admin',
    '/admin',
    '/admin/sekolah',
    '/admin/tahun-ajaran',
    '/admin/wizard/1',
    '/admin/wizard/2',
    '/admin/wizard/3',
    '/admin/wizard/4',
    '/admin/wizard/5',
    '/admin/wizard/6',
    '/admin/aktivasi-semester-genap',
    '/admin/tingkatan',
    '/admin/jurusan',
    '/admin/mapel',
    '/admin/komponen-nilai',
    '/admin/kriteria-penilaian',
    '/admin/sikap',
    '/admin/ekskul',
    '/admin/prestasi',
    '/admin/kelas',
    '/admin/kelas/buka',
    '/admin/kelas/detail/4',
    '/admin/penugasan',
    '/admin/guru',
    '/admin/guru/tambah',
    '/admin/guru/edit/1',
    '/admin/siswa',
    '/admin/siswa/tambah',
    '/admin/siswa/detail/1',
    '/admin/siswa/detail/1/biodata',
    '/admin/siswa/detail/1/ortu',
    '/admin/siswa/detail/1/riwayat',
    '/admin/siswa/detail/1/nilai',
    '/admin/siswa/detail/1/dokumen',
    '/admin/orang-tua',
    '/admin/staff-tu',
    '/admin/raport/buka-kunci',
    '/admin/kategori-surat',
    '/admin/format-surat',
    '/admin/arsip/alumni',
    '/admin/arsip/kenaikan',
    '/admin/arsip/raport',
    '/admin/arsip/mutasi',
    '/admin/arsip/dokumen',
    '/admin/arsip/penugasan',
    '/admin/arsip/surat',
    '/auth/switch/guru',
    '/guru',
    '/guru/dashboard/wali',
    '/guru/dashboard/mapel',
    '/guru/mapel',
    '/guru/nilai/1/pengetahuan',
    '/guru/nilai/1/keterampilan',
    '/guru/nilai/1/sync-rata-rata',
    '/guru/tugas/1',
    '/guru/tugas/1/nilai/1',
    '/guru/tugas/1/nilai/3',
    '/guru/analitik/1/mapel',
    '/guru/analitik/1/wali',
    '/guru/perwalian/sikap',
    '/guru/perwalian/ekskul',
    '/guru/perwalian/prestasi',
    '/guru/perwalian/absensi',
    '/guru/leger',
    '/guru/kenaikan-kelas',
    '/guru/raport/generate',
    '/guru/raport/tinjau/1',
    '/guru/raport/buka-kunci/1',
    '/auth/switch/tu',
    '/tu',
    '/tu/surat-masuk',
    '/tu/surat-masuk/tambah',
    '/tu/surat-masuk/detail/1',
    '/tu/surat-keluar',
    '/tu/surat-keluar/tambah',
    '/tu/surat-keluar/detail/1',
    '/tu/arsip/masuk',
    '/tu/arsip/keluar',
    '/tu/agenda',
    '/auth/switch/siswa',
    '/siswa',
    '/siswa/profil',
    '/siswa/nilai/pengetahuan',
    '/siswa/nilai/keterampilan',
    '/admin/ujian-sekolah',
    '/admin/siswa/transkrip/1',
    '/siswa/status/biasa',
    '/siswa/status/akhir',
    '/siswa/raport',
    '/siswa/raport/preview/1',
    '/siswa/transkrip'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/writable/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/writable/cookies.txt');

$errors = 0;
$success = 0;

foreach ($routes as $route) {
    $url = "http://localhost:8080" . $route;
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode >= 200 && $httpCode < 400) {
        echo "[OK $httpCode] $route\n";
        $success++;
    } else {
        echo "[FAIL $httpCode] $route\n";
        $errors++;
    }
}

curl_close($ch);
echo "\nTotal Checked: " . count($routes) . " | Success: $success | Errors: $errors\n";
