<?php
require_once "koneksi.php";

$total = 0;
$jenis_count = [];

if (isset($koneksi) && $koneksi) {
    $r = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM anggota");
    if ($r) $total = (int) mysqli_fetch_assoc($r)['total'];

    $rj = mysqli_query($koneksi, "SELECT jenis_anggota, COUNT(*) AS jml FROM anggota GROUP BY jenis_anggota");
    while ($rj && $row = mysqli_fetch_assoc($rj)) {
        $jenis_count[$row['jenis_anggota']] = (int) $row['jml'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">Sistem Perpustakaan</span>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="form_anggota.php">Daftar Anggota</a>
    <a href="data.php">Data Anggota</a>
</div>

<div class="wrapper">

    <div class="judul">Dashboard</div>
    <div class="sub-judul">Halaman utama sistem manajemen anggota perpustakaan</div>

    <!-- Statistik -->
    <div class="stat-row">
        <div class="stat-box">
            <div class="angka"><?php echo $total; ?></div>
            <div class="label">Total Anggota</div>
        </div>
        <div class="stat-box">
            <div class="angka"><?php echo $jenis_count['Mahasiswa'] ?? 0; ?></div>
            <div class="label">Mahasiswa</div>
        </div>
        <div class="stat-box">
            <div class="angka"><?php echo $jenis_count['Dosen'] ?? 0; ?></div>
            <div class="label">Dosen</div>
        </div>
        <div class="stat-box">
            <div class="angka"><?php echo $jenis_count['Tenaga Kependidikan'] ?? 0; ?></div>
            <div class="label">Tenaga Kependidikan</div>
        </div>
    </div>

    <!-- Menu -->
    <div class="menu-row">
        <div class="menu-box">
            <h3>Pendaftaran Anggota</h3>
            <p>Daftarkan anggota baru dengan mengisi formulir data diri. Data yang diisi meliputi nomor anggota, nama, email, nomor HP, jenis anggota, dan alamat.</p>
            <a href="form_anggota.php" class="btn btn-primary">Buka Formulir</a>
        </div>
        <div class="menu-box">
            <h3>Data Anggota</h3>
            <p>Lihat seluruh daftar anggota perpustakaan yang sudah terdaftar. Tersedia fitur untuk melihat detail dan menghapus data anggota.</p>
            <a href="data.php" class="btn btn-primary">Lihat Data</a>
        </div>
    </div>

    <!-- Info koneksi -->
    <div class="box">
        <h3>Informasi Sistem</h3>
        <p style="font-size:0.88rem; color:#555;">
            Status koneksi database:
            <strong style="color:<?php echo (isset($koneksi) && $koneksi) ? 'green' : 'red'; ?>">
                <?php echo (isset($koneksi) && $koneksi) ? 'Terhubung' : 'Tidak terhubung'; ?>
            </strong>
        </p>
    </div>

</div>

<div class="footer">
    Sistem Perpustakaan &copy; <?php echo date('Y'); ?> |
    <a href="test_koneksi.php">Test Koneksi Database</a>
</div>

</body>
</html>
