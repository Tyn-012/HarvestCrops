<?php
// Include user details to get user-specific data
include 'user_details.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}
// Retrieve product details from session
$user_id = $_SESSION['user_id'];
$product_id = $_SESSION['product_id'];
$product_name = $_SESSION['product_name'];
$product_price = $_SESSION['product_price'];
$product_quantity = $_SESSION['product_quantity']; // Current quantity of product in stock
$seller_id = $_SESSION['seller_id'];
$inventory_id = $_SESSION['Inventory_ID'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the quantity from the form input
    $quantity = $_POST['order_quantity'];

    // Validate that quantity is a positive integer
    if (!is_numeric($quantity) || $quantity <= 0) {
        echo "<script language='JavaScript'>
        alert('The quantity must be a positive number greater than 0.');
        window.location = '../store_page.php';
        </script>";
        exit;
    }

    // Validate that the user is not ordering more than the available quantity (stock check)
    if ($quantity > $product_quantity) {
        echo "<script language='JavaScript'>
        alert('Not enough stock available. You can only order up to " . $product_quantity . " items.');
        window.location = '../store_page.php';
        </script>";
        exit;
    }

    $getinventory_info_qry = "SELECT * FROM inventory WHERE Inventory_ID = ?";
    $stmt = $connect->prepare($getinventory_info_qry);
    $stmt->bind_param('s', $inventory_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $product_quantity = $row['quantity'];
    }
    
    // Insert order details into the order_details table
    $order_det_query = "INSERT INTO order_details (User_ID, total, order_status, seller_id) VALUES (?, ?, 'pending', ?)";

    // Prepare and execute the query for inserting into order_details
    if ($stmt = mysqli_prepare($connect, $order_det_query)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, 'idi', $user_id, $quantity, $seller_id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Get the last inserted order_id
            $order_id = mysqli_insert_id($connect);

            // Insert order item details into the order_item table
            $order_item_query = "INSERT INTO order_item (Order_ID, Product_ID, quantity) VALUES (?, ?, ?)";

            // Prepare the query for inserting order item
            if ($stmt2 = mysqli_prepare($connect, $order_item_query)) {
                // Bind parameters for the order item
                mysqli_stmt_bind_param($stmt2, 'iii', $order_id, $product_id, $quantity);

                // Execute the query for order item
                if (mysqli_stmt_execute($stmt2)) {
                    // Update or add the product to the shopping_cart table
                    $cart_query = "INSERT INTO shopping_cart (User_ID, Product_ID, quantity) 
                                   VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?";
                    
                    // Prepare and execute the cart query
                    if ($cart_stmt = mysqli_prepare($connect, $cart_query)) {
                        mysqli_stmt_bind_param($cart_stmt, 'iiii', $user_id, $product_id, $quantity, $quantity);
                        
                        // Execute cart query
                        if (mysqli_stmt_execute($cart_stmt)) {
                            // Success message and redirect (Post-Redirect-Get pattern)
                            echo "<script language='JavaScript'>
                                    alert('Order details and order items have been successfully added.');
                                    window.location = '../store_page.php';
                                  </script>";
                            exit; // Ensure no further code execution
                        } else {
                            echo "Error adding to shopping cart: " . mysqli_error($connect);
                        }
                        // Close cart statement
                        mysqli_stmt_close($cart_stmt);
                    } else {
                        echo "Error preparing cart query: " . mysqli_error($connect);
                    }
                } else {
                    echo "Error inserting order item: " . mysqli_error($connect);
                }

                // Close the statement for order_item
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
