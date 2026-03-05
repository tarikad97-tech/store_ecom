<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = mysqli_connect("localhost","root","","store-ecome");

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>