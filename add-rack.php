<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rak Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Tambah Rak Buku</h1>

    <form action="add-rack.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3">
            <label for="rackName" class="form-label">Rak Buku</label>
            <input type="text" class="form-control" id="rackName" name="rackName">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
        if (isset($_POST['submit'])) {
            $rackName = $_POST['rackName'];

            include_once "config.php";

            $sql = "INSERT INTO racks (rack_name) VALUES ('$rackName')";

            if (mysqli_query($koneksi, $sql)) {
                echo "Data berhasil ditambahkan";
                header("Location: rack.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
