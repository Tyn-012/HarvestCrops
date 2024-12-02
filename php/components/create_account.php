<?php
session_start();
include 'connect.php';
?>

<?php
    $cntuser_qry = "SELECT User_ID, COUNT(*) as total FROM user";
    $cntuser_rslt = mysqli_query($connect, $cntuser_qry);
    if (mysqli_num_rows($cntuser_rslt) > 0) {
        while ($row = mysqli_fetch_assoc($cntuser_rslt)) {

            $totalnum = $row['total'];
            $totalnum = $totalnum + 1;
            $id_db = $totalnum;
            $stat_id = $totalnum;
            $type_id = $totalnum;
            $role_id = $totalnum;
            $address_id = $totalnum;
            $personal_acc_id = $totalnum;
        }
    }
?>

<?php
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
        $email = $_POST['EmailAdd'];
        $num = $_POST['MobileNum'];
        $cr_pass = $_POST['Password'];
        $cn_pass = $_POST['Re-enterpass'];
        $gender = $_POST['userGender'];
        $type = $_POST['Occupation'];

        //Address Information
        $home_address = $_POST['HomeAdd'];
        $island_group = $_POST['IslandGroup'];
        $region = $_POST['Region'];
        $city = $_POST['City'];
        $barangay = $_POST['Barangay'];
        $zip_code = $_POST['ZIP'];

        // Password Verification
        $count_char = mb_strlen($cr_pass);

        if ($gender == 'Male') {
            $_SESSION['gen'] = "Male";
        } else if ($gender == 'Female') {
            $_SESSION['gen'] = "Female";
        } else if ($gender == "Other"){
            $_SESSION['gen'] = "Other";
        }

        if ($type == 'Occupation'){
            echo "<script language = 'JavaScript'>
                    alert('Please Select an Occupation.');";                    
        } else if ($type == 'Farmer'){
            $user_type = 'Farmer';
            $type_desc = 'Local Farmer';
            $user_role = 'User';
            $user_status = 'deactivated';
            $address_type = 'farm';

        } else if ($type == 'Vendor'){
            $user_type = 'Vendor';
            $type_desc = 'Local Vendor';
            $user_role = 'User';
            $user_status = 'deactivated';
            $address_type = 'home';

        } else if ($type == 'Organization'){
            $user_type = 'Organization';
            $type_desc = 'Agriculture Organization';
            $user_role = 'User';
            $user_status = 'deactivated';
            $address_type = 'business';
        }
        
        $sql = "SELECT COUNT(User_ID) AS total FROM user WHERE User_EmailAddress='$email'";
        $result = mysqli_query($connect, $sql);
        $data = mysqli_fetch_assoc($result);
        $check = $data['total'];

        
        if ($check != 0) {
            echo "<script language = 'JavaScript'>
                    alert('Username already in use by other individuals');";
            echo "window.location = \"create_account.php\";
                    </script>";
        } else if ($count_char <= 7) {
            echo "<script language = 'JavaScript'>
                alert('Password Must Have Atleast 8 Characters or More');";
            echo "window.location = \"create_account.php\";
                </script>";
        } else if ($cn_pass != $cr_pass) {
            echo "<script language = 'JavaScript'>
                    alert('Unable to create account, Kindly Re-check if the passwords are the same.');";
            echo "window.location = \"create_account.php\";
                    </script>";
        
        } else {
            
            $stat_query = "INSERT INTO user_status (Status_ID, Status_Name) 
            VALUES ('$stat_id', '$user_status')";
            if (mysqli_query($connect, $stat_query));
            
            $type_query = "INSERT INTO user_type (Type_ID, Type_Name, Type_Description) 
            VALUES ('$type_id', '$user_type', '$type_desc')";
            if (mysqli_query($connect, $type_query));
            
            $role_query = "INSERT INTO user_role (Role_ID, Role_Name) 
            VALUES ('$role_id', '$user_role')";
            if (mysqli_query($connect, $role_query));
            
            $password = password_hash($cn_pass, PASSWORD_DEFAULT);
        
            $query = "INSERT INTO user 
             (User_ID, User_FirstName, User_MiddleName, User_LastName, User_BirthDate, User_Gender, User_EmailAddress, User_Password, User_MobileNumber, Status_ID, Type_ID, Role_ID) 
             VALUES ('$id_db', '$fname', '$mname', '$lname', '$birth_date', '$gender', '$email', '$password', '$num', '$stat_id', '$type_id', '$role_id')";
             
            if (mysqli_query($connect, $query)) {
                echo "<script language = 'JavaScript'>
                        alert('Account Created.');";
                echo "</script>";
            }
            
            $address_query = "INSERT INTO user_address (Address_ID, User_ID, Address_Type, User_Address, Island_Group, Region, City, Barangay, zip_code) 
            VALUES ('$address_id', '$id_db', '$address_type', '$home_address', '$island_group', '$region', '$city', '$barangay', '$zip_code')";
            if (mysqli_query($connect, $address_query));
            }

            $role_management_query = "INSERT INTO user_role_management (User_ID, Role_ID) 
            VALUES ('$id_db', '$role_id')";
            if (mysqli_query($connect, $role_management_query));


            $type_management_query = "INSERT INTO user_type_management (User_ID, Type_ID) 
            VALUES ('$id_db', '$type_id')";
            if (mysqli_query($connect, $type_management_query));


            if($user_type=="Farmer"){
                $farmer_det_query = "INSERT INTO farmer_details (Farmer_ID, User_ID) 
                VALUES ('$personal_acc_id', '$id_db')";
                if (mysqli_query($connect, $farmer_det_query));
            }
            else if($user_type=="Vendor"){
                $vendor_det_query = "INSERT INTO vendor_details (Vendor_ID, User_ID) 
                VALUES ('$personal_acc_id', '$id_db')";
                if (mysqli_query($connect, $vendor_det_query));
            }
            else if($user_type=="Organization"){
                $org_det_query = "INSERT INTO organization_details (Organization_ID, User_ID) 
                VALUES ('$personal_acc_id', '$id_db')";
                if (mysqli_query($connect, $org_det_query));
            }
    }
    echo "<script language = 'JavaScript'>
    window.location = \"../../src/sign_in.html\";";
    echo "</script>";
?>
<?php
session_destroy();
?>