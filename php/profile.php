<?php
session_start();
$username = $_SESSION['username'] ?? "Adnane";
$email    = $_SESSION['email'] ?? "elkoubaiadnane2004@email.com";
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
<<<<<<< HEAD
=======
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])) {
    header("Location: ../login");
    exit;
}

$id_cl = intval($_SESSION['id_cl']);

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone is required';
    }
    
    if (empty($address)) {
        $errors[] = 'Address is required';
    }
    
    // Check if email is already taken by another user
    if (!empty($email)) {
        $sql_check_email = "SELECT id_cl FROM log WHERE email = ? AND id_cl != ?";
        $stmt_check = mysqli_prepare($db, $sql_check_email);
        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, "si", $email, $id_cl);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            if (mysqli_num_rows($result_check) > 0) {
                $errors[] = 'Email is already taken by another user';
            }
            mysqli_stmt_close($stmt_check);
        }
    }
    
    // If no errors, update the database
    if (empty($errors)) {
        // Start transaction
        mysqli_begin_transaction($db);
        
        try {
            // Update client table
            $sql_client = "UPDATE client SET nom_cl = ?, tel = ?, adresse = ? WHERE id_cl = ?";
            $stmt_client = mysqli_prepare($db, $sql_client);
            if ($stmt_client) {
                mysqli_stmt_bind_param($stmt_client, "sssi", $name, $phone, $address, $id_cl);
                if (!mysqli_stmt_execute($stmt_client)) {
                    throw new Exception('Failed to update client information');
                }
                mysqli_stmt_close($stmt_client);
            } else {
                throw new Exception('Failed to prepare client update statement');
            }
            
            // Update log table (email)
            $sql_log = "UPDATE log SET email = ? WHERE id_cl = ?";
            $stmt_log = mysqli_prepare($db, $sql_log);
            if ($stmt_log) {
                mysqli_stmt_bind_param($stmt_log, "si", $email, $id_cl);
                if (!mysqli_stmt_execute($stmt_log)) {
                    throw new Exception('Failed to update email');
                }
                mysqli_stmt_close($stmt_log);
            } else {
                throw new Exception('Failed to prepare log update statement');
            }
            
            // Update session email if changed
            $_SESSION['email'] = $email;
            
            // Commit transaction
            mysqli_commit($db);
            
            // Redirect with success message
            header("Location: ../profile?success=1");
            exit;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($db);
            header("Location: ../profile?error=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        // Redirect with error messages
        $error_msg = implode(', ', $errors);
        header("Location: ../profile?error=" . urlencode($error_msg));
        exit;
    }
} else {
    // If not POST request, redirect to profile page
    header("Location: ../profile");
    exit;
}
?>

>>>>>>> a38f2bdbe1b3e029b4d078d58590059ba829f710
=======
>>>>>>> 33b37b6f5f3368444f47085d091cc12d97de0dcb
