<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}


// Assuming the user is logged in and has a session
$seller_id = $_SESSION['user_id']; // Get the logged-in user ID

// SQL Query to fetch orders for the logged-in user
$getuser_products = "SELECT * FROM product WHERE User_ID = ? ORDER BY created_at DESC";

// Prepare and bind the query
$stmt = $connect->prepare($getuser_products);
$stmt->bind_param('i', $seller_id); // 'i' for integer (user_ID is expected to be an integer)
$stmt->execute();
// Get the result
$inventory_result = $stmt->get_result();

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
    <title>HarvestCrops - Inventory Page</title>
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
                        <a class="anc-page px-3" href="seller_store_page.php">Shop</a>
                        <a class="anc-page px-3" href="customer_support_page_vendor.php">Customer Support</a>
                        <a class="anc-page px-3" href="order_page.php">Orders</a>
                        <a class="anc-page px-3 c-cfe1b9" href="inventory_page.php">Inventory</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div class="container-fluid mb-5 mt-2">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section">
                        <div class="row hide_header pt-2 py-1 mb-2 ps-2  justify-content-center text-light bg-1E5915 rounded shadow">
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Product Image</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Product ID</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Product Name</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Quantity</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Shelf Life</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Harvest Date</p>
                            </div>
                        </div>
                        <?php
                            // Check if any orders are returned
                            if ($inventory_result->num_rows > 0) {
                                // Loop through the orders and fetch details
                                while ($row = $inventory_result->fetch_assoc()) {
                                    $product_id = $row['Product_ID'];
                                    $product_time = $row['shelf_life']  . ' ' . $row['shelf_life_unit'];
                                    $product_name = $row['Product_Name'];
                                    $inventory_id = $row['Inventory_ID'];

                                    $getproduct_data = "SELECT * FROM inventory WHERE Inventory_ID = ? ORDER BY created_at DESC";
                                    // Prepare and bind the query
                                    $stmt = $connect->prepare($getproduct_data);
                                    $stmt->bind_param('i', $inventory_id); // 'i' for integer (user_ID is expected to be an integer)
                                    $stmt->execute();
                                    // Get the result
                                    $product_data = $stmt->get_result();
                                    if ($row = $product_data->fetch_assoc()) {
                                        $harvest_date = $row['harvest_date'];
                                        $quantity = $row["quantity"];
                                    }

                                    $getproduct_img = "SELECT * FROM product_images WHERE Product_ID = ? ORDER BY Product_ID DESC";
                                    // Prepare and bind the query
                                    $stmt = $connect->prepare($getproduct_img);
                                    $stmt->bind_param('i', $product_id);
                                    $stmt->execute();
                                    // Get the result
                                    $product_image = $stmt->get_result();
                                    if ($row = $product_image->fetch_assoc()) {
                                        $product_img = $row['image_url'];
                                    }

                                    // Output the order details
                                    echo '<div class="desktop_display">';
                                    echo '
                                    <div class="row d-flex justify-content-center align-items-center mb-2 ps-2 bg-cfe1b9 rounded shadow">
                                        <div class="col-md-2 d-flex justify-content-center p-4">
                                        <img class="rounded-4 shadow" src="' . $product_img . '" alt="' . $product_name . '" style="width: 100px; height: 100px;">
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($product_id) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($product_name) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($quantity) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($product_time) . '</div>
                                        <div class="col-md-2 d-flex justify-content-center p-4">' . htmlspecialchars($harvest_date) . '</div>
                                    </div>';
                                    echo '</div>';
                                    // Output the order details
                                    echo '<div class="med_mobile_display">';
                                    echo '
                                    <div class="row d-flex align-items-center mb-2 ps-2 rounded-3 bg-cfe1b9 p-3 m-3 shadow">
                                    
                                        <div class="col-md-7 d-flex justify-content-center mb-3">' .   
                                            'ID: '. htmlspecialchars($product_id) . '<br>' .
                                            'Name: '. htmlspecialchars($product_name) . '<br>' .
                                            'Quantity: '. htmlspecialchars($quantity) . '<br>' .
                                            'Shelf Life: '. htmlspecialchars($product_time) . '<br>' .
                                            'Harvest Date: '. htmlspecialchars($harvest_date) . '<br>' .
                                        '</div>' .
                                    '</div>';
                                    echo '</div>';
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
