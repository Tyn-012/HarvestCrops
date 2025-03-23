<?php
include 'user_details.php';
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$notice_qry = "SELECT * FROM organization_details WHERE User_ID = ?" ;
    $noticeStmt = $connect->prepare($notice_qry);
    $noticeStmt->bind_param("i", $user_id);
    $noticeStmt->execute(); // Save relative path to DB
    $notice_result = $noticeStmt->get_result();    
    if ($row = $notice_result->fetch_assoc()) {
        $org_id= $row['Organization_ID'];
        $organization_name = $row['Organization_Name'];
    }
    



if(isset($_POST['create'])){
    
    $notice_title = $_POST['notice_title'];
    $notice_content = $_POST['notice_content'];
    $notice_schedule = $_POST['notice_schedule'];


    $notice_qry = "INSERT INTO organization_notice (Organization_ID, Notice_Title, Notice_Content, Notice_Schedule, Organization_Name) VALUES (?, ?, ?, ?, ?)";
    $noticeStmt = $connect->prepare($notice_qry);
    $noticeStmt->bind_param("issss", $org_id,$notice_title, $notice_content, $notice_schedule, $organization_name); // Save relative path to DB
    if ($noticeStmt->execute()) {
    echo "<script language = 'JavaScript'>
    alert('Notice Created Successfully');";
    echo "window.location = \"../organization_page.php\";";
    echo "</script>";
    } else {
    echo $noticeStmt->error;
    }
}


?>