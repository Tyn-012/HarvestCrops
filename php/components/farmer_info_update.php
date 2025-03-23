<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {

    $farm_name = $_POST['farm_name'];
    $farm_size = $_POST['farm_size'];
    $farm_size_unit = $_POST['farm_size_unit'];

    // Validate farm_name to contain only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $farm_name)) {
        echo "<script language='JavaScript'>
                alert('Farm name must contain only letters and spaces.');
                window.location = '../farmer_account_page.php';
              </script>";
        exit();
    }

    // Validate farm_size to contain only integers
    if (!preg_match("/^[0-9]+$/", $farm_size)) {
        echo "<script language='JavaScript'>
                alert('Farm size must be valid.');
                window.location = '../farmer_account_page.php';
              </script>";
        exit();
    }

    // Correct the SQL query (removed the extra comma)
    $farm_query = "UPDATE farmer_details 
                   SET farm_name = '$farm_name',
                       farm_size = '$farm_size', 
                       farm_size_unit = '$farm_size_unit'
                   WHERE User_ID = '$user_id'";

    // Execute the query and check for success
    if (mysqli_query($connect, $farm_query)) {
        echo "<script language='JavaScript'>
              alert('Vendor Information Updated');
              window.location = '../farmer_account_page.php';
              </script>";
    } else {
        // Debugging: print error message if the query fails
        echo "Error: " . mysqli_error($connect);
    }
}
?>