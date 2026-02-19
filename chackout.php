<?php
include 'navbar.php';
?>

        <!-- Navbar End -->


        <!-- Modal Search Start -->
  
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index">Home</a></li>
                <li class="breadcrumb-item"><a href="cart">Cart</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <!-- Single Page Header End -->

        <?php
// Check if user is logged in
if(!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])){
    header("Location: login");
    exit;
}

$id_cl = intval($_SESSION['id_cl']);

// Get user data
$user_data = null;
$sql_user = "SELECT c.nom_cl, c.tel, c.adresse, l.email 
              FROM client c 
              INNER JOIN log l ON c.id_cl = l.id_cl 
              WHERE c.id_cl = ?";
$stmt_user = mysqli_prepare($db, $sql_user);
if ($stmt_user) {
    mysqli_stmt_bind_param($stmt_user, "i", $id_cl);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    $user_data = mysqli_fetch_assoc($result_user);
    mysqli_stmt_close($stmt_user);
}

// Get cart data
$cart_items = [];
$subtotal = 0;
$shipping = 20; // Fixed shipping cost

$sql_cart = "SELECT * FROM card WHERE id_cl = ?";
$stmt_cart = mysqli_prepare($db, $sql_cart);
mysqli_stmt_bind_param($stmt_cart, "i", $id_cl);
mysqli_stmt_execute($stmt_cart);
$result_cart = mysqli_stmt_get_result($stmt_cart);
$row_cart = mysqli_fetch_assoc($result_cart);
mysqli_stmt_close($stmt_cart);

if($row_cart) {
    $id_pa = intval($row_cart['id_pa']);
    $sql_items = "SELECT sous_card.id_sdpa, sous_card.id_pa, sous_card.id_pr, sous_card.qte, produit.nom_pr, produit.prix_pr, produit.imgpr_pr 
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
}

$total = $subtotal + $shipping;

// Split name into first and last name
$name_parts = explode(' ', $user_data['nom_cl'] ?? '');
$first_name = $name_parts[0] ?? '';
$last_name = isset($name_parts[1]) ? implode(' ', array_slice($name_parts, 1)) : '';
?>

        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if(empty($cart_items)): ?>
                    <div class="alert alert-warning text-center">
                        <h4>Your cart is empty!</h4>
                        <p>Please add items to your cart before checkout.</p>
                        <a href="shop" class="btn btn-primary">Continue Shopping</a>
                    </div>
                <?php else: ?>
                <h1 class="mb-4">Billing details</h1>
                <form action="php/process_order.php" method="POST">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">First Name<sup>*</sup></label>
                                        <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Last Name<sup>*</sup></label>
                                        <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Company Name</label>
                                <input type="text" class="form-control" name="company_name">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Address <sup>*</sup></label>
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user_data['adresse'] ?? ''); ?>" placeholder="House Number Street Name" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Town/City<sup>*</sup></label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Country<sup>*</sup></label>
                                <input type="text" class="form-control" name="country" value="Morocco" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Postcode/Zip</label>
                                <input type="text" class="form-control" name="postcode">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Mobile<sup>*</sup></label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($user_data['tel'] ?? ''); ?>" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Email Address<sup>*</sup></label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Order Notes (Optional)</label>
                                <textarea name="order_notes" class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cart_items as $item): ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="uploads/<?php echo htmlspecialchars($item['imgpr_pr']); ?>" class="img-fluid " style="width: 90px; height: 90px;" alt="<?php echo htmlspecialchars($item['nom_pr']); ?>">
                                                </div>
                                            </th>
                                            <td class="py-5"><?php echo htmlspecialchars($item['nom_pr']); ?></td>
                                            <td class="py-5"><?php echo number_format($item['prix_pr'], 2); ?> DH</td>
                                            <td class="py-5"><?php echo $item['qte']; ?></td>
                                            <td class="py-5"><?php echo number_format($item['prix_pr'] * $item['qte'], 2); ?> DH</td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <th scope="row"></th>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark py-3">Subtotal</p>
                                            </td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark"><?php echo number_format($subtotal, 2); ?> DH</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark py-4">Shipping</p>
                                            </td>
                                            <td colspan="3" class="py-5">
                                                <div class="form-check text-start">
                                                    <input type="radio" class="form-check-input bg-primary border-0" id="Shipping-1" name="shipping" value="free" checked>
                                                    <label class="form-check-label" for="Shipping-1">Free Shipping</label>
                                                </div>
                                                <div class="form-check text-start">
                                                    <input type="radio" class="form-check-input bg-primary border-0" id="Shipping-2" name="shipping" value="flat">
                                                    <label class="form-check-label" for="Shipping-2">Flat rate: <?php echo number_format($shipping, 2); ?> DH</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3 fw-bold">TOTAL</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark fw-bold" id="total-amount"><?php echo number_format($total, 2); ?> DH</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                           
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="Payments-1" name="payment_method" value="check" required>
                                        <label class="form-check-label" for="Payments-1">Payments CMI Maroc</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1" name="payment_method" value="cash_on_delivery" required>
                                        <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                               
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- Checkout Page End -->

        <script>
        // Update total when shipping changes
        document.querySelectorAll('input[name="shipping"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var subtotal = <?php echo $subtotal; ?>;
                var shipping = this.value === 'flat' ? <?php echo $shipping; ?> : 0;
                var total = subtotal + shipping;
                document.getElementById('total-amount').textContent = total.toFixed(2) + ' DH';
            });
        });
        </script>

        <!-- Footer Start -->
        <?php
include 'footer.php';
?>
