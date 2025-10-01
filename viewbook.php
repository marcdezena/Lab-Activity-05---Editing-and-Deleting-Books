<?php

require_once __DIR__ . '/product.php';
$productObj = new Product();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Documents</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header-container">
        <h1>List of books</h1>
        <?php $q_get = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; $genre_get = isset($_GET['genre']) ? $_GET['genre'] : ''; ?>
        <a href="addbook.php" class="btn" style="display:inline-block; padding:4px 8px; background-color: gba(6, 144, 22, 0.41); color:black; text-decoration:none; border-radius:5px;">
  Add book
</a>
            <form method="get" class="search-form">
                <label for="q" class="search" style="color: rgb(49, 145, 49);">Search book</label><br>
                <input type="search" name="q" value="<?= $q_get ?>" >
                <select name="genre" id="genre">
                    <option value="">--all--</option>
                    <option value="history" <?= ($genre_get == "history") ? "selected" : ""; ?>>History</option>
                    <option value="science" <?= ($genre_get == "science") ? "selected" : "" ?>>Science</option>
                    <option value="fiction" <?= ($genre_get == "fiction") ? "selected" : "" ?>>Fiction</option>
                </select>
                <input type="submit" value="Search">
            </form>
             
    </div> 
    <div class="table-container">
        <table border=1>
            <tr>
                <th>No.</th>
                <th>title</th>
                <th>author</th>
                <th>genre</th>
                <th>publication_year</th>
                <th>publisher</th>
                <th>copies</th>
                <th>ACTIONS</th>
            </tr>  
        <?php
      $no = 1;
        $search = isset($_GET['q']) ? trim($_GET['q']) : null;
        $genre = isset($_GET['genre']) ? trim($_GET['genre']) : null;

        foreach ($productObj->viewbook($search, $genre) as $product) {
        $message = "Are you sure you want to delete the product " . htmlspecialchars($product['title']);
        ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $product["title"] ?></td>
                    <td><?= $product["author"] ?></td>
                    <td><?= $product["genre"] ?></td>
                    <td><?= $product["publication_year"] ?></td>
                    <td><?= $product["publisher"] ?></td>
                    <td><?= $product["copies"] ?></td>
                    <td>
                            <a href="editbook.php?no=<?= $product["no"] ?>" class="btn">Edit</a>
                            <a href="deletebook.php?no=<?= $product["no"] ?>" onclick="return confirm('<?= $message ?>')" class="btn">Delete</a>
                    </td>
                </tr>
            <?php
        }
            ?>
        </table>
    </div>
</body>
</html>