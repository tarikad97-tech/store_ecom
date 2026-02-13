<?php
include 'navbar.php';

// Check if user is logged in
if(!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])){
    header("Location: login.php");
    exit;
}

$id_cl = intval($_SESSION['id_cl']);
$user_data = null;
$error_message = '';
$success_message = '';

// Fetch user data from database
$sql = "SELECT c.nom_cl, c.tel, c.adresse, l.email 
        FROM client c 
        INNER JOIN log l ON c.id_cl = l.id_cl 
        WHERE c.id_cl = ?";
$stmt = mysqli_prepare($db, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_cl);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// If user data not found, redirect to login
if (!$user_data) {
    header("Location: login.php");
    exit;
}

// Check for success/error messages from update
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success_message = 'Profile updated successfully!';
}
if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
}
?>
        <!-- Navbar End -->

        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Profile</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Profile</li>
            </ol>
        </div>
        <!-- Single Page Header End -->

        <!-- Profile Form Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow">
                            <div class="card-body p-5">
                                <h2 class="card-title text-center mb-4">My Profile</h2>
                                
                                <?php if ($success_message): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $success_message; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($error_message): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $error_message; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="php/profile.php">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($user_data['nom_cl'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="<?php echo htmlspecialchars($user_data['tel'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" 
                                               value="<?php echo htmlspecialchars($user_data['adresse'] ?? ''); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Form End -->
            
        <!-- Footer Start -->
        <?php
include 'footer.php';
?>