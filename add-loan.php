<?php
    include_once "config.php";

    $usersQuery = "SELECT id, name FROM users";
    $usersResult = mysqli_query($koneksi, $usersQuery);

    $booksQuery = "SELECT id, title FROM books";
    $booksResult = mysqli_query($koneksi, $booksQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Peminjaman</h1>

    <form action="add-loan.php" method="post">
        <div class="mb-3">
            <label for="user_id" class="form-label">Pilih Peminjam</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Pilih Pengguna</option>
                <?php
                    while ($row = mysqli_fetch_assoc($usersResult)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="book_id" class="form-label">Book</label>
            <select class="form-control" id="book_id" name="book_id" required>
                <option value="">Pilih Buku</option>
                <?php
                    while ($row = mysqli_fetch_assoc($booksResult)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                    }
                ?>
            </select>
        </div>
         <div class="mb-3">
            <label for="loan_date" class="form-label">Loan Date</label>
            <input type="date" class="form-control" id="loan_date" name="loan_date" required>
        </div>
        <div class="mb-3">
            <label for="return_date" class="form-label">Return Date</label>
            <input type="date" class="form-control" id="return_date" name="return_date">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="">Pilih Status</option>
                <option value="borrowed">Borrowed</option>
                <option value="returned">Returned</option>
            </select>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
        if (isset($_POST['submit'])) {
            $user_id = $_POST['user_id'];
            $book_id = $_POST['book_id'];
            $loan_date = $_POST['loan_date'];
            $return_date = !empty($_POST['return_date']) ? $_POST['return_date'] : NULL;
            $status = $_POST['status'];

            include_once "config.php";

            $sql = "INSERT INTO loans (user_id, book_id, loan_date, return_date, status) 
            VALUES ('$user_id', '$book_id', '$loan_date', " . ($return_date ? "'$return_date'" : "NULL") . ", '$status')";

            if (mysqli_query($koneksi, $sql)) {
                echo "Data peminjaman berhasil ditambahkan";
                header("Location: loans.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }
        }
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
