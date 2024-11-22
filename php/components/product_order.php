<?php
include 'user_details.php';
$user_id = $_SESSION['user_id'];
$product_id = $_SESSION['product_id'];
$product_name = $_SESSION['product_name'];
$product_price = $_SESSION['product_price'];
$product_quantity = $_SESSION['product_quantity']; // Current quantity of product in stock
$seller_id = $_SESSION['seller_id'];
$inventory_id = $_SESSION['Inventory_ID'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the quantity from POST
    $quantity = $_POST['order_quantity'];

    // Validate that quantity is a positive integer
    if (!is_numeric($quantity) || $quantity <= 0) {
        echo "Error: Quantity must be a positive number greater than 0.";
        exit;
    }

    // Validate that user is not ordering more than available quantity (stock check)
    if ($quantity > $product_quantity) {
        echo "Not enough stock available. You can only order up to " . $product_quantity . " items.";
        exit;
    }

    // Insert into order_details table
    $order_det_query = "INSERT INTO order_details (User_ID, total, order_status, seller_id) 
                        VALUES (?, ?, 'pending', ?)";

    // Use prepared statement to insert into order_details
    if ($stmt = mysqli_prepare($connect, $order_det_query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'idi', $user_id, $quantity, $seller_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Get the last inserted order_id from order_details table
            $order_id = mysqli_insert_id($connect); // Get the auto-incremented order_id

            // Insert into order_item table with the $order_id
            $order_item_query = "INSERT INTO order_item (Order_ID, Product_ID, quantity) 
                                 VALUES (?, ?, ?)";

            // Prepare the query for order_item
            if ($stmt2 = mysqli_prepare($connect, $order_item_query)) {
                // Bind parameters for order_item
                mysqli_stmt_bind_param($stmt2, 'iii', $order_id, $product_id, $quantity);

                // Execute the order_item query
                if (mysqli_stmt_execute($stmt2)) {
                    // Success message and redirect (Post-Redirect-Get pattern)
                    echo "<script language='JavaScript'>
                            alert('Order details and order items have been successfully added.');
                            window.location = '../store_page.php';
                          </script>";
                    exit; // Ensure no further code execution
                } else {
                    echo "Error inserting order item: " . mysqli_error($connect);
                }

                // Close statement for order_item
                mysqli_stmt_close($stmt2);
            } else {
                echo "Error preparing order item query: " . mysqli_error($connect);
            }
        } else {
            echo "Error inserting order details: " . mysqli_error($connect);
        }

        // Close statement for order_details
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing order details query: " . mysqli_error($connect);
    }
}
?>
