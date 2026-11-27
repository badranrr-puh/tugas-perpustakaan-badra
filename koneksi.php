<?php
mysqli_report(MYSQLI_REPORT_OFF);
$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'db_perpustakaan';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    $pesan_koneksi = [
        'status' => 'error',
        'pesan'  => 'Koneksi database GAGAL: ' . mysqli_connect_error(),
        'kode'   => mysqli_connect_errno()
    ];
} else {
    mysqli_set_charset($koneksi, 'utf8mb4');
    $pesan_koneksi = [
        'status' => 'sukses',
        'pesan'  => 'Koneksi database BERHASIL ke server: ' . $host . ', database: ' . $database
    ];
}
