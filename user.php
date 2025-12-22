<?php
require_once("auth.php");
// Hanya admin yang bisa akses
checkRole(['admin']);

require_once("config.php");

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}

$title = "List Pengguna";
require_once("header.php");
?>

    <h1 class="text-center mb-4">List Pengguna</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="add-user.php" class="btn btn-success">Tambah Pengguna</a>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : 'primary' ?>">
                        <?= htmlspecialchars($user['role']) ?>
                    </span>
                </td>
                <td>
                    <a href="show-user.php?id=<?= $user['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="edit-user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                    <a href="delete-user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin menghapus pengguna ini?')">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $no++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once("footer.php"); ?>