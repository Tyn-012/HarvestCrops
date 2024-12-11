<?php
include 'components/connect.php';
if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}
include 'components/user_details.php';
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
    <title>HarvestCrops - Buyer Store Page</title>
</head>
<body class="bg-cfe1b9">
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
        <div class="section mx-5 mb-1">
            <div class="col-md-12 d-flex justify-content-end">
                <form action="components/logout.php" method="post">
                    <button class="btn btn-sm text-md fw-bold m-1" type="submit">Logout</button>
                </form>
                <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
            </div>
        </div>
    </div>
    <nav class="p-3 bg-397F35">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-6">
                        <a class="anc-page px-3" href="vendor_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="store_page.php">Shop</a>
                    </div>
                    <div class="col-md-6">
                        <form action="store_page.php" method="get">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="p-1" id="search-input" name="search" type="text" placeholder="Search..">
                                <button type="submit" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <span>
        <img src="../images/vendor_img/vendor_bg.jpg" class="opacity-100" height="600px" width="100%"> 
    </span>
    <div class="p-2 bg-warning"></div>
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end p-4">

                </div>
                <hr>
                <div class="col-md-3">
                <form action="store_page.php" method="post">
                        <label class="me-2 py-2">
                            <input type="checkbox" name="fruits" value="fruits" class="me-2">Fruits
                        </label><br>
                        <label class="me-2 py-2">
                            <input type="checkbox" name="vegetables" value="vegetables" class="me-2">Vegetables
                        </label><br>
                        <label class="me-2 py-2">
                            <input type="checkbox" name="grains" value="grains" class="me-2">Grains
                        </label><br>
                        <label class="me-2 py-2">
                            <input type="checkbox" name="rootcrops" value="rootcrops" class="me-2">Root Crops
                        </label><br>
                        <hr>
                        <input type="submit" name="category_filter" value="Filter">
                    </form>


                </div>
                <div class="col-md-9">
                    <div class="row">
                    <?php
                        session_start();
                        include 'components/user_details.php';

                        // Default search filter
                        $search_filter = '';

                        // Check if there's a search term
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search_term = mysqli_real_escape_string($connect, $_GET['search']);
                            $search_filter = "AND product.Product_Name LIKE '%$search_term%'";
                        }

                        // Handling Category Filters
                        $categoryFilter = '';
                        if (isset($_POST['category_filter'])) {
                            $categories = [];
                            if (isset($_POST['fruits'])) {
                                $categories[] = 'Fruits';
                            }
                            if (isset($_POST['vegetables'])) {
                                $categories[] = 'Vegetables';
                            }
                            if (isset($_POST['grains'])) {
                                $categories[] = 'Grains';
                            }
                            if (isset($_POST['rootcrops'])) {
                                $categories[] = 'RootCrops';
                            }
                            if (!empty($categories)) {
                                $categoryFilter = "AND category.Category_Name IN ('" . implode("','", $categories) . "')";
                            }
                        }

                        // Pagination and products query
                        $products_per_page = 6;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $products_per_page;
                        $cnt_qry = "
                        SELECT product.Product_ID, product.Product_Name, product.product_price, category.Category_Name 
                        FROM product
                        JOIN category ON product.Category_ID = category.Category_ID
                        WHERE 1=1 $categoryFilter $search_filter
                        LIMIT $offset, $products_per_page";

                        $cnt_rslt = mysqli_query($connect, $cnt_qry);

                        if (!$cnt_rslt) {
                            die('Error: ' . mysqli_error($connect)); // Error handling
                        }

                        if (mysqli_num_rows($cnt_rslt) > 0) {
                            while ($row = mysqli_fetch_assoc($cnt_rslt)) {
                                $productid = $row['Product_ID'];
                                $product_name = $row['Product_Name'];
                                $product_price = $row['product_price'];
                                $category_name = $row['Category_Name'];

                                // Get product image
                                $getproduct_info_qry = "SELECT * FROM product_images WHERE Product_ID = ?";
                                $stmt = $connect->prepare($getproduct_info_qry);
                                $stmt->bind_param('i', $productid);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                $img_url = 'default_image.jpg'; // Set default image if none found
                                if ($image_row = $result->fetch_assoc()) {
                                    $img_url = $image_row['image_url']; // Get the image URL
                                }

                                // Display product
                                echo ' 
                                <div class="col-md-5">
                                    <div class="card card-ds m-2">
                                        <img class="card-img card-img-ds opacity-100" width="80px" height="260px" src="' . $img_url . '" alt="' . $product_name . '">
                                        <div class="card-img-overlay">
                                                <h4 class="card-title text-light pt-2">' . $product_name . '</h4> 
                                                <p class="card-text text-light pt-3">PHP ' . $product_price . ' - each</p>
                                                <p class="text-light">Category: ' . $category_name . '</p>
                                            <div class="col-md-4 d-flex justify-content-start mt-4">
                                                <a class="btn update_button-ds text-light fw-bolder mb-2" href="product_page.php?product_id='. $productid . '&img_url=' 
                                                . urlencode($img_url) . '&product_name=' . urlencode($product_name) . '&product_price=' 
                                                . urlencode($product_price) . '">Order</a>
                                            </div> 
                                        </div>                     
                                    </div>
                                </div>';
                            }
                        }
                        // Pagination Logic
                        $total_query = "SELECT COUNT(*) as total_products FROM product JOIN category ON product.Category_ID = category.Category_ID WHERE 1=1 $categoryFilter $search_filter";
                        $total_result = mysqli_query($connect, $total_query);
                        $total_row = mysqli_fetch_assoc($total_result);
                        $total_products = $total_row['total_products'];
                        $total_pages = ceil($total_products / $products_per_page);

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
                            echo '<a href="store_page.php" class="text-decoration-none text-dark mt-2"><i class="fa-solid fa-backward"></i> back</a>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning acc_add_tab-margin-top"></div>
    <footer class="nav bg-397F35">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                            <li class="nav-item"><a href="vendor_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="customer_support_page.php" class="nav-link px-2 text-body-secondary">FAQs</a></li>
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

