<?php
// Start session if not already started
session_start();

// Include database connection
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Check if notice_id is provided
if (isset($_POST['notice_id'])) {
    $notice_id = $_POST['notice_id']; // Get the notice ID from the form

    // Prepare the DELETE query to remove the notice by ID
    $query = "DELETE FROM organization_notice WHERE Notice_ID = ?";
    $stmt = mysqli_prepare($connect, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, 'i', $notice_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the page where notices are listed after successful deletion
        header("Location: ../notices_page.php");
        exit(); // Make sure to stop script execution after redirect
    } else {
        // Display error message if something goes wrong
        echo "Error: " . mysqli_error($connect);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect if no notice_id was provided
    header("Location: ../notices_page.php");
    exit();
}
?>
