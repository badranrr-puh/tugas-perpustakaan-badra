<?php
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Koneksi</title>
    <style>
        body { font-family: Arial, sans-serif; 
        background: #f2f2f2; margin: 0; padding: 30px; }
        .container {
            max-width: 420px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ccc;
            padding: 24px;
            text-align: center;
        }
        h2 { margin-top: 0; margin-bottom: 18px; font-size: 1.1rem; }
        .notif {
            padding: 12px 16px;
            border: 1px solid;
            margin-bottom: 16px;
            text-align: left;
            font-size: .9rem;
            line-height: 1.6;
        }
        .sukses { background: #d4edda; 
        border-color: #28a745; color: #155724; }
        .gagal  { background: #f8d7da; 
        border-color: #dc3545; color: #721c24; }
        a { color: #2d6a9f; font-size: .9rem; }
    </style>
</head>
<body>
<div class="container">
    <h2>Test Koneksi Database</h2>

    <?php if ($pesan_koneksi['status'] === 'sukses'): ?>
    <div class="notif sukses">
        <strong>Koneksi Berhasil</strong><br>
        <?php echo htmlspecialchars($pesan_koneksi['pesan'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <?php else: ?>
    <div class="notif gagal">
        <strong>Koneksi Gagal</strong><br>
        <?php echo htmlspecialchars($pesan_koneksi['pesan'], ENT_QUOTES, 'UTF-8'); ?><br>
        Kode Error: <?php echo htmlspecialchars((string)$pesan_koneksi['kode'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <?php endif; ?>

    <a href="form_anggota.php">Kembali ke Form</a>
</div>
</body>
</html>
