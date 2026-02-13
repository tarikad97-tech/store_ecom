<?php
include 'navbar.php';

// Check if user is logged in
if(!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])){
    header("Location: login.php");
    exit;
}

$total = isset($_GET['total']) ? floatval($_GET['total']) : 0;
$payment_method = isset($_GET['method']) ? htmlspecialchars($_GET['method']) : '';
?>

        <!-- Navbar End -->

        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Order Success</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Order Success</li>
            </ol>
        </div>
        <!-- Single Page Header End -->

        <!-- Order Success Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow text-center">
                            <div class="card-body p-5">
                                <div class="mb-4">
                                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                                </div>
                                <h2 class="card-title mb-4 text-success">Order Placed Successfully!</h2>
                                <p class="mb-4">Thank you for your order. Your order has been received and will be processed shortly.</p>
                                
                                <?php if($total > 0): ?>
                                <div class="alert alert-info">
                                    <h5>Order Details</h5>
                                    <p class="mb-2"><strong>Total Amount:</strong> <?php echo number_format($total, 2); ?> DH</p>
                                    <?php if($payment_method): ?>
                                    <p class="mb-0"><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $payment_method)); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="mt-4">
                                    <a href="shop.php" class="btn btn-primary me-2">Continue Shopping</a>
                                    <a href="index.php" class="btn btn-outline-primary">Go to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order Success End -->

        <!-- Footer Start -->
        <?php
include 'footer.php';
?>

