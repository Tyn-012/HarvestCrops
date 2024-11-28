<?php
include 'components/connect.php';


if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

include 'components/user_details.php';

// Ensure the product details are passed via URL parameters
if (isset($_GET['product_id']) && isset($_GET['img_url']) && isset($_GET['product_name']) && isset($_GET['product_price'])) {
    $product_id = $_GET['product_id'];
    $img_url = $_GET['img_url'];
    $product_name = $_GET['product_name'];
    $product_price = $_GET['product_price'];

    $_SESSION['product_id'] = $_GET['product_id'];
    $_SESSION['img_url'] = $_GET['img_url'];
    $_SESSION['product_name'] = $_GET['product_name'];
    $_SESSION['product_price'] = $_GET['product_price'];

        $getuser_product_qry = "SELECT * FROM product WHERE Product_ID = ? ";
        $stmt = $connect->prepare($getuser_product_qry);
        $stmt->bind_param('s', $product_id );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $Inventory_ID = $row['Inventory_ID'];
            $user_id = $row['User_ID'];
            $_SESSION['seller_id'] = $row['User_ID'];

        }
        $_SESSION['Inventory_ID'] = $Inventory_ID;

        $getuser_qry = "SELECT * FROM user WHERE User_ID = ? ";
        $stmt = $connect->prepare($getuser_qry);
        $stmt->bind_param('s', $user_id );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $name = $row['User_FirstName'] .' '. $row['User_MiddleName'] .' '. $row['User_LastName'];
            $email = $row['User_EmailAddress'];
            $mobile = $row['User_MobileNumber'];
        }

        $getuser_inventory_qry = "SELECT * FROM inventory WHERE Inventory_ID = ? ";
        $stmt = $connect->prepare($getuser_inventory_qry);
        $stmt->bind_param('i', $Inventory_ID );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $quantity = $row['quantity'];
            $_SESSION['product_quantity'] = $quantity;
        }

} else {
    // Handle case where product details are not available
    echo "Product details not found.";
    exit;
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
    <title>HarvestCrops - Product Page</title>
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
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <a class="anc-page px-3" href="vendor_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="store_page.php">Shop</a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-dark mb-4"></div>
        <div class="container border p-4 mb-4">
            <div class="section">
                <div class="row">
                <span class="bg-397F35 p-2"></span>
                    <div class="col-md-6">
                        <div class="card">
                            <img src="<?php echo $img_url; ?>" class="card-img rounded" alt="Product Image" height="500px" width="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="container border mt-4">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="d-flex justify-content-center mt-4"><?php echo $product_name; ?></h3>
                                        <hr>
                                        <p><strong>Seller:</strong> <?php echo $name; ?></p>
                                        <p><strong>Phone Number:</strong> <?php echo $mobile; ?></p>
                                        <p><strong>Email:</strong> <?php echo $email; ?></p>
                                        <p><strong>Price:</strong> <?php echo $product_price; ?></p>
                                        <form action="../php/components/product_order.php" method="post"> 
                                            <div class="col-md-6 mb-4">
                                                <div class="row">
                                                    <div class="col-md-2 mx-2">
                                                        <label class="m-2">Quantity:</label>
                                                    </div>
                                                    <div class="col-md-4 mx-4">
                                                        <input type="text" name="order_quantity" class="form-control mb-2"
                                                        placeholder="0" required autofocus>
                                                    </div>
                                                    <div class="col-md-6"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-end">
                                                    <button class="btn btn-md bg-secondary rounded m-4 button-ds" type="submit"name="submit">Order Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="bg-397F35 p-2"></span>
                </div>    
            </div>
        </div>
        <div class="p-2 bg-warning"></div>
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