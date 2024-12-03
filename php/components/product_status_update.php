<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['accept']) || isset($_POST['complete'])) {
    $order_id = $_POST['order_id'];


    // Set order status based on action
    if (isset($_POST['accept'])) {
        $new_status = 'processing';
        $status_check_message = 'Order is Already in Process';
        $status_change_message = 'Order Accepted';
    } else if (isset($_POST['complete'])) {
        $new_status = 'completed';
        $status_check_message = 'Order is Already Completed';
        $status_change_message = 'Order Completed';
    }

    // Get the current status of the order
    $get_order_status_qry = "SELECT order_status FROM order_details WHERE order_ID = ?";
    $stmt = $connect->prepare($get_order_status_qry);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $order_status = $row['order_status'];
    } else {
        echo "Order not found.";
        exit;
    }

    // Check if the order is already completed
    if ($order_status == 'completed') {
        echo "<script language='JavaScript'>
                alert('Cannot Update Completed Orders.');
                window.location = '../order_page.php';
              </script>";
        exit;
    }

    // Check if the order is already in the requested status
    if ($order_status == $new_status) {
        echo "<script language='JavaScript'>
                alert('$status_check_message');
                window.location = '../order_page.php';
              </script>";
        exit;
    }

    // Update the order status in the 'order_details' table
    $order_status_query = "UPDATE order_details SET order_status = ? WHERE order_ID = ?";
    $stmt = $connect->prepare($order_status_query);
    $stmt->bind_param('si', $new_status, $order_id);

    // Execute the order status update
    if ($stmt->execute()) {
        // Insert the status change into the 'order_status_history' table
        $history_status_qry = "INSERT INTO order_status_history (Order_ID, status) VALUES (?, ?)";
        $stmt = $connect->prepare($history_status_qry);
        $stmt->bind_param('is', $order_id, $new_status);

        // Execute the history update
        if ($stmt->execute()) {
            // Success message and redirection
            echo "<script language='JavaScript'>
                    alert('$status_change_message');
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
