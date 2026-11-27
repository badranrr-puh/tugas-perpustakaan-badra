<?php
function h($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$status  = $_GET['status'] ?? '';
$errors  = (array)($_GET['errors'] ?? []);
$id_baru = (int)($_GET['id'] ?? 0);

$fields = ['no_anggota', 'nama_lengkap', 'email', 'no_hp', 'jenis_anggota', 'alamat'];
$old    = array_combine($fields, array_map(fn($f) => $_GET[$f] ?? '', $fields));

$jenis_list = ['Mahasiswa', 'Dosen', 'Tenaga Kependidikan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota - Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <span class="brand">Sistem Perpustakaan</span>
    <a href="dashboard.php">Dashboard</a>
    <a href="form_anggota.php" class="active">Daftar Anggota</a>
    <a href="data.php">Data Anggota</a>
</div>

<div class="wrapper">

    <div class="judul">Pendaftaran Anggota</div>
    <div class="sub-judul">Isi formulir berikut untuk mendaftarkan anggota baru</div>

    <div class="box" style="max-width: 540px;">
        <h3>Formulir Pendaftaran Anggota</h3>

        <?php if ($status === 'berhasil'): ?>
        <div class="notif notif-sukses">
            <strong>Pendaftaran Berhasil!</strong><br>
            Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo h($_GET['nama_lengkap'] ?? ''); ?><br>
            No. Anggota : <?php echo h($_GET['no_anggota'] ?? ''); ?><br>
            ID Record&nbsp;&nbsp;: #<?php echo $id_baru; ?>
        </div>
        <?php endif; ?>

        <?php if ($status === 'gagal' && $errors): ?>
        <div class="notif notif-gagal">
            <strong>Pendaftaran Gagal!</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo h($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="proses.php" method="POST">

            <div class="form-group">
                <label>Nomor Anggota <span class="req">*</span></label>
                <input type="text" name="no_anggota"
                       value="<?php echo h($old['no_anggota']); ?>"
                       placeholder="Contoh: 250202038" maxlength="15">
            </div>

            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama_lengkap"
                       value="<?php echo h($old['nama_lengkap']); ?>"
                       placeholder="Masukkan nama lengkap" maxlength="100">
            </div>

            <div class="form-group">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email"
                       value="<?php echo h($old['email']); ?>"
                       placeholder="contoh@email.com" maxlength="100">
            </div>

            <div class="form-group">
                <label>Nomor HP <span class="req">*</span></label>
                <input type="tel" name="no_hp"
                       value="<?php echo h($old['no_hp']); ?>"
                       placeholder="081234567890" maxlength="15">
            </div>

            <div class="form-group">
                <label>Jenis Anggota <span class="req">*</span></label>
                <select name="jenis_anggota">
                    <option value="">-- Pilih Jenis Anggota --</option>
                    <?php foreach ($jenis_list as $jenis): ?>
                    <option value="<?php echo h($jenis); ?>"
                        <?php echo ($old['jenis_anggota'] === $jenis) ? 'selected' : ''; ?>>
                        <?php echo h($jenis); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat <span class="req">*</span></label>
                <textarea name="alamat" placeholder="Masukkan alamat lengkap..."><?php echo h($old['alamat']); ?></textarea>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Daftar</button>
                <button type="reset" class="btn">Reset</button>
                <a href="data.php" class="btn">Lihat Data</a>
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
