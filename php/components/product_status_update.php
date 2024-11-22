<?php
session_start();
include 'connect.php';

if (isset($_POST['accept'])) {
    $order_id = $_POST['order_id'];
    
    // Debugging echo (you can remove this later)
    echo $order_id;

    // Query to update the order status to 'processing'
    $order_status_query = "UPDATE order_details 
                           SET order_status = 'processing' 
                           WHERE order_ID = '$order_id'";

    // Query to insert the status change into the order_status_history table
    $history_status_qry = "INSERT INTO order_status_history (Order_ID, status) 
                           VALUES ('$order_id', 'processing')";

    // Execute the order status update
    if (mysqli_query($connect, $order_status_query)) {
        // Execute the history update
        if (mysqli_query($connect, $history_status_qry)) {
            // Success message and redirection
            echo "<script language='JavaScript'>
                    alert('Order Accepted');
                    window.location = '../order_page.php';
                  </script>";
        } else {
            echo "Error inserting into order_status_history: " . mysqli_error($connect);
        }
    } else {
        echo "Error updating order status: " . mysqli_error($connect);
    }

} else if (isset($_POST['complete'])) {
    $order_id = $_POST['order_id'];
    
    // Debugging echo (you can remove this later)
    echo $order_id;

    // Query to update the order status to 'completed'
    $order_status_query = "UPDATE order_details 
                           SET order_status = 'completed' 
                           WHERE order_ID = '$order_id'";

    // Query to insert the status change into the order_status_history table
    $history_status_qry = "INSERT INTO order_status_history (Order_ID, status) 
                           VALUES ('$order_id', 'completed')";

    // Execute the order status update
    if (mysqli_query($connect, $order_status_query)) {
        // Execute the history update
        if (mysqli_query($connect, $history_status_qry)) {
            // Success message and redirection
            echo "<script language='JavaScript'>
                    alert('Order Completed');
                    window.location = '../order_page.php';
                  </script>";
        } else {
            echo "Error inserting into order_status_history: " . mysqli_error($connect);
        }
    } else {
        echo "Error updating order status: " . mysqli_error($connect);
    }
}
?>
