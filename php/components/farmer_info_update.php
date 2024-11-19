<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {

    $farm_name = $_POST['farm_name'];
    $farm_size = $_POST['farm_size'];
    $farm_size_unit = $_POST['farm_size_unit'];

    // Correct the SQL query (removed the extra comma)
    $farm_query = "UPDATE farmer_details 
                   SET farm_name = '$farm_name',
                       farm_size = '$farm_size', 
                       farm_size_unit = '$farm_size_unit'
                   WHERE User_ID = '$user_id'";

    // Execute the query and check for success
    if (mysqli_query($connect, $farm_query)) {
        echo "<script language = 'JavaScript'>
              alert('Farmer Information Updated');";
        echo "window.location = \"../farmer_account_page.php\";";
        echo "</script>";
    } else {
        // Debugging: print error message if the query fails
        echo "Error: " . mysqli_error($connect);
    }
}
?>