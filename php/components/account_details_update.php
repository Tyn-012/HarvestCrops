<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {

        // Name
        $fname = $_POST['firstname'];
        $mname = $_POST['middlename'];
        $lname = $_POST['lastname'];

        // Birthdate
        $b_year = $_POST['birth-year'];
        $b_month = $_POST['birth-month'];
        $b_day = $_POST['birth-day'];
        $birth_date = $b_year . '-' . $b_month . '-' . $b_day;

        // Other Information
        $num = $_POST['MobileNum'];
        $cr_pass = $_POST['Password'];
        $cn_pass = $_POST['Re-enterpass'];
        $gender = $_POST['userGender'];

        //Address Information
        $home_address = $_POST['HomeAdd'];
        $island_group = $_POST['IslandGroup'];
        $region = $_POST['Region'];
        $city = $_POST['City'];
        $barangay = $_POST['Barangay'];
        $zip_code = $_POST['ZIP'];

        // Password Verification
        $count_char = mb_strlen($cr_pass);


        if ($count_char <= 7) {
            echo "<script language = 'JavaScript'>
                alert('Password Must Have Atleast 8 Characters or More');";
            echo "window.location = \"../../src/account_details_update.html\";
                </script>";
        } else if ($cn_pass != $cr_pass) {
            echo "<script language = 'JavaScript'>
                    alert('Unable to create account, Kindly Re-check if the passwords are the same.');";
            echo "window.location = \"../../src/account_details_update.html\";
                    </script>";
        }

        $getaddress_type_qry = "SELECT Address_Type FROM user_address WHERE User_ID = ?";
        $stmt = $connect->prepare($getaddress_type_qry);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $address_type = $row['Address_Type'];
        }

        $user_query = "UPDATE user 
        SET User_FirstName = '$fname', 
            User_MiddleName = '$mname', 
            User_LastName = '$lname', 
            User_BirthDate = '$birth_date', 
            User_Gender = '$gender', 
            User_Password = '$cr_pass', 
            User_MobileNumber = '$num'
        WHERE User_ID = '$user_id'";
        
       if (mysqli_query($connect, $user_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Updated');";
            echo "window.location = \"../../src/account_details_update.html\";
                   </script>";
       }

       $address_query = "UPDATE user_address 
       SET Address_Type = '$address_type',
           User_Address = '$home_address', 
           Island_Group = '$island_group', 
           Region = '$region', 
           City = '$city', 
           Barangay = '$barangay', 
           zip_code = '$zip_code'
       WHERE User_ID = '$user_id'";
       if (mysqli_query($connect, $address_query));
       
    }
?>
