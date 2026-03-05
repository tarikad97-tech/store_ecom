<?php


// include('server/config.php');
require_once 'server/config.php';

// if(!isset($_SESSION['admin_id'])){
//     header("Location: login.php");
//     exit();
// }

?>

<body id="page-top">

<div id="wrapper">
    <?php
include('navbar.php');
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Admin Panel</div>
</a>

<hr class="sidebar-divider my-0">

<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link" href="products.php">
        <i class="fas fa-box"></i>
        <span>Products</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="orders.php">
        <i class="fas fa-shopping-cart"></i>
        <span>Orders</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="messages.php">
        <i class="fas fa-envelope"></i>
        <span>Messages</span>
    </a>
</li>

</ul>
<!-- End Sidebar -->

<div id="content-wrapper" class="d-flex flex-column">

<div id="content">

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

</div>

</div>

</div>

</div>

<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

<script src="vendor/chart.js/Chart.min.js"></script>

</body>
</html>