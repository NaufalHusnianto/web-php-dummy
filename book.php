<?php
    require_once("config.php");

    $book_sql = "SELECT books.id as book_id, books.title, books.author, books.isbn, books.year_published, books.genre, racks.rack_name 
    FROM books 
    INNER JOIN racks ON books.rack_id = racks.id";
    $result = mysqli_query($koneksi, $book_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">List Buku</h1>
    
    <div class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="add-book.php" class="btn btn-success">Tambah Data Buku</a>
    </div>

    <table class="table mt-2">
        <tr class="table-dark">
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>ISBN</th>
            <th>Tahun Terbit</th>
            <th>Genre</th>
            <th>Rak</th>
            <th>Action</th>
        </tr>
        <?php
            $no = 1;
            while ($book = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= $book['title'] ?></td>
            <td><?= $book['author'] ?></td>
            <td><?= $book['isbn'] ?></td>
            <td><?= $book['year_published'] ?></td>
            <td><?= $book['genre'] ?></td>
            <td><?= $book['rack_name'] ?></td>
            <td>
                <a href="delete-book.php?id=<?= $book['book_id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin menghapus data?')">Delete</a>
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