<?php
session_start();
include 'connect.php';

    $user_id = $_SESSION['user-id'];
    if (isset($_POST['submit'])) {

        // Name
        $fname = $_POST['firstname'];
        $mname = $_POST['middlename'];
        $lname = $_POST['lastname'];

        // Birthdate
        $b_year = $_POST['birth-year'];
        $b_month = $_POST['birth-month'];
        $b_day = $_POST['birth-day'];
        $gender = $_POST['userGender'];
        $birth_date = $b_year . '-' . $b_month . '-' . $b_day;

        // Other Information
        $email=$_POST['EmailAdd'];
        $num = $_POST['MobileNum'];
        $cr_pass = $_POST['Password'];

        $user_query = "UPDATE user 
        SET User_FirstName = '$fname', 
            User_MiddleName = '$mname', 
            User_LastName = '$lname', 
            User_BirthDate = '$birth_date', 
            User_Gender = '$gender', 
            User_EmailAddress ='$email',
            User_Password = '$cr_pass', 
            User_MobileNumber = '$num'
        WHERE User_ID = '$user_id'";
        
       if (mysqli_query($connect, $user_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Updated');";
            echo "window.location = \"../admin_page.php\";
                   </script>";
       }

       
    }
?>
