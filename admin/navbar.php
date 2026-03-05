<?php
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_img = $_SESSION['admin_img'] ?? 'default.png';
$alerts = $_SESSION['alerts'] ?? [];
$messages = $_SESSION['messages'] ?? [];
?>

<nav class="navbar navbar-expand navbar-light bg-white shadow-sm mb-4">
    <button id="sidebarToggleTop" class="btn btn-primary d-md-none rounded-circle mr-3">
        <i class="fas fa-bars"></i>
    </button>

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 w-50">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Alerts -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-bell fa-fw"></i>
                <?php if(count($alerts) > 0): ?>
                    <span class="badge badge-danger badge-counter"><?php echo count($alerts); ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header">Alerts Center</h6>
                <?php foreach($alerts as $alert): ?>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500"><?php echo $alert['created_at'] ?? ''; ?></div>
                            <span class="font-weight-bold"><?php echo $alert['message'] ?? ''; ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
                <a class="dropdown-item text-center small text-gray-500" href="alerts.php">Show All Alerts</a>
            </div>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-envelope fa-fw"></i>
                <?php if(count($messages) > 0): ?>
                    <span class="badge badge-danger badge-counter"><?php echo count($messages); ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header">Message Center</h6>
                <?php foreach($messages as $msg): ?>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="uploads/<?php echo htmlspecialchars($msg['sender_img'] ?? 'default.png'); ?>" width="40" height="40">
                        </div>
                        <div>
                            <div class="text-truncate"><?php echo htmlspecialchars($msg['content'] ?? ''); ?></div>
                            <div class="small text-gray-500"><?php echo htmlspecialchars($msg['sender_name'] ?? ''); ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
                <a class="dropdown-item text-center small text-gray-500" href="messages.php">Read More Messages</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Admin -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($admin_name); ?></span>
                <img class="img-profile rounded-circle" src="uploads/<?php echo htmlspecialchars($admin_img); ?>" width="35" height="35">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
                <a class="dropdown-item" href="settings.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
            </div>
        </li>

    </ul>
</nav>