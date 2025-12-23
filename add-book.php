<?php
    include_once "config.php";

    $racksQuery = "SELECT id, rack_name FROM racks";
    $racksResult = mysqli_query($koneksi, $racksQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Tambah Buku</h1>

    <form action="add-book.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3">
            <label for="bookTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="bookTitle" name="bookTitle">
        </div>
        <div class="mb-3">
            <label for="bookAuthor" class="form-label">Author</label>
            <input type="text" class="form-control" id="bookAuthor" name="bookAuthor">
        </div>
        <div class="mb-3">
            <label for="bookISBN" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="bookISBN" name="bookISBN">
        </div>
        <div class="mb-3">
            <label for="bookYear" class="form-label">Published Year</label>
            <input type="text" class="form-control" id="bookYear" name="bookYear">
        </div>
        <div class="mb-3">
            <label for="bookGenre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="bookGenre" name="bookGenre">
        </div>
        <div class="mb-3">
            <label for="rackId" class="form-label">Rack</label>
            <select type="text" class="form-control" id="rackId" name="rackId">
                <?php while ($row = mysqli_fetch_assoc($racksResult)) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['rack_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
        if (isset($_POST['submit'])) {
            $bookTitle = $_POST['bookTitle'];
            $bookAuthor = $_POST['bookAuthor'];
            $bookISBN = $_POST['bookISBN'];
            $bookYear = $_POST['bookYear'];
            $bookGenre = $_POST['bookGenre'];
            $rackId = $_POST['rackId'];

            include_once "config.php";

            $sql = "INSERT INTO books (title, author, isbn, year_published, genre, rack_id) 
                    VALUES ('$bookTitle', '$bookAuthor', '$bookISBN', '$bookYear', '$bookGenre', '$rackId')";

            if (mysqli_query($koneksi, $sql)) {
                echo "Data buku berhasil ditambahkan";
                header("Location: book.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }
        }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
