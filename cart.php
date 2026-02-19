  <?php
include 'navbar.php';
  ?>
  
        <!-- Navbar End -->


        <!-- Modal Search Start -->
   
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php


                            if(!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])){
                               header("Location: login");
                               exit;
                            } else {
                              $id_cl = intval($_SESSION['id_cl']);
                              $sql = "SELECT * FROM card WHERE id_cl = ?";
                              $stmt = mysqli_prepare($db, $sql);
                              mysqli_stmt_bind_param($stmt, "i", $id_cl);
                              mysqli_stmt_execute($stmt);
                              $result = mysqli_stmt_get_result($stmt);
                              $row = mysqli_fetch_assoc($result);
                              mysqli_stmt_close($stmt);
                              
                              if($row) {
                                  $id_pa = intval($row['id_pa']);
                                  $sql2 = "SELECT sous_card.id_sdpa, sous_card.id_pa, sous_card.id_pr, sous_card.qte, produit.nom_pr, produit.prix_pr, produit.imgpr_pr FROM sous_card INNER JOIN produit ON sous_card.id_pr = produit.id_pr WHERE sous_card.id_pa = ?";
                                  $stmt2 = mysqli_prepare($db, $sql2);
                                  mysqli_stmt_bind_param($stmt2, "i", $id_pa);
                                  mysqli_stmt_execute($stmt2);
                                  $result2 = mysqli_stmt_get_result($stmt2);
                              } else {
                                  $result2 = false;
                              }
                                if($result2 && mysqli_num_rows($result2) > 0) {
                                    while($row2=mysqli_fetch_assoc($result2)){

?>
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="uploads/<?php echo $row2['imgpr_pr']; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4"><?php echo $row2['nom_pr']; ?></p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4" ><input type="hidden" name="prix_pr" class="price_pr" value="<?php echo $row2['prix_pr']; ?>"><?php echo $row2['prix_pr']; ?> DH</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" data-id="<?php echo $row2['id_sdpa']; ?>">
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 quantity_input" value="<?php echo $row2['qte']; ?>" min="1" max="10" data-id="<?php echo $row2['id_sdpa']; ?>">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" data-id="<?php echo $row2['id_sdpa']; ?>">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total_price"><?php echo $row2['prix_pr'] * $row2['qte']; ?> DH</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 delete_item" data-id="<?php echo $row2['id_sdpa']; ?>">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            
                            </tr>
                       <?php

                                    }
                                    if(isset($stmt2)) {
                                        mysqli_stmt_close($stmt2);
                                    }
                                } else {
                                    // Empty cart message
                                    echo '<tr><td colspan="6" class="text-center py-5"><p class="mb-0">Your cart is empty. <a href="shop">Continue Shopping</a></p></td></tr>';
                                }
                            }

?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                   <form id="coupon-form" action="#" method="post">
                     <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code" name="coupon_code" id="coupon_code" value="<?php echo isset($_POST['coupon_code']) ? htmlspecialchars($_POST['coupon_code']) : ''; ?>">
                     <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="submit">Apply Coupon</button>
                   </form>

                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">
                                        
                                        <?php
$subtotal = 0;
$discount_applied = 0;
$coupon_code_applied = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
    $cl = isset($_SESSION['id_cl']) ? intval($_SESSION['id_cl']) : null;
    if ($cl) {
        $coupon_code = trim($_POST['coupon_code']);
        // Check if couponcode table exists by trying to query it
        $sql_coupon = "SELECT * FROM couponcode WHERE code = ?";
        $stmt_coupon = mysqli_prepare($db, $sql_coupon);
        
        if ($stmt_coupon === false) {
            // Table might not exist or SQL error occurred
            $error_msg = mysqli_error($db);
            // Check if it's a table doesn't exist error
            if (strpos($error_msg, "doesn't exist") !== false || strpos($error_msg, "Unknown table") !== false) {
                echo "<script>alert('Coupon system is not available. Please contact administrator.');</script>";
            } else {
                // For other SQL errors, log but don't expose to user
                error_log("Coupon query error: " . $error_msg);
                echo "<script>alert('Error processing coupon code. Please try again.');</script>";
            }
        } else {
            mysqli_stmt_bind_param($stmt_coupon, "s", $coupon_code);
            mysqli_stmt_execute($stmt_coupon);
            $res = mysqli_stmt_get_result($stmt_coupon);
            
            if($res && mysqli_num_rows($res) > 0) {
                $coupon = mysqli_fetch_assoc($res);
                $discount_applied = floatval($coupon['discount_percent'] ?? 0);
                $coupon_code_applied = $coupon_code;
            } else {
                echo "<script>alert('Invalid coupon code');</script>";
            }
            mysqli_stmt_close($stmt_coupon);
        }
    } else {
        header("Location: login");
        exit;
    }
}

