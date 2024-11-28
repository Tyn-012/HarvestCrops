<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
  header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
  exit();
}

// Get the current session details
$session_time = gmdate('Y-m-d H:i:s');
$session_id = $_SESSION['session_id'];

// Update session status to 'closed' in the database
$logout_qry = "UPDATE user_session 
               SET session_end = '$session_time', last_activity = '$session_time', session_status = 'closed' 
               WHERE Session_ID = '$session_id'";

// Execute the logout query
if (mysqli_query($connect, $logout_qry)) {
    // If query executes successfully, proceed with logout
    session_destroy();  // Destroy the session

    // Use JavaScript to redirect the current page to the sign-in page
    echo "<script language='JavaScript'>
            alert('Successfully Logged Out');
            window.location = '../../src/sign_in.html';  // Redirect to sign-in page
          </script>";
} else {
    // If the query fails, show an error message and redirect to sign-in page
    echo "<script language='JavaScript'>
            alert('Logout failed. Please try again.');
            window.location = '../../src/sign_in.html';  // Redirect to sign-in page in case of error
          </script>";
}
?>
