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
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $company_name = trim($_POST['company_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $postcode = trim($_POST['postcode'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $order_notes = trim($_POST['order_notes'] ?? '');
    $payment_method = $_POST['payment_method'] ?? '';
    $shipping = $_POST['shipping'] ?? 'free';
    
    // Validate required fields
    $errors = [];
    
    if (empty($first_name)) $errors[] = 'First name is required';
    if (empty($last_name)) $errors[] = 'Last name is required';
    if (empty($address)) $errors[] = 'Address is required';
    if (empty($city)) $errors[] = 'City is required';
    if (empty($country)) $errors[] = 'Country is required';
    if (empty($phone)) $errors[] = 'Phone is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($payment_method)) $errors[] = 'Payment method is required';
    
    // Get cart items and calculate total
    $cart_items = [];
    $subtotal = 0;
    $shipping_cost = ($shipping === 'flat') ? 20 : 0;
    
    $sql_cart = "SELECT * FROM card WHERE id_cl = ?";
    $stmt_cart = mysqli_prepare($db, $sql_cart);
    mysqli_stmt_bind_param($stmt_cart, "i", $id_cl);
    mysqli_stmt_execute($stmt_cart);
    $result_cart = mysqli_stmt_get_result($stmt_cart);
    $row_cart = mysqli_fetch_assoc($result_cart);
    mysqli_stmt_close($stmt_cart);
    
    if (!$row_cart) {
        $errors[] = 'Your cart is empty';
    } else {
        $id_pa = intval($row_cart['id_pa']);
        $sql_items = "SELECT sous_card.id_sdpa, sous_card.id_pr, sous_card.qte, produit.nom_pr, produit.prix_pr 
                      FROM sous_card 
                      INNER JOIN produit ON sous_card.id_pr = produit.id_pr 
                      WHERE sous_card.id_pa = ?";
        $stmt_items = mysqli_prepare($db, $sql_items);
        mysqli_stmt_bind_param($stmt_items, "i", $id_pa);
        mysqli_stmt_execute($stmt_items);
        $result_items = mysqli_stmt_get_result($stmt_items);
        
        while($item = mysqli_fetch_assoc($result_items)) {
            $item_total = $item['prix_pr'] * $item['qte'];
            $subtotal += $item_total;
            $cart_items[] = $item;
        }
        mysqli_stmt_close($stmt_items);
        
        if (empty($cart_items)) {
            $errors[] = 'Your cart is empty';
        }
    }
    
    $total = $subtotal + $shipping_cost;
    
    // If no errors, process the order
    if (empty($errors)) {
        // Start transaction
        mysqli_begin_transaction($db);
        
        try {
            // Create order record (we'll need to create an orders table)
            // For now, we'll just clear the cart and show success
            // You can create an orders table later if needed
            
            // Delete cart items
            $sql_delete_cart = "DELETE FROM sous_card WHERE id_pa = ?";
            $stmt_delete = mysqli_prepare($db, $sql_delete_cart);
            mysqli_stmt_bind_param($stmt_delete, "i", $id_pa);
            
            if (!mysqli_stmt_execute($stmt_delete)) {
                throw new Exception('Failed to clear cart');
            }
            mysqli_stmt_close($stmt_delete);
            
            // Optionally delete the cart itself
            $sql_delete_card = "DELETE FROM card WHERE id_pa = ?";
            $stmt_delete_card = mysqli_prepare($db, $sql_delete_card);
            mysqli_stmt_bind_param($stmt_delete_card, "i", $id_pa);
            mysqli_stmt_execute($stmt_delete_card);
            mysqli_stmt_close($stmt_delete_card);
            
            // Commit transaction
            mysqli_commit($db);
            
            // Redirect to success page
            header("Location: ../order_success?total=" . urlencode($total) . "&method=" . urlencode($payment_method));
            exit;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($db);
            header("Location: ../chackout?error=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        // Redirect with error messages
        $error_msg = implode(', ', $errors);
        header("Location: ../chackout?error=" . urlencode($error_msg));
        exit;
    }
} else {
    // If not POST request, redirect to checkout
    header("Location: ../chackout");
    exit;
}
?>

