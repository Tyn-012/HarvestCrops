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
        <div class="container p-4 mb-4 mt-4">
            <div class="section">
                <div class="row">
                <span class="bg-1E5915 p-2"></span>
                    <div class="col-md-6">
                        <div class="card prod_img_rs_size">
                            <img src="<?php echo $img_url; ?>" class="card-img rounded" alt="Product Image" height="500px" width="150px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="container mt-4">
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
                                                 <div class="row d-flex align-items-center">
                                                    <div class="col-md-4">
                                                        <label class="fw-bold mb-2">Quantity:</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="order_quantity" class="form-control"
                                                        placeholder="0" required autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button class="btn btn-md rounded m-4 button-ds" type="submit"name="submit">Order Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="bg-1E5915 p-2"></span>
                </div>    
            </div>
        </div>
        <div class="p-2 bg-1E5915 mt-5"></div>
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
                            <span class="d-flex justify-content-center fw-bold"> &copy; 2024 AspireProgrez - All Rights Reserved</span> <!-- EDIT -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>  
</body>
</html>