<?php
require_once "config.php";


function getAllProducts(){
   
    $sql="SELECT * FROM products";
    $result=mysqli_query($db,$sql);
    $products=[];
    while ($row=mysqli_fetch_assoc($result)) {
        $products[]=$row;
    }
    return $products;
}


function getAllcategories(){
   
    $sql="SELECT * FROM categories";
    $result=mysqli_query($db,$sql);
    $categories=[];
    while ($row=mysqli_fetch_assoc($result)) {
        $categories[]=$row;
    }
    return $categories;
}


?>