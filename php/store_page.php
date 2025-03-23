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
<body class="bg-F0E5AF body-font">
    <nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section">
                <div class="row d-flex justify-content-center align-items-center p-1">
                    <div class="col-md-4 mt-2">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">                       
                        <a class="anc-page px-3" href="vendee_account_page.php">My Account</a>
                        <a class="anc-page px-3 c-cfe1b9" href="store_page.php">Shop</a>
                        <a class="anc-page px-3" href="customer_support_page_vendee.php">Customer Support</a>
                        <a class="anc-page px-3" href="cart_page.php">Cart</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <span>
        <img src="../images/vendor_img/vendor_bg.jpg" class="opacity-100" height="450px" width="100%"> 
    </span>
    <div class="p-2 bg-1E5915"></div>
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start my-4">
                    <form action="store_page.php" method="get">
                        <div class="col-md-12 d-flex align-items-center">
                            <input class="p-1" id="search-input" name="search" type="text" placeholder="Search products or categories...">
                            <button type="submit" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></button>
                        </div>
                    </form>
                </div>
                <hr>
                <!-- Category Filters (Checkboxes) -->
                <div class="col-md-3">
                    <form action="store_page.php" method="get">
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
                        <input class="btn bg-1e5915 c-e9ffff" type="submit" name="category_filter" value="Filter">
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php
                            // Default search filter for products and categories
                            $search_filter = '';

                            // Check if there's a search term
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search_term = mysqli_real_escape_string($connect, $_GET['search']);
                                // Modify the search query to also include category names
                                $search_filter = "AND product.Product_Name LIKE '%$search_term%' OR category.Category_Name LIKE '%$search_term%'";
                            }

                            // Handling Category Filters (checkboxes)
                            $categoryFilter = '';
                            if (isset($_GET['category_filter'])) {
                                $categories = [];
                                if (isset($_GET['fruits'])) {
                                    $categories[] = 'Fruits';
                                }
                                if (isset($_GET['vegetables'])) {
                                    $categories[] = 'Vegetables';
                                }
                                if (isset($_GET['grains'])) {
                                    $categories[] = 'Grains';
                                }
                                if (isset($_GET['rootcrops'])) {
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
                                    <div class="col-md-4 rounded">
                                        <div class="card card-ds rounded m-2 shadow-lg bg-84B68F">
                                            <img class="card-img opacity-100" width="50px" height="200px" src="' . $img_url . '" alt="' . $product_name . '">
                                            <div class="bg-84B68F text-dark text-center mt-2">
                                                <h4>' . $product_name . '</h4> 
                                                <p class="mx-2 text-start">PHP ' . $product_price . ' per kilo</p>
                                                <p class="mx-2 text-start">Category: ' . $category_name . '</p>
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <a class="btn update_button-ds bg-1e5915 c-e9ffff fw-bolder mb-2 mx-2" href="product_page.php?product_id='. $productid . '&img_url=' 
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

                            // Pagination Buttons
                            echo '<nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mt-4">';
                                    
                            // Previous Page
                            if ($page > 1) {
                                $prev_page = $page - 1;
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $prev_page . '">Previous</a></li>';
                            }

                            // Page Numbers
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }

                            // Next Page
                            if ($page < $total_pages) {
                                $next_page = $page + 1;
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $next_page . '">Next</a></li>';
                            }

                            echo '</ul></nav>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-1E5915 acc_add_tab-margin-top"></div>
    <footer class="nav bg-84B68F">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center">
                        <li class="nav-item nav-a"><a href="vendee_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item nav-a"><a href="customer_support_page_vendee.php" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        </ul>
                        <hr>
                        <span class="d-flex justify-content-center fw-bold"> &copy; 2024 AspireProgrez - All Rights Reserved</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
