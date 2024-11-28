<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['submit'])) {

    $organization_name = $_POST['organization_name'];
    $contact_number = $_POST['contact_number'];
    $email_address = $_POST['email_address'];


    // Correct the SQL query (removed the extra comma)
    $org_query = "UPDATE organization_details 
                   SET organization_name = '$organization_name',
                       contact_number = '$contact_number', 
                       email_address = '$email_address'
                   WHERE User_ID = '$user_id' ";

    // Execute the query and check for success
    if (mysqli_query($connect, $org_query)) {
        echo "<script language = 'JavaScript'>
              alert('Organization Information Updated');";
              echo "window.location = \"../organization_page.php\";";
              echo "</script>";
    } else {
        // Debugging: print error message if the query fails
        echo "Error: " . mysqli_error($connect);
    }
}
?>