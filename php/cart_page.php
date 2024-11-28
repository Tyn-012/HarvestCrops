<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Assuming the user is logged in and has a session
$User_ID = $_SESSION['user_id']; // Get the logged-in user ID

// SQL Query to fetch orders for the logged-in user
$getuser_orders_qry = "SELECT * FROM order_details WHERE User_ID = ? ORDER BY created_at ASC";

// Prepare and bind the query
$stmt = $connect->prepare($getuser_orders_qry);
$stmt->bind_param('i', $User_ID); // 'i' for integer (user_ID is expected to be an integer)
$stmt->execute();

// Get the result
$order_result = $stmt->get_result();
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
    <title>HarvestCrops - Cart Page</title>
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
                        <a class="anc-page px-3" href="cart_page.php">Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mb-5 mt-2">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section">
                        <div class="row bg-warning mb-2 ps-2">
                            <div class="col-md-1 d-flex justify-content-center">
                                <p>Order ID</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Product</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Total</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Status</p>
                            </div>
                            <div class="col-md-5 d-flex justify-content-center">
                                <p>Action</p>
                            </div>
                        </div>

                        <?php

                        // Check if any orders are returned
                        if ($order_result->num_rows > 0) {
                            // Loop through the orders and fetch details
                            while ($order_row = $order_result->fetch_assoc()) {
                                $order_id = $order_row['order_ID'];
                                $total = $order_row['total'];
                                $order_status = $order_row['order_status'];
                                $created_at = $order_row['created_at'];
                                $modified_at = $order_row['modified_at'];
                                
                                // Fetch products related to this order
                                $getproduct_id_qry = "SELECT * FROM order_item WHERE order_ID = ? ORDER BY created_at ASC";
                                $stmt = $connect->prepare($getproduct_id_qry);
                                $stmt->bind_param('i', $order_id);
                                $stmt->execute();
                                $product_result = $stmt->get_result();

                                // Get the product details for each order item
                                while ($product_row = $product_result->fetch_assoc()) {
                                    $product_id = $product_row['product_ID'];

                                    
                                    // Get product image
                                    $getproduct_info_qry = "SELECT * FROM product_images WHERE Product_ID = ?";
                                    $stmt = $connect->prepare($getproduct_info_qry);
                                    $stmt->bind_param('s', $product_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($row = $result->fetch_assoc()) {
                                        $img_url = $row['image_url'];
                                    }

                                    // Fetch the product name
                                    $getproduct_name_qry = "SELECT * FROM product WHERE Product_ID = ? ORDER BY created_at ASC";
                                    $stmt = $connect->prepare($getproduct_name_qry);
                                    $stmt->bind_param('i', $product_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($row = $result->fetch_assoc()) {
                                        $product_name = $row['Product_Name'];
                                        $product_price = $row['product_price'];
                                    }

                                    // Format the date as you prefer
                                    $created_at_formatted = date("Y-m-d H:i:s", strtotime($created_at));
                                    $modified_at_formatted = date("Y-m-d H:i:s", strtotime($modified_at));

                                    // Output the order details
                                    echo '
                                    <div class="row d-flex align-items-center mb-2 ps-2 border">
                                        <div class="col-md-1 d-flex justify-content-center p-4">' . htmlspecialchars($order_id) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($product_name) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($total) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($order_status) . '</div>
                                        <div class="col-md-5 d-flex justify-content-center p-4">
                                            <span>
                                                <form action="components/order_cart_update.php" method="post">
                                                    <input type="hidden" name="order_id" value="' . htmlspecialchars($order_id) . '">
                                                    <button name="cancel" class="btn btn-sm bg-dark text-light mx-2">Cancel</button>
                                                    <a class="btn btn-sm text-light bg-dark text-decoration-none" href="update_order.php?product_id='. $product_id . 
                                                    ' &order_id='. $order_id . '&img_url=' 
                                                    . urlencode($img_url) . '&product_name=' . urlencode($product_name) . '&product_price=' 
                                                    . urlencode($product_price) . '">Update</a>
                                                </form>
                                            </span>
                                        </div>
                                    </div>';
                                }
                            }
                        } else {
                            // If no orders are found, display a message
                            echo '<p>No orders found.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
