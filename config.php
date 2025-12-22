<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "php-perpus";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
