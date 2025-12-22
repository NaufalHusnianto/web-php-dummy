<?php
require_once "config.php";

$id = $_GET['id'];

$loan_check_sql = "SELECT * FROM loans WHERE book_id = $id";
$loan_result = mysqli_query($koneksi, $loan_check_sql);

if (mysqli_num_rows($loan_result) > 0) {
    echo "<script>alert('Buku ini sedang dipinjam dan tidak dapat dihapus.');window.location='book.php';</script>";
} else {
    $sql = "DELETE FROM books WHERE id=$id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: book.php");
    } else {
        echo "Gagal delete data";
    }
}
