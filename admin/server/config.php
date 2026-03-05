<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$db=mysqli_connect("localhost","root","","mini_store");


if (!$db) {
    header("location:404.php");
}


?>