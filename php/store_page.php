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
                        <a class="anc-page px-3" href="vendor_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="store_page.php">Shop</a>
                        <a class="anc-page px-3" href="cart_page.php">Cart</a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <span>
        <img src="../images/farm.jpg" class="opacity-100" height="400px" width="100%"> 
    </span>
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
                            // Assuming $connect is your database connection
                            $display_count = 0;

                            // Set the number of products to display per page
                            $products_per_page = 6;

                            // Get the current page number from the URL (default to 1)
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                            // Calculate the OFFSET for the SQL query
                            $offset = ($page - 1) * $products_per_page;

                            // Fetch products for the current page
                            $cnt_qry = "SELECT * FROM product LIMIT $products_per_page OFFSET $offset";
                            $cnt_rslt = mysqli_query($connect, $cnt_qry);

                            // Display products
                            if (mysqli_num_rows($cnt_rslt) > 0) {
                                while ($row = mysqli_fetch_assoc($cnt_rslt)) {
                                    $productid = $row['Product_ID'];
                                    $product_name = $row['Product_Name'];
                                    $product_price = $row['product_price'];
                                    // Get product image
                                    $getproduct_info_qry = "SELECT * FROM product_images WHERE Product_ID = ?";
                                    $stmt = $connect->prepare($getproduct_info_qry);
                                    $stmt->bind_param('s', $productid);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($row = $result->fetch_assoc()) {
                                        $img_url = $row['image_url'];
                                    }

                                    // Display product details
                                    echo ' 
                                    <div class="col-md-4">
                                        <div class="card card-ds m-2">
                                            <img class="card-img card-img-ds opacity-75" src="' . $img_url . '" width="50px" height="200px">
                                            <div class="card-img-overlay">
                                                <h4 class="card-title text-dark pt-2">' . $product_name . '</h4> 
                                                <p class="card-text text-dark pt-3">' . $product_price . '</p>
                                            <div class="col-md-4">
                                                <a class="btn text-light fw-bolder text-decoration-none" href="product_page.php?product_id='. $productid . '&img_url=' 
                                                . urlencode($img_url) . '&product_name=' . urlencode($product_name) . '&product_price=' 
                                                . urlencode($product_price) . '">Order</a>
                                            </div> 
                                            </div>                     
                                        </div>
                                    </div>
                                    ';
                                }
                            }

                            // Calculate the total number of products
                            $total_query = "SELECT COUNT(*) as total_products FROM product";
                            $total_result = mysqli_query($connect, $total_query);
                            $total_row = mysqli_fetch_assoc($total_result);
                            $total_products = $total_row['total_products'];

                            // Calculate the total number of pages
                            $total_pages = ceil($total_products / $products_per_page);

                            // Display the "Next" button if there are more products
                            if ($page < $total_pages) {
                                $next_page = $page + 1;
                                echo '
                                <div class="section">
                                    <div class="col-md-12">
                                        <a href="?page=' . $next_page . '" class="btn btn-md btn-primary m-3">Next</a>   
                                    </div>
                                </div>'; 
                            } else {
                                echo '<button class="btn btn-secondary mt-3" disabled>No more products</button>';
                                echo '<a href="javascript:history.back();" class="text-decoration-none text-dark mt-2"><i class="fa-solid fa-backward"></i> back</a>';
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
                            <li class="nav-item"><a href="vendor_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
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