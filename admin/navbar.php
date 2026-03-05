<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('server/config.php');

$admin_id = $_SESSION['admin_id'] ?? 1;

$query = $db->prepare("SELECT username, profile_img FROM admins WHERE id = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

$alerts = [];
$res1 = $db->query("SELECT * FROM alerts ORDER BY created_at DESC LIMIT 5");
while($row = $res1->fetch_assoc()){
    $alerts[] = $row;
}

$messages = [];
$res2 = $db->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
while($row = $res2->fetch_assoc()){
    $messages[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Dashboard</title>

<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

<link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
<i class="fa fa-bars"></i>
</button>

<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3">
<div class="input-group">
<input type="text" class="form-control bg-light border-0 small" placeholder="Search">
<div class="input-group-append">
<button class="btn btn-primary" type="button">
<i class="fas fa-search fa-sm"></i>
</button>
</div>
</div>
</form>

<ul class="navbar-nav ml-auto">

<!-- Alerts -->
<li class="nav-item dropdown no-arrow mx-1">

<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
<i class="fas fa-bell fa-fw"></i>
<span class="badge badge-danger badge-counter"><?php echo count($alerts); ?></span>
</a>

<div class="dropdown-list dropdown-menu dropdown-menu-right shadow">

<h6 class="dropdown-header">
Alerts Center
</h6>

<?php foreach($alerts as $alert): ?>

<a class="dropdown-item d-flex align-items-center" href="#">
<div class="mr-3">
<div class="icon-circle bg-primary">
<i class="fas fa-info-circle text-white"></i>
</div>
</div>

<div>
<div class="small text-gray-500">
<?php echo $alert['created_at']; ?>
</div>

<span class="font-weight-bold">
<?php echo $alert['message']; ?>
</span>

</div>
</a>

<?php endforeach; ?>

</div>

</li>

<!-- Messages -->
<li class="nav-item dropdown no-arrow mx-1">

<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
<i class="fas fa-envelope fa-fw"></i>
<span class="badge badge-danger badge-counter"><?php echo count($messages); ?></span>
</a>

<div class="dropdown-list dropdown-menu dropdown-menu-right shadow">

<h6 class="dropdown-header">
Message Center
</h6>

<?php foreach($messages as $msg): ?>

<a class="dropdown-item d-flex align-items-center" href="#">

<div class="dropdown-list-image mr-3">

<img class="rounded-circle"
src="uploads/<?php echo htmlspecialchars($msg['sender_img']); ?>">

</div>

<div>

<div class="text-truncate">
<?php echo htmlspecialchars($msg['content']); ?>
</div>

<div class="small text-gray-500">
<?php echo htmlspecialchars($msg['sender_name']); ?>
</div>

</div>

</a>

<?php endforeach; ?>

</div>

</li>

<div class="topbar-divider d-none d-sm-block"></div>

<!-- User -->

<li class="nav-item dropdown no-arrow">

<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">

<span class="mr-2 d-none d-lg-inline text-gray-600 small">
<?php echo htmlspecialchars($admin['username']); ?>
</span>

<img class="img-profile rounded-circle"
src="uploads/<?php echo htmlspecialchars($admin['profile_img']); ?>">


</a>

<div class="dropdown-menu dropdown-menu-right shadow">

<a class="dropdown-item" href="profile.php">
<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
Profile
</a>

<a class="dropdown-item" href="settings.php">
<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
Settings
</a>

<div class="dropdown-divider"></div>

<a class="dropdown-item" href="logout.php">
<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
Logout
</a>

</div>

</li>

</ul>

</nav>