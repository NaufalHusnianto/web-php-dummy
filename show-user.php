<?php
require_once("config.php");
require_once("auth.php");

// Ambil ID dari URL
$user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$user_id) {
    die("ID tidak valid");
}

$sessionUserId = $_SESSION['user_id'];
$role = $_SESSION['user_role'] ?? null;

// 🔐 IDOR
if ($role !== 'admin' && $user_id !== $sessionUserId) {
    die("Akses ditolak (IDOR)");
}

try {
    // Query user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        die("User tidak ditemukan");
    }

    // Query daftar peminjaman
    $loan_stmt = $pdo->prepare("
        SELECT loans.loan_date, loans.return_date, books.title AS book_title
        FROM loans
        LEFT JOIN books ON loans.book_id = books.id
        WHERE loans.user_id = :id
    ");
    $loan_stmt->execute(['id' => $user_id]);
    $loans = $loan_stmt->fetchAll();

} catch (PDOException $e) {
    die("Terjadi kesalahan");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Detail Pengguna</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Pengguna
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        </div>
    </div>

    <h3>Daftar Peminjaman</h3>
    <table class="table mt-2">
        <tr class="table-dark">
            <th>No</th>
            <th>Judul Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
        </tr>
    <?php $no = 1; foreach ($loans as $loan): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($loan['book_title']) ?></td>
            <td><?= htmlspecialchars($loan['loan_date']) ?></td>
            <td><?= $loan['return_date']
                ? htmlspecialchars($loan['return_date'])
                : 'Belum dikembalikan' ?></td>
        </tr>
    <?php endforeach; ?>

    </table>

    <a href="user.php" class="btn btn-primary">Kembali ke List Pengguna</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
