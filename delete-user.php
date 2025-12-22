<?php
require_once "config.php";

$id = $_GET['id'];

$loan_check_sql = "SELECT * FROM loans WHERE user_id = $id";
$loan_result = mysqli_query($koneksi, $loan_check_sql);

if (mysqli_num_rows($loan_result) > 0) {
    echo "<script>alert('User sedang meminjam buku dan tidak dapat dihapus.');window.location='user.php';</script>";
} else {
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: user.php");
    } else {
        echo "Gagal delete data";
    }
}
