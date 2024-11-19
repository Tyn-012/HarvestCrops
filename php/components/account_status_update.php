<?php
session_start();
include 'connect.php';

    if (isset($_POST['deactivate']) && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        echo $user_id;

        $getuser_id_qry = "SELECT Status_ID FROM user WHERE User_ID = ? ";
        $stmt = $connect->prepare($getuser_id_qry);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
        $user_stat_id = $row['Status_ID'];
        }

        $status_query = "UPDATE user_status 
        SET Status_Name = 'deactivated' 
        WHERE Status_ID = '$user_stat_id'";
        
       if (mysqli_query($connect, $status_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Deactivated');";
            echo "window.location = \"../admin_page.php\";
                   </script>";
       }
    }

    else if (isset($_POST['activate']) && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        echo $user_id;

        $getuser_id_qry = "SELECT Status_ID FROM user WHERE User_ID = ? ";
        $stmt = $connect->prepare($getuser_id_qry);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $user_stat_id = $row['Status_ID'];
        }
        
        $status_query = "UPDATE user_status 
        SET Status_Name = 'active' 
        WHERE Status_ID = '$user_stat_id'";
        
       if (mysqli_query($connect, $status_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Activated');";
            echo "window.location = \"../admin_page.php\";
                   </script>";
       }
    }
?>

