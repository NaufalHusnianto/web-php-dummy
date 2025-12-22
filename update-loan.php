<?php
require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loan_id = $_POST['loan_id'];
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $loan_date = $_POST['loan_date'];
    $return_date = $_POST['return_date'];
    $status = $_POST['status'];

    if (empty($loan_date) || empty($return_date) || empty($status)) {
        echo "Semua kolom harus diisi.";
        exit;
    }

    $update_sql = "UPDATE loans SET user_id = ?, book_id = ?, loan_date = ?, return_date = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $update_sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $user_id, $book_id, $loan_date, $return_date, $status, $loan_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: loans.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
