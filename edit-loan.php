<?php
require_once("config.php");

$loan_id = $_GET['id'];

$loan_sql = "SELECT * FROM loans WHERE id = $loan_id";
$result = mysqli_query($koneksi, $loan_sql);
$loan = mysqli_fetch_array($result);

$user_sql = "SELECT * FROM users WHERE id = " . $loan['user_id'];
$user_result = mysqli_query($koneksi, $user_sql);
$user = mysqli_fetch_array($user_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Edit Peminjaman</h1>

    <div class="card mb-4">
        <div class="card-header">
            Form Edit Peminjaman
        </div>
        <div class="card-body">
            <form action="update-loan.php" method="post">
                <div class="mb-3">
                    <label for="loan_date" class="form-label">Tgl. Peminjaman</label>
                    <input type="date" class="form-control" id="loan_date" name="loan_date" value="<?= $loan['loan_date'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="return_date" class="form-label">Tgl. Pengembalian</label>
                    <input type="date" class="form-control" id="return_date" name="return_date" value="<?= $loan['return_date'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="borrowed" <?= $loan['status'] == 'borrowed' ? 'selected' : '' ?>>Borrowed</option>
                        <option value="returned" <?= $loan['status'] == 'returned' ? 'selected' : '' ?>>Returned</option>
                    </select>
                </div>
                
                <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                <input type="hidden" name="user_id" value="<?= $loan['user_id'] ?>">
                <input type="hidden" name="book_id" value="<?= $loan['book_id'] ?>">
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <a href="loans.php" class="btn btn-primary">Kembali ke List Peminjaman</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
