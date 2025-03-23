<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

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

        if($cr_pass == null){
            if (!preg_match("/^[a-zA-Z ]*$/", $fname) || !preg_match("/^[a-zA-Z ]*$/", $mname) || !preg_match("/^[a-zA-Z ]*$/", $lname)) {
            echo "<script language='JavaScript'>
                    alert('Name fields must contain only letters and spaces.');
                    window.location = \"../admin_page.php\";
                  </script>";
            } else if (!preg_match("/^[0-9]{11}$/", $num)) {
                echo "<script language='JavaScript'>
                        alert('Kindly Re-check if the phone number is correct.');
                        window.location = \"../admin_page.php\";
                    </script>";
            } else if (strpos($email, "@") === false) {
                echo "<script language = 'JavaScript'>
                        alert('Kindly Re-check if the email is valid.');
                        window.location = \"../admin_page.php\";
                        </script>";
            } else{
                $user_query = "UPDATE user 
                SET User_FirstName = '$fname', 
                    User_MiddleName = '$mname', 
                    User_LastName = '$lname', 
                    User_BirthDate = '$birth_date', 
                    User_Gender = '$gender',
                    User_EmailAddress ='$email', 
                    User_MobileNumber = '$num'
                WHERE User_ID = '$user_id'";
            }
        }else{
            if (!preg_match("/^[a-zA-Z ]*$/", $fname) || !preg_match("/^[a-zA-Z ]*$/", $mname) || !preg_match("/^[a-zA-Z ]*$/", $lname)) {
                echo "<script language='JavaScript'>
                        alert('Name fields must contain only letters and spaces.');
                        window.location = \"../admin_page.php\";
                      </script>";
                } else if (!preg_match("/^[0-9]{11}$/", $num)) {
                    echo "<script language='JavaScript'>
                            alert('Kindly Re-check if the phone number is correct.');
                            window.location = \"../admin_page.php\";
                        </script>";
                } else if (strpos($email, "@") === false) {
                    echo "<script language = 'JavaScript'>
                            alert('Kindly Re-check if the email is valid.');
                            window.location = \"../admin_page.php\";
                            </script>";
                } else{
                $password = password_hash($cr_pass, PASSWORD_DEFAULT);
                $user_query = "UPDATE user 
                SET User_FirstName = '$fname', 
                    User_MiddleName = '$mname', 
                    User_LastName = '$lname', 
                    User_BirthDate = '$birth_date', 
                    User_Gender = '$gender', 
                    User_EmailAddress ='$email',
                    User_Password = '$password', 
                    User_MobileNumber = '$num'
                WHERE User_ID = '$user_id'";
            }

        }
       if (mysqli_query($connect, $user_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Updated');";
            echo "window.location = \"../admin_page.php\";
                   </script>";
       }

       
    }
?>

