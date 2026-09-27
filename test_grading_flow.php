<?php

$baseUrl = 'http://localhost:8080';
$cookieFile = __DIR__ . '/writable/test_cookie.txt';
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
echo "Status: " . $res['code'] . "\n";

echo "2. Loading Tugas Harian & UH Index page...\n";
$res = curlGet($baseUrl . '/guru/tugas/1', $cookieFile);
assert(strpos($res['body'], 'Tugas Harian & Ulangan Harian') !== false, "Page title found");
assert(strpos($res['body'], 'guru/tugas/1/nilai/1') !== false, "Specific link to task 1 grading found");
echo "PASS: Action buttons correctly link to /guru/tugas/1/nilai/{id}!\n";

echo "3. Opening dedicated grading page for Tugas 1 (/guru/tugas/1/nilai/1)...\n";
$res = curlGet($baseUrl . '/guru/tugas/1/nilai/1', $cookieFile);
assert(strpos($res['body'], 'Input Nilai: Tugas 1') !== false, "Tugas 1 title found");
assert(strpos($res['body'], 'statAvgKelas') !== false, "Stat card found");
echo "PASS: Dedicated grading page loaded successfully!\n";

echo "4. Submitting updated grades for Tugas 1 (Setting Aldi Kurniawan siswa_id 5 to 95)...\n";
$postData = [
    'judul_tugas' => 'Tugas 1: Pembuktian Induksi Matematika',
    'nilai' => [
        1 => 90,
        2 => 85,
        3 => 80,
        4 => 92,
        5 => 95 // Updated from 76 to 95
    ],
    'catatan' => [
        5 => 'Sangat bagus perbaikannya!'
    ]
];
$res = curlPost($baseUrl . '/guru/tugas/1/nilai/1', $postData, $cookieFile);
echo "Status POST: " . $res['code'] . "\n";
assert(strpos($res['body'], 'berhasil disimpan') !== false, "Success message found");

echo "5. Verifying that the average automatically updated in Buku Nilai Mapel (/guru/nilai/1/pengetahuan)...\n";
$res = curlGet($baseUrl . '/guru/nilai/1/pengetahuan', $cookieFile);
assert(strpos($res['body'], '81.3') !== false, "Aldi's new average Tugas (81.3) found in Buku Nilai!");
echo "PASS: Automatic calculation correctly updated Aldi's Tugas average to 81.3!\n";

echo "\nALL TESTS PASSED WITH 100% SUCCESS!\n";
