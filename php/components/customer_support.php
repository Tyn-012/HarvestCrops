<?php
session_start();
include 'connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

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
        echo "window.location = \"../../src/customer_support_page.html\";
        </script>";
        exit;
    } else {
        echo "Error submitting your inquiry: " . $stmt->error . "<br>";
    }
}
?>