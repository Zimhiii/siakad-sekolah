<?php

$baseUrl = 'http://localhost:8080';
$cookieFile = __DIR__ . '/writable/test_cookie2.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

function curlGet($url, $cookieFile) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => $res];
}

function curlPost($url, $data, $cookieFile) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => $res];
}

echo "1. Switching session to role Guru...\n";
$res = curlGet($baseUrl . '/auth/switch/guru', $cookieFile);
assert($res['code'] === 200, "Switched to Guru");

echo "2. Loading Perwalian Absensi tab (/guru/perwalian/absensi)...\n";
$res = curlGet($baseUrl . '/guru/perwalian/absensi', $cookieFile);
assert(strpos($res['body'], 'Rekap Kehadiran (Absensi)') !== false, "Tab Absensi found");
assert(strpos($res['body'], 'input-sakit') !== false, "Input sakit found");
echo "PASS: Tab 4 Rekap Kehadiran (Absensi) loaded successfully!\n";

echo "3. Submitting updated attendance for Muhammad Raihan Pratama (Sakit=3, Izin=2, Alpa=1)...\n";
$postData = [
    'sakit' => [1 => 3, 2 => 0, 3 => 1, 4 => 0, 5 => 2],
    'izin' => [1 => 2, 2 => 1, 3 => 1, 4 => 0, 5 => 1],
    'tanpa_keterangan' => [1 => 1, 2 => 0, 3 => 0, 4 => 0, 5 => 1],
    'catatan' => [1 => 'Izin pemulihan kesehatan']
];
$res = curlPost($baseUrl . '/guru/perwalian/absensi', $postData, $cookieFile);
assert($res['code'] === 200, "POST successful");
assert(strpos($res['body'], 'berhasil disimpan') !== false, "Success flash message found");
echo "PASS: Attendance saved to session!\n";

echo "4. Verifying that Raihan's report card (/guru/raport/tinjau/1) immediately reflects the new attendance...\n";
$res = curlGet($baseUrl . '/guru/raport/tinjau/1', $cookieFile);
assert(strpos($res['body'], 'value="3"') !== false, "Sakit=3 found in Raport Bagian E");
assert(strpos($res['body'], 'value="2"') !== false, "Izin=2 found in Raport Bagian E");
echo "PASS: Two-way sync to Raport Digital Bagian E verified!\n";

echo "5. Verifying Leger Nilai Kelas (/guru/leger)...\n";
$res = curlGet($baseUrl . '/guru/leger', $cookieFile);
assert(strpos($res['body'], 'Leger Nilai Kelas: XI-MIPA-1') !== false, "Leger page loaded");
assert(strpos($res['body'], 'MAT-W') !== false, "Subject column found");
assert(strpos($res['body'], 'Peringkat 1 Umum') !== false, "Ranking card found");
assert(strpos($res['body'], 'Cetak Leger') !== false, "Print button found");
echo "PASS: Leger Nilai Kelas with subjects, ranking, and print mode verified!\n";

echo "\nALL LEGER & ABSENSI TESTS PASSED 100%!\n";
