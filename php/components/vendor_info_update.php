<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['submit'])) {

    $business_name = $_POST['business_name'];
    $tax_id = $_POST['tax_id'];
    $business_type = $_POST['business_type'];
    $yr_in_business = $_POST['yr_in_business'];
    $product_types = $_POST['product_types'];

    // Correct the SQL query (removed the extra comma)
    $vendor_query = "UPDATE vendor_details 
                   SET business_name = '$business_name',
                       tax_id = '$tax_id', 
                       business_type = '$business_type',
                       years_in_business = '$yr_in_business',  
                       product_types = '$product_types'
                   WHERE User_ID = '$user_id'";

    // Execute the query and check for success
    if (mysqli_query($connect, $vendor_query)) {
        echo "<script language = 'JavaScript'>
              alert('Vendor Information Updated');";
              echo "window.location = \"../vendor_account_page.php\";";
              echo "</script>";
    } else {
        // Debugging: print error message if the query fails
        echo "Error: " . mysqli_error($connect);
    }
}
?>