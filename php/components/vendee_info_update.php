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

    // Validate business_name to contain only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $business_name)) {
        echo "<script language='JavaScript'>
                alert('Business name must contain only letters and spaces.');
                window.location = '../vendee_account_page.php';
              </script>";
        exit();
    }

    // Validate tax_id to be a valid tax ID (assuming it should be alphanumeric)
    if (!preg_match("/^[0-9]+$/", $tax_id)) {
        echo "<script language='JavaScript'>
                alert('Tax ID must be valid.');
                window.location = '../vendee_account_page.php';
              </script>";
        exit();
    }

    // Validate yr_in_business to contain only integers
    if (!preg_match("/^[0-9]+$/", $yr_in_business)) {
        echo "<script language='JavaScript'>
                alert('Years in business must be a valid');
                window.location = '../vendee_account_page.php';
              </script>";
        exit();
    }

    // Validate product_types to contain only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $product_types)) {
        echo "<script language='JavaScript'>
                alert('Product types must contain only letters and spaces.');
                window.location = '../vendee_account_page.php';
              </script>";
        exit();
    }

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
        echo "<script language='JavaScript'>
              alert('Vendee Information Updated');
              window.location = '../vendee_account_page.php';
              </script>";
    } else {
        // Debugging: print error message if the query fails
        echo "Error: " . mysqli_error($connect);
    }
}
?>