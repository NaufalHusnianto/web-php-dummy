<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Fungsi untuk cek role
function checkRole($allowedRoles) {
    if (!in_array($_SESSION['user_role'], $allowedRoles)) {
        header("Location: index.php");
        exit;
    }
}

// Fungsi untuk mendapatkan data user saat ini
function getCurrentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'name' => $_SESSION['user_name'] ?? null,
        'email' => $_SESSION['user_email'] ?? null,
        'role' => $_SESSION['user_role'] ?? null
    ];
}
?>