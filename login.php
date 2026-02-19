  <?php
include 'navbar.php';
  ?>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
     
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Login</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
        <!-- Login Form Start -->
        <div class="container my-5">
            <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4">Login</h2>
                    <form method="POST" action="php/login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="text-center mt-3">Don't have an account? <a href="register">Register here</a></p>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Login Form End -->
<!-- create here form login -->


        <!-- Footer Start -->
       <!-- Footer Start -->
        <?php
include 'footer.php';
  ?>