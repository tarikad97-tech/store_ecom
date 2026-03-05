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

function adminlog($email,$passeword){
   

$sql = "SELECT email,passeword FROM admins WHERE admins.email = '$email' and admins.paseword='$passeword' and admins.role='admin'";
$res= mysqli_query($db, $sql);

if(mysqli_num_rows($res) > 0){
    // echo "Email existe dans la base de données";
    header('location:index.php');
}else{
    header('location:login.php?msj=0');
}
}

?>