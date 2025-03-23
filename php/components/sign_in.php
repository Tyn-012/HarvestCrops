<?php
session_start();
include 'connect.php';

$cnt_qry = "SELECT Session_ID, COUNT(*) as total FROM user_session";
$cnt_rslt = mysqli_query($connect, $cnt_qry);
if (mysqli_num_rows($cnt_rslt) > 0) {
    while ($row = mysqli_fetch_assoc($cnt_rslt)) {
        $count_result = $row['total'];
        $total_count = $count_result + 1;
        $session_id = $total_count;
    }
}

if (isset($_POST['signin'])) {
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];  // The plain text password entered by the user
    
    $session_time = gmdate('Y-m-d H:i:s');
    
    // Query to get the user details using the entered email
    $getuser_qry = "SELECT * FROM user WHERE User_EmailAddress= ?";
    $stmt = $connect->prepare($getuser_qry);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // The hashed password from the database
        $hashed_password = $row['User_Password'];
        $verification = $row['verified'];

        // Verify the entered password against the stored hashed password
        if (password_verify($user_password, $hashed_password)) {
            // Check if the user is verified
            if ($row['verified'] == 1) {
                // Password matches and user is verified, continue with session setup
                $user_id = $row['User_ID'];
                $status_id = $row['Status_ID'];
                $role_id = $row['Role_ID'];
                $type_id = $row['Type_ID'];

                // Set session variables
                $_SESSION['user_id'] = $row['User_ID'];
                $_SESSION['status_id'] = $row['Status_ID'];
                $_SESSION['type_id'] = $row['Type_ID'];
                $_SESSION['role_id'] = $row['Role_ID'];
                $_SESSION['name'] = $row['User_FirstName'] . " " . $row['User_MiddleName'] . " " . $row['User_LastName'];
                $_SESSION['birthdate'] = $row['User_BirthDate'];
                $_SESSION['email_address'] = $row['User_EmailAddress'];
                $_SESSION['mobile_number'] = $row['User_MobileNumber'];

                // Fetch user status, role, and type
                $getuser_status_qry = "SELECT Status_Name FROM user_status WHERE Status_ID = ?";
                $stmt = $connect->prepare($getuser_status_qry);
                $stmt->bind_param('s', $status_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $user_status = $row['Status_Name'];
                }

                $getuser_role_qry = "SELECT Role_Name FROM user_role WHERE Role_ID = ?";
                $stmt = $connect->prepare($getuser_role_qry);
                $stmt->bind_param('s', $role_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $user_role = $row['Role_Name'];
                }

                $getuser_type_qry = "SELECT Type_Name FROM user_type WHERE Type_ID = ?";
                $stmt = $connect->prepare($getuser_type_qry);
                $stmt->bind_param('s', $type_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $user_type = $row['Type_Name'];
                }

                // If user status is active, log them in
                if ($user_status == "active" || $verification == 1) {
                    // Insert user session data
                    $status_qry = "INSERT INTO user_session (Session_ID, User_ID, last_activity) VALUES('$session_id', '$user_id', '$session_time')";
                    if (mysqli_query($connect, $status_qry)) {
                        $_SESSION['session_id'] = $session_id;
                        
                        // Redirect based on user role
                        if ($user_role == "Admin") {
                            echo "<script language='JavaScript'>
                                    alert('Login Successful');
                                    window.location = \"../admin_page.php\";
                                  </script>";
                        } else if ($user_role == "User") {
                            // Redirect based on user type (Farmer, Vendor, or Organization)
                            if ($user_type == "Farmer") {
                                echo "<script language='JavaScript'>
                                        alert('Login Successful');
                                        window.location = \"../farmer_account_page.php\";
                                      </script>";
                            } else if ($user_type == "Vendor") {
                                echo "<script language='JavaScript'>
                                        alert('Login Successful');
                                        window.location = \"../vendee_account_page.php\";
                                      </script>";
                            } else if ($user_type == "Organization") {
                                echo "<script language='JavaScript'>
                                        alert('Login Successful');
                                        window.location = \"../organization_page.php\";
                                      </script>";
                            }
                        }
                    }
                } else {
                    // Account is not active
                    echo "<script language='JavaScript'>
                            alert('Your account is not yet verified');
                            window.location = \"../../src/sign_in.html\";
                          </script>";
                }
            } else {
                // User is not verified
                echo "<script language='JavaScript'>
                        alert('Please verify your email address before logging in.');
                        window.location = \"../../src/sign_in.html\";
                      </script>";
            }
        } else {
            // Invalid password
            echo "<script language='JavaScript'>
                    alert('Invalid Username or Password');
                    window.location = \"../../src/sign_in.html\";
                  </script>";
        }
    } else {
        // Email not found
        echo "<script language='JavaScript'>
                alert('Invalid Username or Password');
                window.location = \"../../src/sign_in.html\";
              </script>";
    }
}
?>