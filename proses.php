<?php
require_once 'koneksi.php';

// Pastikan request dari POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form_anggota.php');
    exit;
}

// Ambil dan bersihkan input dengan isset() + trim()
$no_anggota    = isset($_POST['no_anggota'])    ? trim($_POST['no_anggota'])    : '';
$nama_lengkap  = isset($_POST['nama_lengkap'])  ? trim($_POST['nama_lengkap'])  : '';
$email         = isset($_POST['email'])         ? trim($_POST['email'])         : '';
$no_hp         = isset($_POST['no_hp'])         ? trim($_POST['no_hp'])         : '';
$jenis_anggota = isset($_POST['jenis_anggota']) ? trim($_POST['jenis_anggota']) : '';
$alamat        = isset($_POST['alamat'])        ? trim($_POST['alamat'])        : '';

$errors = [];

// Validasi empty() - semua field wajib diisi
if (empty($no_anggota))    $errors[] = 'Nomor Anggota wajib diisi.';
if (empty($nama_lengkap))  $errors[] = 'Nama Lengkap wajib diisi.';
if (empty($email))         $errors[] = 'Email wajib diisi.';
if (empty($no_hp))         $errors[] = 'Nomor HP wajib diisi.';
if (empty($jenis_anggota)) $errors[] = 'Jenis Anggota wajib dipilih.';
if (empty($alamat))        $errors[] = 'Alamat wajib diisi.';

// Validasi format email dengan filter_var()
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid (contoh: nama@domain.com).';
}

// Validasi no_hp hanya angka dengan ctype_digit()
if (!empty($no_hp) && !ctype_digit($no_hp)) {
    $errors[] = 'Nomor HP hanya boleh berisi angka (tanpa spasi atau tanda baca).';
}
if (!empty($no_hp) && (strlen($no_hp) < 9 || strlen($no_hp) > 15)) {
    $errors[] = 'Nomor HP harus terdiri dari 9 hingga 15 digit angka.';
}

// Validasi jenis anggota terhadap whitelist
$jenis_diizinkan = ['Mahasiswa', 'Dosen', 'Tenaga Kependidikan'];
if (!empty($jenis_anggota) && !in_array($jenis_anggota, $jenis_diizinkan, true)) {
    $errors[] = 'Jenis Anggota yang dipilih tidak valid.';
}

// Jika ada error → redirect balik ke form dengan pesan
if (!empty($errors)) {
    $query = http_build_query([
        'status'        => 'gagal',
        'errors'        => $errors,
        'no_anggota'    => $no_anggota,
        'nama_lengkap'  => $nama_lengkap,
        'email'         => $email,
        'no_hp'         => $no_hp,
        'jenis_anggota' => $jenis_anggota,
        'alamat'        => $alamat,
    ]);
    header('Location: form_anggota.php?' . $query);
    exit;
}

// Cek koneksi database
if ($pesan_koneksi['status'] === 'error') {
    $query = http_build_query([
        'status' => 'gagal',
        'errors' => ['Koneksi database gagal: ' . $pesan_koneksi['pesan']],
    ]);
    header('Location: form_anggota.php?' . $query);
    exit;
}

// Simpan ke database dengan prepared statement
$sql  = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $query = http_build_query([
        'status' => 'gagal',
        'errors' => ['Gagal menyiapkan query: ' . mysqli_error($koneksi)],
    ]);
    header('Location: form_anggota.php?' . $query);
    exit;
}

// Bind 6 parameter bertipe string dengan mysqli_stmt_bind_param()
mysqli_stmt_bind_param($stmt, 'ssssss', $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat);

// Eksekusi query dengan mysqli_stmt_execute()
$hasil = mysqli_stmt_execute($stmt);

if ($hasil) {
    $id_baru = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);

    header('Location: form_anggota.php?status=berhasil&id=' . $id_baru
         . '&nama_lengkap=' . urlencode($nama_lengkap)
         . '&no_anggota='   . urlencode($no_anggota));
    exit;
} else {
    $mysql_errno = mysqli_stmt_errno($stmt);
    $mysql_error = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);

    if ($mysql_errno === 1062) {
        if (strpos($mysql_error, 'no_anggota') !== false) {
            $penyebab = 'Nomor Anggota <strong>' . htmlspecialchars($no_anggota, ENT_QUOTES, 'UTF-8') . 
            '</strong> sudah terdaftar.';
        } elseif (strpos($mysql_error, 'email') !== false) {
            $penyebab = 'Email <strong>' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . 
            '</strong> sudah terdaftar.';
        } else {
            $penyebab = 'Data duplikat ditemukan.';
        }
    } else {
        $penyebab = 'Error MySQL #' . $mysql_errno . ': ' . $mysql_error;
    }

    $query = http_build_query([
        'status'        => 'gagal',
        'errors'        => [$penyebab],
        'no_anggota'    => $no_anggota,
        'nama_lengkap'  => $nama_lengkap,
        'email'         => $email,
        'no_hp'         => $no_hp,
        'jenis_anggota' => $jenis_anggota,
        'alamat'        => $alamat,
    ]);
    header('Location: form_anggota.php?' . $query);
    exit;
}
