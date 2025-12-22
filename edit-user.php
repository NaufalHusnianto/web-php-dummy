<?php
    require_once("config.php");

    $user_id = $_GET['id'];

    $user_sql = "SELECT * FROM users WHERE id = $user_id";
    $user_result = mysqli_query($koneksi, $user_sql);
    $user = mysqli_fetch_array($user_result);

    if ($role !== 'admin' && $id !== $_SESSION['user_id']) {
    die("Akses ditolak (IDOR)");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Edit Pengguna</h1>

    <div class="card mb-4">
        <div class="card-header">
            Form Edit Pengguna
        </div>
        <div class="card-body">
            <form action="update-user.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <a href="user.php" class="btn btn-primary">Kembali ke List Pengguna</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
