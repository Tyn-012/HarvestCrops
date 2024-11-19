<?php
session_start();
include 'connect.php';

if(isset($_POST['forgot_password']))
    $cnt_qry = "SELECT reset_id, COUNT(*) as total FROM password_reset";
    $cnt_rslt = mysqli_query($connect, $cnt_qry);
    
    $user_email = $_POST['email'];
    $set_time = gmdate('Y-m-d H:i:s');

    $date = new DateTime($set_time);
    $date->add(new DateInterval('PT10M'));
    $new_time = $date->format('Y-m-d H:i:s');

    if (mysqli_num_rows($cnt_rslt) > 0) {
        while ($row = mysqli_fetch_assoc($cnt_rslt)) {
            $count_result = $row['total'];
            $reset_id = $count_result + 1;
            $reset_token = $count_result + 1;
        }
    }


    $getuser_id_qry = "SELECT User_ID FROM user WHERE User_EmailAddress = ? ";
    $stmt = $connect->prepare($getuser_id_qry);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['User_ID'];
    }
    else{
        echo "<script language = 'JavaScript'>
        alert('Email Address Not Identified.');";
        echo "window.location = \"../../src/forgot_password.html\";
        </script>";
    }

    $reset_password_qry = "INSERT INTO password_reset (reset_id, User_ID, reset_token, token_expiry)
    VALUES ('$reset_id', '$user_id', '$reset_token', '$new_time')";
    if (mysqli_query($connect, $reset_password_qry)){
        echo "<script language = 'JavaScript'>
        alert('Please Check Your Email For Your New Password.');";
        echo "window.location = \"../../src/sign_in.html\";
        </script>";
    }
    

?>