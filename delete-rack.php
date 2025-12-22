<?php
require_once "config.php";

$id = $_GET['id'];

$book_check_sql = "SELECT * FROM books WHERE rack_id = $id";
$book_result = mysqli_query($koneksi, $book_check_sql);

if (mysqli_num_rows($book_result) > 0) {
    echo "<script>alert('Rak ini berisi buku dan tidak dapat dihapus.');window.location='rack.php';</script>";
} else {
    $sql = "DELETE FROM racks WHERE id=$id";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: rack.php");
    } else {
        echo "Gagal delete data";
    }
}
