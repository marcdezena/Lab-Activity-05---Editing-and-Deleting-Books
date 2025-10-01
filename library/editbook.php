<?php

require_once __DIR__ .'/product.php';
$productObj = new Product();

$product = [ 
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => "",
    "publisher" => "",
    "copies" => ""
];
$errors = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => "",
    "publisher" => "",
    "copies" => ""
 ];

 if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["no"])){
        $pno=trim(htmlspecialchars($_GET["no"]));
        $product = $productObj->fetchproduct($pno);

        if(!$product){
            echo "<a href='viewproduct.php'>view product</a>";
            exit("Product not found");
        }
    }else{
        echo "<a href='viewproduct.php'>view product</a>";
        exit("Product not found");
    }
 }

    elseif ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product["title"] = trim(htmlspecialchars($_POST["title"]));
        $product["author"] = trim(htmlspecialchars($_POST["author"]));
        $product["genre"] = trim(htmlspecialchars($_POST["genre"]));
        $product["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
        $product["publisher"] = trim(htmlspecialchars($_POST["publisher"]));
        $product["copies"] = trim(htmlspecialchars($_POST["copies"]));

        if (empty($product["title"]))
            $errors["title"] = "Book title is required";

        if (empty($product["author"]))
            $errors["author"] = "Book author is required";

        if (empty($product["genre"]))
            $errors["genre"] = "Book genre is required";
        
        if (empty($product["publication_year"]) && $product["publication_year"] != 0)
            $errors["publication_year"] = "year is required";
        
        else if (!is_numeric($product["publication_year"]) || $product["publication_year"] <= 1900)
            $errors["publication_year"] = "the publication year must be greater than 1900";

        if (empty($product["publisher"]))
            $errors["publisher"] = "Book publisher is required";

        if (empty($product["copies"]) && $product["copies"] != 0)
            $errors["copies"] = "number of copies is required";

        
    if (empty(array_filter($errors)))
        {
            $productObj->title = $product["title"];
            $productObj->author = $product["author"];
            $productObj->genre = $product["genre"];
            $productObj->publication_year = $product["publication_year"];
            $productObj->publisher = $product["publisher"];
            $productObj->copies = $product["copies"];

            if ($productObj->addbook())
                header("Location: viewbook.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="page"></div>
        <div class="add-container">
            <h1>EDIT BOOK</h1>
            <form action="" method="post">
                <label for="">Field with <span>*</span> is required</label><br>
                <label for="title">book title <span>*</span></label><br>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($product["title"]) ?>">
                <p class="error"><?= $errors["title"] ?></p>
                <label for="author">book author <span>*</span></label><br>
                <input type="text" name="author" id="author" value="<?= htmlspecialchars($product["author"]) ?>">
                <p class="error"><?= $errors["author"] ?></p>
                <label for=""> Book genre <span>*</span></label><br>
                <select name="genre" id="genre">
                    <option value="">--Select--</option>
                    <option value="history" <?= ($product["genre"] == "history") ? "selected" : ""; ?>>History</option>
                    <option value="science" <?= ($product["genre"] == "science") ? "selected" : "" ?>>Science</option>
                    <option value="fiction" <?= ($product["genre"] == "fiction") ? "selected" : "" ?>>Fiction</option>
                </select><br>
                <p class="error"><?= $errors["genre"] ?></p>
                <label for="publication_year">Publication Year <span>*</span></label><br>
                <input type="text" name="publication_year" id="publication_year" value="<?= htmlspecialchars($product["publication_year"]) ?>">
                <p class="error"><?= $errors["publication_year"] ?></p> 
                <label for="publisher">Publisher <span>*</span></label><br>
                <input type="text" name="publisher" id="publisher" value="<?= htmlspecialchars($product["publisher"]) ?>">
                <p class="error"><?= $errors["publisher"] ?></p>
                <label for="copies">Number of copies <span>*</span></label><br>
                <input type="text" name="copies" id="copies" value="<?= htmlspecialchars($product["copies"]) ?>">
                <p class="error"><?= $errors["copies"] ?></p>
                <br>
                <input class ="submit "type="submit" value="Add Book">
            </form> 
            <button><a href="viewbook.php">Check books</a></button>
        </div>
    </div>
</body>
</html>