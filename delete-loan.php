<?php

require_once "config.php";
$id = $_GET['id'];
$sql = "DELETE FROM loans WHERE id=$id";
if (mysqli_query($koneksi, $sql)) {
    header("Location: loans.php");
} else {
    echo "Gagal delete data";
}