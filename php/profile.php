<?php
session_start();
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

