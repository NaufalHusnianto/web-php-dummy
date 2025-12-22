<?php
require_once "config.php";

// 1️⃣ WAJIB POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses ditolak");
}

// 2️⃣ VALIDASI CSRF TOKEN
if (
    !isset($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    die("CSRF token tidak valid");
}

// 3️⃣ AMBIL ID DARI POST
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID tidak valid");
}

// 4️⃣ CEK APAKAH USER MASIH PINJAM BUKU
$stmt = $pdo->prepare("SELECT COUNT(*) FROM loans WHERE user_id = :id");
$stmt->execute(['id' => $id]);
$loan_count = $stmt->fetchColumn();

if ($loan_count > 0) {
    echo "<script>
        alert('User sedang meminjam buku dan tidak dapat dihapus.');
        window.location='user.php';
    </script>";
    exit;
}

// 5️⃣ DELETE USER (AMAN)
$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: user.php");
exit;
