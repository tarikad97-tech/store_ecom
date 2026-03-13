
<?php

global $db;
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






function addProduct($db){

    if(isset($_POST['name'])){

        $name = $_POST['name'];
         $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
       $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        

        $folder = "../img/" . $image;

        move_uploaded_file($tmp_name, $folder);

        $sql = "INSERT INTO products(name,description,price,stock,image)
                VALUES('$name','$description','$price','$stock','$image')";

        $result = mysqli_query($db,$sql);

        if($result){
            header("Location: ../products.php?success=1");
        }else{
            echo "Error: " . mysqli_error($db);
        }

    }

}

addProduct($db);

?>