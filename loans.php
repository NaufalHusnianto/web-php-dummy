<?php
    require_once("config.php");

    $loan_sql = "
        SELECT loans.id AS loan_id, 
            loans.loan_date, 
            loans.return_date, 
            loans.status, 
            users.name AS user_name, 
            books.title AS book_title 
        FROM loans 
        INNER JOIN users ON loans.user_id = users.id
        INNER JOIN books ON loans.book_id = books.id
    ";
    $result = mysqli_query($koneksi, $loan_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Peminjaman Buku</h1>
    
    <div class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="add-loan.php" class="btn btn-success">Tambah Data Peminjaman</a>
    </div>

    <table class="table mt-2">
        <tr class="table-dark">
            <th>No</th>
            <th>ID Peminjaman</th>
            <th>Nama Peminjam</th>
            <th>Nama Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
            $no = 1;
            while ($pinjam = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= $pinjam['loan_id'] ?></td>
            <td><?= $pinjam['user_name'] ?></td>
            <td><?= $pinjam['book_title'] ?></td>
            <td><?= $pinjam['loan_date'] ?></td>
            <td><?= $pinjam['return_date'] ?? '-' ?></td>
            <td><?= $pinjam['status'] ?></td>
            <td>
                <a href="edit-loan.php?id=<?= $pinjam['loan_id'] ?>" class="btn btn-warning">Edit</a>
                <a href="delete-loan.php?id=<?= $pinjam['loan_id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin menghapus data?')">Delete</a>
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
