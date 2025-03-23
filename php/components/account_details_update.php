<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

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

        $getaddress_type_qry = "SELECT Address_Type FROM user_address WHERE User_ID = ?";
        $stmt = $connect->prepare($getaddress_type_qry);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $address_type = $row['Address_Type'];
        }

        if($cn_pass == null){
            if (!preg_match("/^[a-zA-Z ]*$/", $fname) || !preg_match("/^[a-zA-Z ]*$/", $mname) || !preg_match("/^[a-zA-Z ]*$/", $lname) || 
            !preg_match("/^[a-zA-Z0-9 ]*$/", $home_address) || !preg_match("/^[a-zA-Z ]*$/", $island_group) || 
            !preg_match("/^[a-zA-Z0-9 ]*$/", $region) || !preg_match("/^[a-zA-Z ]*$/", $city) || !preg_match("/^[a-zA-Z ]*$/", $barangay)) {
            echo "<script language='JavaScript'>
                    alert('Name fields must contain only letters and spaces. Address and region fields can contain letters, numbers, and spaces.');
                    window.location = \"../account_info_update.php\";
                  </script>";
            } else if (!preg_match("/^[0-9]{4}$/", $zip_code)) {
                echo "<script language='JavaScript'>
                        alert('Postal code must be exactly 4 digits');
                        window.location = \"../account_info_update.php\";
                    </script>";
            } else if (!preg_match("/^[0-9]{11}$/", $num)) {
                echo "<script language='JavaScript'>
                        alert('Unable to create account, Kindly Re-check if the phone number is correct.');
                        window.location = \"../account_info_update.php\";
                    </script>";
            } else{
                $user_query = "UPDATE user 
                SET User_FirstName = '$fname', 
                    User_MiddleName = '$mname', 
                    User_LastName = '$lname', 
                    User_BirthDate = '$birth_date', 
                    User_Gender = '$gender', 
                    User_MobileNumber = '$num'
                WHERE User_ID = '$user_id'";
            }
        }

        else{
            // Password Verification
            $count_char = mb_strlen($cr_pass);

            if ($count_char <= 7) {
                echo "<script language = 'JavaScript'>
                    alert('Password Must Have Atleast 8 Characters or More');";
                echo "window.location = \"../account_info_update.php\";
                    </script>";
            } else if (!preg_match("/^[a-zA-Z ]*$/", $fname) || !preg_match("/^[a-zA-Z ]*$/", $mname) || !preg_match("/^[a-zA-Z ]*$/", $lname) || 
                !preg_match("/^[a-zA-Z0-9 ]*$/", $home_address) || !preg_match("/^[a-zA-Z ]*$/", $island_group) || 
                !preg_match("/^[a-zA-Z0-9 ]*$/", $region) || !preg_match("/^[a-zA-Z ]*$/", $city) || !preg_match("/^[a-zA-Z ]*$/", $barangay)) {
                echo "<script language='JavaScript'>
                        alert('Name fields must contain only letters and spaces. Address and region fields can contain letters, numbers, and spaces.');
                        window.location = \"../account_info_update.php\";
                    </script>";
            } else if (!preg_match("/^[0-9]{4}$/", $zip_code)) {
                echo "<script language='JavaScript'>
                        alert('Postal code must be exactly 4 digits');
                        window.location = \"../account_info_update.php\";
                    </script>";
            } else if (!preg_match("/^[0-9]{11}$/", $num)) {
                echo "<script language='JavaScript'>
                        alert('Unable to create account, Kindly Re-check if the phone number is correct.');
                        window.location = \"../account_info_update.php\";
                    </script>";
            } else if ($cn_pass != $cr_pass) {
                echo "<script language = 'JavaScript'>
                        alert('Kindly Re-check if the passwords are the same.');";
                echo "window.location = \"../account_info_update.php\";
                        </script>";
            }
            else{
                $password = password_hash($cn_pass, PASSWORD_DEFAULT);
                $user_query = "UPDATE user 
                SET User_FirstName = '$fname', 
                    User_MiddleName = '$mname', 
                    User_LastName = '$lname', 
                    User_BirthDate = '$birth_date', 
                    User_Gender = '$gender', 
                    User_Password = '$password', 
                    User_MobileNumber = '$num'
                WHERE User_ID = '$user_id'";
            }
        }

        
       if (mysqli_query($connect, $user_query)) {
            echo "<script language = 'JavaScript'>
                   alert('Account Updated');";
            echo "window.location = \"../account_info_update.php\";
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

