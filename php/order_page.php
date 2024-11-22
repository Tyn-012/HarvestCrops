<?php
session_start();
include 'components/connect.php';

// Assuming the user is logged in and has a session
$seller_id = $_SESSION['user_id']; // Get the logged-in user ID

// SQL Query to fetch orders for the logged-in user
$getuser_orders_qry = "SELECT * FROM order_details WHERE seller_id = ? ORDER BY created_at DESC";

// Prepare and bind the query
$stmt = $connect->prepare($getuser_orders_qry);
$stmt->bind_param('i', $seller_id); // 'i' for integer (user_ID is expected to be an integer)
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
    <title>HarvestCrops</title>
</head>
<body>
    <nav class="nav pt-5 mx-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-1">
                        <span id="logo_part">
                            <img src="../images/plots.jpg" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-11">
                        <h4>HarvestCrops: Agri-Marketplace Connecting Farmers, Retailers, and Traders Seamlessly</h4>
                        <p>Harvest Your Potential: Connect, Trade, and Thrive in Our Agricultural Marketplace!</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="section mx-5 mb-3">
            <div class="col-md-12 d-flex justify-content-end">
                <h4>Orders</h4>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning"></div>
    <nav class="p-3 bg-success">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-8 d-flex">
                        <p class="anc-page px-2"><?php echo $_SESSION['name']; ?></p>
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="seller_store_page.php">Shop</a>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
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
                            <div class="col-md-3 d-flex justify-content-center">
                                <p>Total</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center">
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
                            while ($row = $order_result->fetch_assoc()) {
                                $order_id = $row['order_ID'];
                                $total = $row['total'];
                                $order_status = $row['order_status'];
                                $created_at = $row['created_at'];
                                $modified_at = $row['modified_at'];

                                // Format the date as you prefer
                                $created_at_formatted = date("Y-m-d H:i:s", strtotime($created_at));
                                $modified_at_formatted = date("Y-m-d H:i:s", strtotime($modified_at));

                                // Output the order details
                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 border">
                                    <div class="col-md-1 d-flex justify-content-center p-4">' . htmlspecialchars($order_id) . '</div>
                                    <div class="col-md-3 d-flex justify-content-center p-4">' . htmlspecialchars($total) . '</div>
                                    <div class="col-md-3 d-flex justify-content-center p-4">' . htmlspecialchars($order_status) . '</div>
                                    <div class="col-md-5 d-flex justify-content-center p-4">
                                        <span>
                                            <form action="components/product_status_update.php" method="post">
                                                <input type="hidden" name="order_id" value="' . htmlspecialchars($order_id) . '">
                                                <button name="accept" class="btn btn-sm bg-dark text-light mx-2">Accept</button>
                                                <button name="complete" class="btn btn-sm bg-dark text-light mx-2">Complete</button>
                                            </form>
                                        </span>
                                    </div>
                                </div>';
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
