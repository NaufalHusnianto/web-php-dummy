<?php
    require_once("config.php");

    $rack_sql = "
        SELECT racks.id AS rack_id, racks.rack_name AS rack_name, books.id AS book_id, books.title AS book_name, books.author AS book_author, books.year_published
        FROM racks
        LEFT JOIN books ON books.rack_id = racks.id
    ";

    $result = mysqli_query($koneksi, $rack_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rak Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-4">
    <h1 class="text-center">Rak Buku</h1>

    <div class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="add-rack.php" class="btn btn-success">Tambah Rak</a>
    </div>

    <div class="accordion mt-4" id="accordionRack">
        <?php
            $current_rack = null;
            
            while ($row = mysqli_fetch_array($result)) {
                if ($current_rack != $row['rack_id']) {
                    if ($current_rack != null) {
                        echo '</ul></div></div>';
                    }

                    $current_rack = $row['rack_id'];

                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading' . $current_rack . '">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $current_rack . '" aria-expanded="false" aria-controls="collapse' . $current_rack . '">
                                Rak: ' . $row['rack_name'] . '
                            </button>
                        </h2>
                        <div id="collapse' . $current_rack . '" class="accordion-collapse collapse" aria-labelledby="heading' . $current_rack . '" data-bs-parent="#accordionRack">
                            <div class="accordion-body">
                                <ul class="list-group">                 
                    ';
                }

                echo '
                    <li class="list-group-item">
                        <strong>' . $row['book_name'] . '</strong> oleh ' . $row['book_author'] . ' (Terbit: ' . $row['year_published'] . ')
                    </li>
                    <a href="delete-rack.php?id=' . $row['rack_id'] . '" class="btn btn-danger mt-4" onclick="return confirm("Yakin menghapus data?")">Delete Rak</a>

                ';
            }
            
            if ($current_rack != null) {
                echo '</ul></div></div>';
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