// Calculate subtotal
$sql_subtotal = "SELECT SUM(prix_pr * qte) AS subtotal FROM sous_card sc JOIN card c ON sc.id_pa = c.id_pa JOIN produit p ON sc.id_pr = p.id_pr WHERE c.id_cl = ?";
$stmt_subtotal = mysqli_prepare($db, $sql_subtotal);
mysqli_stmt_bind_param($stmt_subtotal, "i", $id_cl);
mysqli_stmt_execute($stmt_subtotal);
$result_subtotal = mysqli_stmt_get_result($stmt_subtotal);
$row_subtotal = mysqli_fetch_assoc($result_subtotal);
$original_subtotal = floatval($row_subtotal['subtotal'] ?? 0);
$subtotal = $original_subtotal;

// Apply discount if coupon was applied
if ($discount_applied > 0) {
    $discount_amount = ($original_subtotal * $discount_applied) / 100;
    $subtotal = $original_subtotal - $discount_amount;
}

echo number_format($subtotal, 2) . " DH";
if ($discount_applied > 0) {
    echo ' <small class="text-success">(' . $discount_applied . '% discount applied)</small>';
}
mysqli_stmt_close($stmt_subtotal);
?>

                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0">Flat rate: 20.00 DH</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4"><?php echo number_format($subtotal + 20, 2) . " DH"; ?></p>
                            </div>
                            <a href="chackout" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" >
                                Proceed Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->


        <!-- Footer Start -->
       <!-- Footer Start -->
        
        <script>
        // Additional quantity handler for cart page
        jQuery(document).ready(function($) {
            // Quantity update handler
            $(document).on('click', '.quantity .btn-plus, .quantity .btn-minus', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var button = $(this);
                var row = button.closest('tr');
                var quantityInput = row.find('.quantity_input');
                var oldValue = parseInt(quantityInput.val()) || 1;
                var id_sdpa = button.data('id') || quantityInput.data('id');
                
                var newVal;
                if (button.hasClass('btn-plus')) {
                    newVal = oldValue + 1;
                } else if (button.hasClass('btn-minus')) {
                    newVal = oldValue > 1 ? oldValue - 1 : 1;
                } else {
                    return;
                }
                
                // Update UI immediately
                quantityInput.val(newVal);
                var prixpr = parseFloat(row.find('.price_pr').val());
                
                if (!isNaN(prixpr)) {
                    var totalPrice = prixpr * newVal;
                    row.find('.total_price').text(totalPrice.toFixed(2) + " DH");
                }
                
                // Update database via AJAX
                if (id_sdpa) {
                    $.ajax({
                        url: 'php/update_cart.php',
                        method: 'POST',
                        data: {
                            id_sdpa: id_sdpa,
                            qte: newVal
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Reload page to update subtotal
                                location.reload();
                            } else {
                                alert('Error updating quantity: ' + (response.message || 'Unknown error'));
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error updating quantity. Please try again.');
                            location.reload();
                        }
                    });
                }
            });
            
            // Delete item handler
            $(document).on('click', '.delete_item', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to remove this item from your cart?')) {
                    return;
                }
                
                var button = $(this);
                var id_sdpa = button.data('id');
                var row = button.closest('tr');
                
                if (id_sdpa) {
                    $.ajax({
                        url: 'php/delete_item.php',
                        method: 'POST',
                        data: {
                            id: id_sdpa
                        },
                        success: function(response) {
                            if (response.indexOf('successfully') !== -1) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    location.reload();
                                });
                            } else {
                                alert('Error deleting item: ' + response);
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error deleting item. Please try again.');
                            location.reload();
                        }
                    });
                }
            });
            
            // Coupon form handler
            $('#coupon-form').on('submit', function(e) {
                e.preventDefault();
                // Form will submit normally to apply coupon via POST
                // This allows the PHP code to process it
                this.submit();
            });
        });
        </script>
       
        <?php
include 'footer.php';
  ?>