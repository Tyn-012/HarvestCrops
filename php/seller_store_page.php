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
    <title>HarvestCrops - Seller Store Page</title>
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
        <div class="section mx-5 mb-3">
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
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-6 mb-1">
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="seller_store_page.php">Shop</a>
                    </div>
                    <div class="col-md-6">
                        <form action="seller_store_page.php" method="get">
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
    <div class="bg-F5BD22">
        <div class="container">
            <div class="section">
                <div class="row p-4">
                    <div class="col-md-2">
                        <span>
                            <img class ="card-img card-img-ds mb-3" src="../images/plots.jpg" class="opacity-100">
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
                        <input type="submit" name="category_filter" value="Filter">
                    </form>


                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php
                            // Enable error reporting for MySQL
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                            $userid = $_SESSION['user_id'];
                            $categoryFilter = '';
                            $search_filter = '';

                            // Check if there's a search term
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search_term = "%" . mysqli_real_escape_string($connect, $_GET['search']) . "%"; // For LIKE query
                                $search_filter = "AND p.Product_Name LIKE ?";
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

                            // Main product query with prepared statement
                            $cnt_qry = "
                                SELECT p.Product_ID, p.Product_Name, p.product_price, c.Category_Name, pi.image_url
                                FROM product p
                                JOIN category c ON p.Category_ID = c.Category_ID
                                LEFT JOIN product_images pi ON p.Product_ID = pi.Product_ID
                                WHERE p.User_ID = ? $categoryFilter $search_filter
                            ";

                            // Debugging: Print the query for verification
                            $stmt = $connect->prepare($cnt_qry);
                            if ($stmt === false) {
                                // If prepare failed, output an error message
                                die('MySQL prepare error: ' . $connect->error);
                            }

                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $stmt->bind_param('is', $userid, $search_term);
                            } else {
                                $stmt->bind_param('i', $userid);
                            }

                            $stmt->execute();
                            $cnt_rslt = $stmt->get_result();

                            if ($cnt_rslt->num_rows > 0) {
                                while ($row = $cnt_rslt->fetch_assoc()) {
                                    $productid = $row['Product_ID'];
                                    $product_name = htmlspecialchars($row['Product_Name']);
                                    $product_price = htmlspecialchars($row['product_price']);
                                    $category_name = htmlspecialchars($row['Category_Name']);
                                    $img_url = htmlspecialchars($row['image_url']); // Ensure the URL is safe

                                    echo '
                                    <div class="col-md-5">
                                        <div class="card card-ds m-2">
                                            <img class="card-img card-img-ds opacity-100" src="' . $img_url . '" width="80px" height="260px">
                                            <div class="card-img-overlay">
                                                <h4 class="card-title text-light pt-2">' . $product_name . '</h4> 
                                                <p class="card-text text-light pt-3">PHP ' . $product_price . ' - each</p>
                                                <p class="text-light">Category: ' . $category_name . '</p>
                                                <div class="row d-flex justify-content-start mt-4">
                                                    <div class="col-md-3">
                                                        <a class="btn update_button-ds text-light fw-bolder mb-2" href="update_product.php?product_id=' . $productid . '">Update</a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <form action="components/delete_product.php" method="post">
                                                            <input type="hidden" name="product_id" value="' . $productid . '">
                                                            <button class="btn text-light fw-bolder" type="submit" name="delete_product">Delete</button>
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
                            <li class="nav-item"><a href="farmer_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
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