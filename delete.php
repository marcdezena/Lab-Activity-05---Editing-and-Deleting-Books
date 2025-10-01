<?php
require_once __DIR__ . '/product.php';
$productObj = new Product();

if($_SERVER["REQUEST_METHOD"] == "post"){
    if(isset($_GET["no"])){
        $pid = trim(htmlspecialchars($_GET["no"]));
        $product = $productObj->fetchproduct($pid);
        
        if(!$product){
            echo "<a href='viewbook'>View Product</a>";
            exit("No product found");
        }else{
            $productObj->delete($pid);
            header("Location: viewbook.php");
        }
    }else{
        echo "<a href='viewbook'>View Product</a>";
        exit("No product found");
    }
}