<?php
include 'components/user_details.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.min.js" rel="script"></script>
    <title>HarvestCrops</title>
</head>
<body>
    <nav class="nav pt-5 mx-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-1">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (Circle).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-11">
                        <h4>HarvestCrops: Agri-Marketplace Connecting Farmers, Retailers, and Traders Seamlessly</h4>
                        <p>"Harvest Your Potential: Connect, Trade, and Thrive in Our Agricultural Marketplace!"</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="section mx-5 mb-3">
            <div class="col-md-12 d-flex justify-content-end">
                <a href="#" class="fa-regular fa-envelope icon-ds p-1 m-1"></a>
                <a href="#" class="fa-solid fa-globe icon-ds p-1 m-1"></a>
                <a href="#" class="fa-regular fa-bell icon-ds p-1 m-1"></a>
                <form action="components/logout.php" method="post">
                    <button class="btn btn-sm text-md fw-bold m-1" type="submit">Logout</button>
                </form>
                <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
            </div>
        </div>
    </div>
    <nav class="p-3 bg-success">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="seller_store_page.php">Shop</a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-dark"></div>
    <div id="seller-store-account-bg">
        <div class="container">
            <div class="section">
                <div class="row p-4">
                    <div class="col-md-2">
                        <span>
                            <img class ="card-img card-img-ds" src="../images/plots.jpg" class="opacity-100">
                        </span>
                    </div>
                    <div class="col-md-7 d-flex align-items-center">
                        <p><?php echo $farm_name . '<br>' .
                        $name . '<br>' .
                        $email_address . '<br>' . 
                        $mobile_number . '<br>' . 
                        $user_address; ?>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="#" id="icon-heart" class="fa-regular fa-heart p-2 m-2"></a>
                                <a href="#" id="icon-flag" class="fa-regular fa-flag p-2 m-2 mb-5"></a>
                                <a href="product_listing_page.php" class="btn btn-sm bg-dark text-light p-2 m-2 mb-5">Add Product</a>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning"></div>
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end p-4">
                </div>
                <hr>
                <div class="col-md-3">
                    <div class="col-md-12 d-flex justify-content-center">
                    <h4>Search Filter</h4>
                    </div>
                    <form action="" method="post" target="store_page.html">
                        <label class="me-2 py-2"><input type="checkbox" id="terms_conditions" name="terms_conditions" value="Agree" class="me-2">Fruits</label><br>
                        <label class="me-2 py-2"><input type="checkbox" id="terms_conditions" name="terms_conditions" value="Agree" class="me-2">Vegetables</label><br>
                        <label class="me-2 py-2"><input type="checkbox" id="terms_conditions" name="terms_conditions" value="Agree" class="me-2">Grains</label><br>
                        <label class="me-2 py-2"><input type="checkbox" id="terms_conditions" name="terms_conditions" value="Agree" class="me-2">Root Crops</label><br>
                        <hr>
                        <input type="submit" value="Filter">
                    </form>

                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php
                            $userid = $_SESSION['user_id'];
                            $cnt_qry = "SELECT * FROM product WHERE User_ID = $userid";
                            $cnt_rslt = mysqli_query($connect, $cnt_qry);
                            if (mysqli_num_rows($cnt_rslt) > 0) {
                                while ($row = mysqli_fetch_assoc($cnt_rslt)) {
                                    $productid = $row['Product_ID'];
                                    $product_name = $row['Product_Name'];
                                    $product_price = $row['product_price'];

                                    $getproduct_info_qry = "SELECT * FROM product_images WHERE Product_ID = ?";
                                    $stmt = $connect->prepare($getproduct_info_qry);
                                    $stmt->bind_param('s', $productid);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                        
                                    if ($row = $result->fetch_assoc()) {
                                        $img_url = $row['image_url'];
                                    }

                                    echo' 
                                    <div class="col-md-4">
                                        <div class="card card-ds m-2">
                                            <img class ="card-img card-img-ds opacity-75" src="' . $img_url . '" width="50px" height="200px">
                                            <div class="card-img-overlay">
                                                <h4 class="card-title text-dark pt-2">' . $product_name . '</h4> 
                                                <p class="card-text text-dark pt-3">PHP' . $product_price . ' - each</p>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a class = "btn text-light fw-bolder text-decoration-none" href="update_product.php?product_id='. $productid . '">Update</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <form action = "components/delete_product.php" method="post">
                                                            <input type="hidden" name="product_id" value="' . htmlspecialchars($productid) . '">
                                                            <button class = "btn text-light fw-bolder" type="submit" name="delete_product">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>                                                
                                            </div>                     
                                        </div>
                                    </div>
                                    ';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning acc_add_tab-margin-top"></div>
    <footer class="nav bg-success">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                            <li class="nav-item"><a href="farmer_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="customer_support_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-4 d-flex justify-content-center align-items-center">
                        <span> &copy; Copyrights. All rights reserved to Leila Aliyah J. Manalo | John Lloyd B. Dela Cruz | Vince Wackie Espera
                            | Jezreel Anne C. Jaynos</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>