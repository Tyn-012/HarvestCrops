<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['cancel'])) {
    // Get the order ID from the form
    $order_id = $_POST['order_id'];

    // Begin transaction to ensure cascading delete is performed safely
    $connect->begin_transaction();

    try {
        // First, delete from order_item table
        $delete_order_item_query = "DELETE FROM order_item WHERE order_ID = ?";
        $stmt = $connect->prepare($delete_order_item_query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        
        // Then, delete from order_details table
        $delete_order_details_query = "DELETE FROM order_details WHERE order_ID = ?";
        $stmt = $connect->prepare($delete_order_details_query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        
        // Commit transaction if both deletions succeed
        $connect->commit();
        
        // Redirect to the orders page or show success message
        echo "<script language='JavaScript'>
                alert('Order has been successfully canceled.');
                window.location = '../cart_page.php';
              </script>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $connect->rollback();
        
        // Show error message
        echo "Error canceling order: " . $e->getMessage();
    }
}

if (isset($_POST['modify'])) {
    // Get the order ID and new quantity from the form
    $order_id = $_POST['order_id'];  // This should already be passed from the form
    $new_quantity = $_POST['new_quantity'];  // New quantity input by user

    // Validate new quantity
    if (!is_numeric($new_quantity) || $new_quantity <= 0) {
        echo "<script language='JavaScript'>
        alert('The quantity must be a positive number greater than 0.');
        window.location = '../cart_page.php';
        </script>";
        exit;
    }

    // Begin transaction for order update
    $connect->begin_transaction();

    try {
        // Update the order_item table with the new quantity
        $update_order_item_query = "UPDATE order_item SET quantity = ? WHERE order_ID = ?";
        $stmt = $connect->prepare($update_order_item_query);
        $stmt->bind_param('ii', $new_quantity, $order_id);
        $stmt->execute();

        // Fetch the product ID related to the order item
        $get_product_info_query = "SELECT product_ID FROM order_item WHERE order_ID = ?";
        $stmt = $connect->prepare($get_product_info_query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product_row = $result->fetch_assoc();
        
        $product_id = $product_row['product_ID'];

        // Get the product price
        $get_product_price_query = "SELECT Product_Price FROM product WHERE Product_ID = ?";
        $stmt = $connect->prepare($get_product_price_query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $product_price_result = $stmt->get_result();
        $product_price_row = $product_price_result->fetch_assoc();
        $product_price = $product_price_row['Product_Price'];;

        // Update the order_details table with the new total price
        $update_order_details_query = "UPDATE order_details SET total = ? WHERE order_ID = ?";
        $stmt = $connect->prepare($update_order_details_query);
        $stmt->bind_param('di', $new_quantity, $order_id);
        $stmt->execute();

        // Commit transaction if both updates succeed
        $connect->commit();

        // Redirect to orders page
        echo "<script language='JavaScript'>
                alert('Order has been successfully updated.');
                window.location = '../cart_page.php';
              </script>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $connect->rollback();
        
        // Show error message
        echo "Error updating order: " . $e->getMessage();
    }
}
?>





