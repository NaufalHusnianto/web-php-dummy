<?php
require_once("config.php");

$user_sql = "SELECT * FROM users";
$result = mysqli_query($koneksi, $user_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="p-4">
    <h1 class="text-center">List Pengguna</h1>

    <div class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="add-user.php" class="btn btn-success">Tambah Pengguna</a>
    </div>

    <table class="table mt-2">
        <tr class="table-dark">
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Password</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php
        $no = 1;
        while ($user = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?= htmlspecialchars($no, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['password'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="show-user.php?id=<?= urlencode($user['id']) ?>" class="btn btn-info">Detail</a>
                    <a href="edit-user.php?id=<?= urlencode($user['id']) ?>" class="btn btn-warning">Edit</a>
                    <a href="delete-user.php?id=<?= urlencode($user['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin menghapus data?')">Delete</a>
                </td>
            </tr>

        <?php
            $no++;
        }
        ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>