<?php
require_once "koneksi.php";


$id_no = $_POST['id'];
$query = "DELETE FROM anggota WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_no);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: data.php");
    exit;
} else{
    die("Gagal menghapus data" . mysqli_stmt_error($stmt));
}
?>