<?php
session_start();
$username = $_SESSION['fname'] ;
$email    = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">

        <div class="text-center">
            <img src="https://via.placeholder.com/120"
                 class="rounded-circle mb-3"
                 width="120" height="120">
            <h3><?php echo $username; ?></h3>
            <p class="text-muted"><?php echo $email; ?></p>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <a href="edit_profile.php" class="btn btn-primary">
                <i class="fa-solid fa-pen"></i> Edit Profile
            </a>

            <a href="logout.php" class="btn btn-danger">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>

    </div>
</div>

</body>
</html>
