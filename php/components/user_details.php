<?php
session_start();
include 'connect.php';

$userid = $_SESSION['user_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$getuser_info_qry = "SELECT * FROM user WHERE User_ID = ?";
$stmt = $connect->prepare($getuser_info_qry);
$stmt->bind_param('s', $userid);
$stmt->execute();
$user_result = $stmt->get_result();

if ($row = $user_result->fetch_assoc()) {
    $status_id = $row['Status_ID'];
    $role_id = $row['Role_ID'];
    $type_id = $row['Type_ID'];
    $name = $row['User_FirstName'] . " " . $row['User_MiddleName'] . " " . $row['User_LastName'];
    $birthdate = $row['User_BirthDate'];
    $email_address= $row['User_EmailAddress'];
    $mobile_number = $row['User_MobileNumber'];
}

$getuser_add_qry = "SELECT * FROM user_address WHERE User_ID = ?";
$stmt = $connect->prepare($getuser_add_qry);
$stmt->bind_param('s', $userid);
$stmt->execute();
$address_result = $stmt->get_result();

if ($row = $address_result->fetch_assoc()) {
    $user_address = $row['User_Address'];
    $island_group = $row['Island_Group'];
    $region = $row['Region'];
    $city= $row['City'];
    $barangay = $row['Barangay'];
    $zip = $row['zip_code'];
}

$getuser_farm_det_qry = "SELECT * FROM farmer_details WHERE User_ID = ?";
$stmt = $connect->prepare($getuser_farm_det_qry);
$stmt->bind_param('s', $userid);
$stmt->execute();
$farm_det_result = $stmt->get_result();

if ($row = $farm_det_result->fetch_assoc()) {
    $farm_name = $row['farm_name'];
    $farm_size = $row['farm_size'];
    $farm_size_unit = $row['farm_size_unit'];
}




?>