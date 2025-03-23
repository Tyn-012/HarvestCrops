<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

$get_user_type_id_qry = "SELECT * FROM user_type_management WHERE User_ID = ?";
$status_stmt = $connect->prepare($get_user_type_id_qry);
$status_stmt->bind_param('i', $user_id);
$status_stmt->execute();
$result = $status_stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $type_id = $row['Type_ID'];
}

$get_user_class_qry = "SELECT Type_Name FROM user_type WHERE Type_ID = ?";
$status_stmt = $connect->prepare($get_user_class_qry);
$status_stmt->bind_param('i', $type_id);
$status_stmt->execute();
$result = $status_stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $type_name = $row['Type_Name'];
}

if($type_name == "Farmer"){
    $user_class = "customer_support_page_vendor.php";
}
else if($type_name == "Vendor"){
    $user_class = "customer_support_page_vendee.php";
}

// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Capture form data
    $username = $_POST['custom-username'];  // Username (not used in database but can be saved if needed)
    $email = $_POST['custom-email'];        // Email (not used in the table, optional for future use)
    $mobile = $_POST['custom-number'];      // Mobile number (not used in the table, optional)
    $question = $_POST['custom-question']; // The actual question being asked

    // Ensure that the question field is not empty
    if (empty($question)) {
        echo "Please enter your question.<br>";
        exit;
    }

    // Insert the inquiry into the `product_qa` table
    $query = "INSERT INTO product_qa (User_ID, question, is_answered) VALUES (?, ?, 0)"; 
    $stmt = $connect->prepare($query);
    $stmt->bind_param('is', $user_id, $question); // Bind User_ID and the question text

    // Check if the query executed successfully
    if ($stmt->execute()) {
        echo "<script language = 'JavaScript'>
        alert('Your inquiry has been submitted successfully. We will get back to you soon.');";
        echo "window.location = \"../$user_class\";
        </script>";
        exit;
    } else {
        echo "Error submitting your inquiry: " . $stmt->error . "<br>";
    }
}


?>