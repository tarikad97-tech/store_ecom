<?php
$db=mysqli_connect("localhost","root","","mini_store");


if (!$db) {
    header("location:404.php");
}


?>