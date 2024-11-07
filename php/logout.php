<?php
include 'connect.php';
session_start();

$session_time = gmdate('Y-m-d H:i:s');
$session_id = $_SESSION['session_id'];

$logout_qry = "UPDATE user_session 
SET session_end = '$session_time', last_activity = '$session_time', session_status = 'closed' 
WHERE Session_ID = '$session_id'";
if (mysqli_query($connect, $logout_qry));

echo "<script language = 'JavaScript'>
alert('Successfully Logged Out');";
echo "window.location = \"../src/sign_in.html\";
</script>";

session_destroy();
?>