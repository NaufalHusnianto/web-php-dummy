<?php
require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role !== 'admin' && $id !== $_SESSION['user_id']) {
    die("Akses ditolak (IDOR)");
    }

    if (empty($name) || empty($email) || empty($role)) {
        echo "Semua kolom harus diisi.";
        exit;
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $user_sql = "SELECT password FROM users WHERE id = $user_id";
        $user_result = mysqli_query($koneksi, $user_sql);
        $user = mysqli_fetch_array($user_result);
        $hashed_password = $user['password'];
    }

    $update_sql = "UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $update_sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $name, $email, $hashed_password, $role, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Pengguna berhasil diperbarui.";
        header("Location: user.php");
        exit;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
