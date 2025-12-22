<?php
require_once("auth.php");
// Hanya admin yang bisa akses
checkRole(['admin']);

$title = "Tambah Pengguna";
require_once("header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO users (name, email, password, role) 
                VALUES (:name, :email, :password, :role)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashed_password,
            ':role' => $role
        ]);
        
        $_SESSION['success_message'] = "Pengguna berhasil ditambahkan";
        header("Location: user.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

    <h1 class="text-center mb-4">Tambah Pengguna</h1>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="user.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

<?php require_once("footer.php"); ?>