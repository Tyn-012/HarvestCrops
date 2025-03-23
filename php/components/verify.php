<?php
require 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $connect->prepare("SELECT user_id FROM verification_tokens WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update the user to set verified = 1
        $stmt = $connect->prepare("UPDATE user SET verified = 1 WHERE User_ID = ?");
        $stmt->bind_param('i', $user['user_id']);
        $stmt->execute();

        // Update the user_status to set Status_Name = 'active'
        $stmt = $connect->prepare("UPDATE user_status 
                                   SET Status_Name = 'active' 
                                   WHERE Status_ID = (SELECT Status_ID FROM user WHERE User_ID = ?)");
        $stmt->bind_param('i', $user['user_id']);
        $stmt->execute();

        // Delete the token from verification_tokens table
        $stmt = $connect->prepare("DELETE FROM verification_tokens WHERE token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();

        echo "Email verified successfully!";
    } else {
        echo "Invalid token!";
    }
} else {
    echo "No token provided!";
}
?>