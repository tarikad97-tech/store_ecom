  <?php
include 'navbar.php';
  ?>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
// CREATE TABLE card (
//   id_pa INT NOT NULL AUTO_INCREMENT,
//   id_cl INT NOT NULL,
//   PRIMARY KEY (id_pa),
//   KEY idx_card_client (id_cl),
//   CONSTRAINT fk_card_client
//     FOREIGN KEY (id_cl) REFERENCES client(id_cl)
//     ON UPDATE CASCADE
//     ON DELETE CASCADE
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

// -- =========================
// -- TABLE: sous_card (lignes panier)
// -- =========================
// CREATE TABLE sous_card (
//   id_sdpa INT NOT NULL AUTO_INCREMENT,
//   id_pa INT NOT NULL,
//   id_pr INT NOT NULL,
//   PRIMARY KEY (id_sdpa),
//   KEY idx_souscard_card (id_pa),
//   KEY idx_souscard_produit (id_pr),
//   CONSTRAINT fk_souscard_card
//     FOREIGN KEY (id_pa) REFERENCES card(id_pa)
//     ON UPDATE CASCADE
//     ON DELETE CASCADE,
//   CONSTRAINT fk_souscard_produit
//     FOREIGN KEY (id_pr) REFERENCES produit(id_pr)
//     ON UPDATE CASCADE
//     ON DELETE RESTRICT
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                            if(!isset($_SESSION['id_cl']) || empty($_SESSION['id_cl'])){
                               header("Location: login.php");
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
                                  $sql2 = "SELECT * FROM sous_card,produit WHERE id_pa = ? AND sous_card.id_pr = produit.id_pr";
                                  $stmt2 = mysqli_prepare($db, $sql2);
                                  mysqli_stmt_bind_param($stmt2, "i", $id_pa);
                                  mysqli_stmt_execute($stmt2);
                                  $result2 = mysqli_stmt_get_result($stmt2);
                              } else {
                                  $result2 = false;
                              }
                                if($result2) {
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
                                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 quantity_input" value="1" min="1" max="10">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total_price"><?php echo $row2['prix_pr']; ?> DH</p>
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
                                }
                            }

?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">$96.00</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0">Flat rate: $3.00</p>
                                    </div>
                                </div>
                                <p class="mb-0 text-end">Shipping to Ukraine.</p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">$99.00</p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
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
            $(document).on('click', '.quantity .btn-plus, .quantity .btn-minus', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var button = $(this);
                var row = button.closest('tr');
                var quantityInput = row.find('.quantity_input');
                var oldValue = parseFloat(quantityInput.val()) || 1;
                
                var newVal;
                if (button.hasClass('btn-plus')) {
                    newVal = oldValue + 1;
                } else if (button.hasClass('btn-minus')) {
                    newVal = oldValue > 1 ? oldValue - 1 : 1;
                } else {
                    return;
                }
                
                quantityInput.val(newVal);
                var prixpr = parseFloat(row.find('.price_pr').val());
                
                if (!isNaN(prixpr)) {
                    var totalPrice = prixpr * newVal;
                    row.find('.total_price').text(totalPrice.toFixed(2) + " DH");
                }
            });
        });
        </script>
        
        <?php
include 'footer.php';
  ?>