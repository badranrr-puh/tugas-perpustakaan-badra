<?php
require_once "koneksi.php";

$id = (int) $_GET['id'];

$query = "SELECT * FROM anggota WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Data anggota tidak ditemukan");
}

$baris = mysqli_fetch_assoc($result);

$jenis_list = ['Mahasiswa', 'Dosen', 'Tenaga Kependidikan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">Sistem Perpustakaan</span>
    <a href="dashboard.php">Dashboard</a>
    <a href="form_anggota.php">Daftar Anggota</a>
    <a href="data.php" class="active">Data Anggota</a>
</div>

<div class="wrapper">

    <div class="judul">Edit Data Anggota</div>
    <div class="sub-judul">Ubah data anggota yang sudah terdaftar di sistem</div>

    <div class="box" style="max-width: 540px;">
        <h3>Formulir Edit Anggota</h3>

        <form action="proses_update.php" method="POST">
            <input type="hidden" name="id" value="<?= $baris['id']; ?>">

            <div class="form-group">
                <label>Nomor Anggota <span class="req">*</span></label>
                <input type="text" name="no_anggota"
                       value="<?= htmlspecialchars($baris['no_anggota']); ?>"
                       placeholder="Contoh: 250202038" maxlength="15" required>
            </div>

            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama_lengkap"
                       value="<?= htmlspecialchars($baris['nama_lengkap']); ?>"
                       placeholder="Masukkan nama lengkap" maxlength="100" required>
            </div>

            <div class="form-group">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email"
                       value="<?= htmlspecialchars($baris['email']); ?>"
                       placeholder="contoh@email.com" maxlength="100" required>
            </div>

            <div class="form-group">
                <label>Nomor HP <span class="req">*</span></label>
                <input type="tel" name="no_hp"
                       value="<?= htmlspecialchars($baris['no_hp']); ?>"
                       placeholder="081234567890" maxlength="15" required>
            </div>

            <div class="form-group">
                <label>Jenis Anggota <span class="req">*</span></label>
                <select name="jenis_anggota" required>
                    <option value="">-- Pilih Jenis Anggota --</option>
                    <?php foreach ($jenis_list as $jenis): ?>
                    <option value="<?= htmlspecialchars($jenis); ?>"
                        <?= ($baris['jenis_anggota'] === $jenis) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($jenis); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat <span class="req">*</span></label>
                <textarea name="alamat" placeholder="Masukkan alamat lengkap..." required><?= htmlspecialchars($baris['alamat']); ?></textarea>
            </div>

            <div class="btn-row">
                <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                <a href="data.php" class="btn">Batal</a>
            </div>

        </form>
    </div>

</div>

<div class="footer">
    Sistem Perpustakaan &copy; <?php echo date('Y'); ?> |
    <a href="test_koneksi.php">Test Koneksi Database</a>
</div>

</body>
</html>