<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Refactor into a reusable function
function updateUserStatus($user_id, $new_status, $connect) {
    // Get the user's Status_ID
    $getuser_id_qry = "SELECT Status_ID FROM user WHERE User_ID = ? ";
    $stmt = $connect->prepare($getuser_id_qry);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $user_stat_id = $row['Status_ID'];
    } else {
        return false; // User not found
    }

    // Get the current status name
    $getstatus_name_qry = "SELECT Status_Name FROM user_status WHERE Status_ID = ?";
    $status_stmt = $connect->prepare($getstatus_name_qry);
    $status_stmt->bind_param('i', $user_stat_id);
    $status_stmt->execute();
    $result = $status_stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $status_name = $row['Status_Name'];
    }

    // If status is already the same as the new status
    if ($status_name == $new_status) {
        echo "<script language='JavaScript'>
                alert('Account is Already $new_status');
                window.location = '../admin_page.php';
              </script>";
        return false;
    }

    // Update the user status
    $status_query = "UPDATE user_status SET Status_Name = ? WHERE Status_ID = ?";
    $status_stmt = $connect->prepare($status_query);
    $status_stmt->bind_param('si', $new_status, $user_stat_id);
    if ($status_stmt->execute()) {
        echo "<script language='JavaScript'>
                alert('Account is now $new_status');
                window.location = '../admin_page.php';
              </script>";
        return true;
    } else {
        echo "Error updating status: " . mysqli_error($connect);
        return false;
    }
}

// Call function for deactivating or activating
if (isset($_POST['deactivate']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    updateUserStatus($user_id, 'deactivated', $connect);
    $user_query = "UPDATE user SET verified = '0' WHERE User_ID = '$user_id'";
    if (mysqli_query($connect, $user_query)) {
        echo "User deactivated successfully.";
    } else {
        echo "Error deactivating user: " . mysqli_error($connect);
    }
} else if (isset($_POST['activate']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    updateUserStatus($user_id, 'active', $connect);
    $user_query = "UPDATE user SET verified = '1' WHERE User_ID = '$user_id'";
    if (mysqli_query($connect, $user_query)) {
        echo "User activated successfully.";
    } else {
        echo "Error activating user: " . mysqli_error($connect);
    }
}

?>


