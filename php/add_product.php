<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directory to save uploaded images
    $targetDir = "../images/product_uploads/";

    // Create the uploads directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Get the file details
    $fileName = basename($_FILES["image"]["name"]);
    $fileTmpPath = $_FILES["image"]["tmp_name"];  // Temporary path of the uploaded file
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if the file type is allowed
    if (in_array($fileType, $allowedTypes)) {
        // Generate a new unique name for the file
        $newFileName = uniqid('img_', true) . '.' . $fileType;

        // Set the new target file path with the new name
        $targetFilePath = $targetDir . $newFileName;

        // Move the uploaded file to the target directory with the new name
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            echo "The file has been uploaded successfully as " . htmlspecialchars($newFileName);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
} else {
    echo "Invalid request.";
}

/*
if (isset($_POST['submit'])) {

    $cntproduct_qry = "SELECT User_ID, COUNT(*) as total FROM user";
    $cntproduct_rslt = mysqli_query($connect, $cntuser_qry);
    if (mysqli_num_rows($cntuser_rslt) > 0) {
        while ($row = mysqli_fetch_assoc($cntuser_rslt)) {

            $totalnum = $row['total'];
            $totalnum = $totalnum + 1;
            $id_db = $totalnum;
            $stat_id = $totalnum;
            $type_id = $totalnum;
            $role_id = $totalnum;
            $address_id = $totalnum;
        }
    }
}
*/
?>