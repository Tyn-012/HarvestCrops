<?php
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}
include 'components/user_details.php';

$userid = $_SESSION['user_id'];

$get_stats_qry = "SELECT COUNT(*) AS total_orders FROM order_details WHERE seller_id = ?";
$stmt = $connect->prepare($get_stats_qry);
$stmt->bind_param('i', $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $total_orders = $row['total_orders']; // The total number of orders for this seller
}

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
    <title>HarvestCrops - Seller Store Page</title>
</head>
<body class="bg-F0E5AF body-font">
    <nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section" >
                <div class="row d-flex justify-content-center align-items-center p-1" >
                    <div class="col-md-4 mt-2">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">                       
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3 c-cfe1b9" href="seller_store_page.php">Shop</a>
                        <a class="anc-page px-3" href="customer_support_page_vendor.php">Customer Support</a>
                        <a class="anc-page px-3" href="order_page.php">Orders</a>
                        <a class="anc-page px-3" href="inventory_page.php">Inventory</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div>
        <div class="container">
            <div class="section">
                <div class="row p-4">
                    <div class="col-md-2">
                        <span>
                            <img class ="card-img card-img-ds mb-3 shadow" src="../images/plots.jpg" class="opacity-100">
                        </span>
                    </div>
                    <div class="col-md-7 d-flex align-items-center">
                        <p><?php echo $farm_name . '<br>' . $name . '<br>' . $email_address . '<br>' . $mobile_number . '<br>' . $user_address; ?></p>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="product_listing_page.php" class="btn btn-sm bg-1e5915 c-e9ffff p-2 m-2 mb-5">Add Product</a>
                                <a id="stats" class="btn btn-sm bg-1e5915 c-e9ffff p-2 m-2 mb-5" href="graph_page.php">Statistics</a>
                                <script>
                                    // Get the total orders count from PHP
                                    var totalOrders = <?php echo $total_orders; ?>;

                                    // Get the statistics button
                                    var statsButton = document.getElementById('stats');

                                    // Disable the button if there are no orders
                                    if (totalOrders === 0) {
                                        statsButton.classList.add('disabled');
                                        statsButton.style.pointerEvents = 'none'; // Prevent clicking the button
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start my-4">
                    <form action="seller_store_page.php" method="get">
                        <div class="col-md-12 d-flex align-items-center">
                            <input class="p-1" id="search-input" name="search" type="text" placeholder="Search products or categories...">
                            <button type="submit" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="col-md-3">
                    <form action="seller_store_page.php" method="post">
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
                            include 'components/connect.php';

                            if (!isset($_SESSION['name'])) {
                                header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
                                exit();
                            }
                            include 'components/user_details.php';

                            // Enable error reporting for MySQL
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                            $userid = $_SESSION['user_id'];
                            $categoryFilter = '';
                            $search_filter = '';

                            // Pagination Variables
                            $products_per_page = 6; // Set the number of products to display per page
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL or default to 1
                            $offset = ($page - 1) * $products_per_page; // Calculate the offset for the query

                            // Check if there's a search term
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search_term = "%" . mysqli_real_escape_string($connect, $_GET['search']) . "%"; // For LIKE query
                                $search_filter = "AND (p.Product_Name LIKE ? OR c.Category_Name LIKE ?)";
                            }

                            // Category filter handling
                            if (isset($_POST['category_filter'])) {
                                // Collect selected categories
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
                                    $categoryFilter = "AND c.Category_Name IN ('" . implode("','", $categories) . "')";
                                }
                            }

                            // Main product query with prepared statement (Pagination added)
                            $cnt_qry = "
                                SELECT p.Product_ID, p.Product_Name, p.product_price, c.Category_Name, pi.image_url
                                FROM product p
                                JOIN category c ON p.Category_ID = c.Category_ID
                                LEFT JOIN product_images pi ON p.Product_ID = pi.Product_ID
                                WHERE p.User_ID = ? $categoryFilter $search_filter
                                LIMIT $offset, $products_per_page
                            ";

                            $stmt = $connect->prepare($cnt_qry);
                            if ($stmt === false) {
                                die('MySQL prepare error: ' . $connect->error);
                            }

                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $stmt->bind_param('iss', $userid, $search_term, $search_term);
                            } else {
                                $stmt->bind_param('i', $userid);
                            }

                            $stmt->execute();
                            $cnt_rslt = $stmt->get_result();

                            // Display products
                            if ($cnt_rslt->num_rows > 0) {
                                while ($row = $cnt_rslt->fetch_assoc()) {
                                    $productid = $row['Product_ID'];
                                    $product_name = htmlspecialchars($row['Product_Name']);
                                    $product_price = htmlspecialchars($row['product_price']);
                                    $category_name = htmlspecialchars($row['Category_Name']);
                                    $img_url = htmlspecialchars($row['image_url']); // Ensure the URL is safe

                                    echo '
                                    <div class="col-md-4 rounded">
                                        <div class="card card-ds rounded m-2 shadow-lg bg-84B68F">
                                            <img class="card-img opacity-100" src="' . $img_url . '" width="50px" height="200px">
                                            <div class="bg-84B68F text-dark text-center mt-2">
                                                <h4>' . $product_name . '</h4> 
                                                <p class="mx-2 text-start">PHP ' . $product_price . ' per kilo</p>
                                                <p class="mx-2 text-start">Category: ' . $category_name . '</p>
                                                <div class="row d-flex justify-content-center mt-4">
                                                    <div class="col-md-12 d-flex justify-content-center mb-3">
                                                        <a class="btn update_button-ds bg-1e5915 c-e9ffff fw-bolder mx-2" href="update_product.php?product_id=' . $productid . '">Update</a>
                                                        <form action="components/delete_product.php" method="post">
                                                            <input type="hidden" name="product_id" value="' . $productid . '">
                                                            <button class="btn bg-1e5915 c-e9ffff fw-bolder mx-2" type="submit" name="delete_product">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>                                                 
                                            </div>                     
                                        </div>
                                    </div>';
                                }
                            } else {
                                echo "No products found.";
                            }

                            // Calculate total pages for pagination
                            $total_query = "
                                SELECT COUNT(*) as total_products 
                                FROM product p
                                JOIN category c ON p.Category_ID = c.Category_ID
                                WHERE p.User_ID = ? $categoryFilter $search_filter
                            ";

                            $total_stmt = $connect->prepare($total_query);
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $total_stmt->bind_param('iss', $userid, $search_term, $search_term);
                            } else {
                                $total_stmt->bind_param('i', $userid);
                            }

                            $total_stmt->execute();
                            $total_result = $total_stmt->get_result();
                            $total_row = $total_result->fetch_assoc();
                            $total_products = $total_row['total_products'];
                            $total_pages = ceil($total_products / $products_per_page); // Total pages

                            // Display pagination
                            if ($total_pages > 1) {
                                echo '<nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mt-4">';
                                 
                                // Previous page link
                                if ($page > 1) {
                                    echo '<li class="page-item"><a class="page-link bg-1e5915 c-e9ffff" href="?page=' . ($page - 1) . '">Previous</a></li>';
                                }

                                // Page number links
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                            <a class="page-link bg-1e5915 c-e9ffff" href="?page=' . $i . '">' . $i . '</a>
                                        </li>';
                                }

                                // Next page link
                                if ($page < $total_pages) {
                                    echo '<li class="page-item"><a class="page-link bg-1e5915 c-e9ffff" href="?page=' . ($page + 1) . '">Next</a></li>';
                                }

                                echo '</ul>
                                </nav>';
                            }
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
                        <li class="nav-item nav-a"><a href="farmer_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item nav-a"><a href="customer_support_page_vendor.php" class="nav-link px-2 text-body-secondary">FAQs</a></li>
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
