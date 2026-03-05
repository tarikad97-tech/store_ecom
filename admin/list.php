<?php

// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

require_once 'server/config.php';

// if(!isset($_SESSION['admin_id'])){
//     header("Location: login.php");
//     exit();
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel - Products</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
</head>
<body id="page-top">

<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="flex-grow-1 d-flex flex-column">

        <!-- Navbar -->
        <?php include 'navbar.php'; ?>

        <!-- Main Content -->
        <div id="content" class="d-flex justify-content-center align-items-start p-4">
            <div class="w-100" style="max-width:1200px;">

                <h3 class="mb-4 text-center">🛒 Product List</h3>

                <div class="table-responsive bg-white rounded shadow-sm p-3">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $products = $db->query("SELECT * FROM products ORDER BY created_at DESC");
                        while($prod = $products->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $prod['id']; ?></td>
                                <td><?php echo htmlspecialchars($prod['name']); ?></td>
                                <td>$<?php echo number_format($prod['price'],2); ?></td>
                                <td><?php echo $prod['stock']; ?></td>
                                <td><?php echo $prod['created_at']; ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $prod['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="server/delete_product.php?id=<?php echo $prod['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>