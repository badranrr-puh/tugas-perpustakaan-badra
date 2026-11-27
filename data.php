<?php
require_once "koneksi.php";

$query = "SELECT * FROM anggota ORDER BY nama_lengkap ASC";
$hasil = mysqli_query($koneksi, $query);
$jumlah = $hasil ? mysqli_num_rows($hasil) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota - Perpustakaan</title>
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

    <div class="judul">Data Anggota</div>
    <div class="sub-judul">Daftar seluruh anggota perpustakaan yang terdaftar di sistem</div>

    <div style="margin-bottom: 12px; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-size:0.88rem; color:#555;">Total data: <strong><?php echo $jumlah; ?></strong> anggota</span>
        <a href="form_anggota.php" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Jenis</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($jumlah === 0): ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding:20px; color:#888;">
                        Belum ada data anggota. <a href="form_anggota.php">Tambah sekarang</a>
                    </td>
                </tr>
                <?php else: ?>
                <?php $no = 1; while ($baris = mysqli_fetch_assoc($hasil)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($baris['no_anggota']); ?></td>
                    <td><?php echo htmlspecialchars($baris['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($baris['email']); ?></td>
                    <td><?php echo htmlspecialchars($baris['no_hp']); ?></td>
                    <td><?php echo htmlspecialchars($baris['jenis_anggota']); ?></td>
                    <td style="max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                        title="<?php echo htmlspecialchars($baris['alamat']); ?>">
                        <?php echo htmlspecialchars($baris['alamat']); ?>
                    </td>
                    <td>
                        <div class="aksi-cell">
                            <a href="edit_anggota.php?id=<?= $baris['id']; ?>" class="btn btn-sm">Edit</a>

                            <form action="hapus.php" method="post" style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                <input type="hidden" name="id" value="<?= $baris['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<div class="footer">
    Sistem Perpustakaan &copy; <?php echo date('Y'); ?> |
    <a href="test_koneksi.php">Test Koneksi Database</a>
</div>

</body>
</html>
