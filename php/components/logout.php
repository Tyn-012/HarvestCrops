<?php
include 'connect.php';
session_start();

// Get the current user ID from the session
$user_id = $_SESSION['user_id'];  // Assuming session already has user_id
$current_user_email = $_SESSION['email_address'];  // Current user's email


if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Get the current session details
    $session_time = gmdate('Y-m-d H:i:s');
    $session_id = $_SESSION['session_id'];

    // If action is 'logout'
    if ($action == 'logout') {
        // Update session status to 'closed' in the database
        $logout_qry = "UPDATE user_session 
                       SET session_end = '$session_time', last_activity = '$session_time', session_status = 'closed' 
                       WHERE Session_ID = '$session_id'";

        // Execute the logout query
        if (mysqli_query($connect, $logout_qry)) {
            // If query executes successfully, proceed with logout
            session_destroy();  // Destroy the session

            // Use JavaScript to redirect the current page to the sign-in page
            echo "<script language='JavaScript'>
                    alert('Successfully Logged Out');
                    window.location = '../../src/sign_in.html';  // Redirect to sign-in page
                  </script>";
        } else {
            // If the query fails, show an error message and redirect to sign-in page
            echo "<script language='JavaScript'>
                    alert('Logout failed. Please try again.');
                    window.location = '../../src/sign_in.html';  // Redirect to sign-in page in case of error
                  </script>";
        }
    }

    // If action is 'switch' (to switch accounts)
    if ($action == 'switch') {
        // Ensure logout is executed correctly before switching
        $logout_qry = "UPDATE user_session 
                       SET session_end = '$session_time', last_activity = '$session_time', session_status = 'closed' 
                       WHERE Session_ID = '$session_id'";

        // Execute the logout query
        if (!mysqli_query($connect, $logout_qry)) {
            echo "<script language='JavaScript'>
                    alert('Failed to log out before switching.');
                    window.location = '../../src/sign_in.html';
                  </script>";
            exit();
        }

        // Get the selected account ID
        if (isset($_POST['account'])) {
            $new_account_id = $_POST['account'];

            // Query to fetch the selected account's email
            $account_query = "SELECT Switch_Email FROM user_account_switch WHERE Switch_ID = '$new_account_id'";
            $account_result = mysqli_query($connect, $account_query);

            if ($account_result && mysqli_num_rows($account_result) > 0) {
                $account = mysqli_fetch_assoc($account_result);
                $new_email = $account['Switch_Email'];

                // Store the selected email and user ID in the session
                $_SESSION['user_email'] = $new_email;   // Store the new email in the session
                $_SESSION['user_id'] = $new_account_id; // Store the new user_id in the session

                // Redirect the user to the appropriate page after switching (e.g., dashboard or homepage)
                echo "<script language='JavaScript'>
                        alert('Switched account successfully.');
                        window.location = '../switch_user_page.php';
                      </script>";

                exit();
            } else {
                // Handle the case where no account was found
                echo "<script language='JavaScript'>
                        alert('Account not found.');
                        window.location = '../../src/sign_in.html';
                      </script>";
            }
        } else {
            // If no account is selected
            echo "<script language='JavaScript'>
                    alert('No account selected for switching.');
                    window.location = '../../src/sign_in.html';
                  </script>";
        }
    }

    // Handle the 'remove_email' action
    if (isset($_POST['action']) && $_POST['action'] == 'remove_email') {
        // Get the email ID to be removed
        $email_id_to_remove = $_POST['remove_email'];

        // Delete the email from the user_account_switch table
        $remove_query = "DELETE FROM user_account_switch WHERE Switch_ID = $email_id_to_remove AND User_ID = $user_id";

        if (mysqli_query($connect, $remove_query)) {
            // Success: Redirect back to the previous page or show success
            echo "<script language='JavaScript'>
            alert('Email removed successfully!');
            window.location.href = document.referrer;  // Go to the previous page
            setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
            </script>";

            exit();
        } else {
            // Error in query execution
            echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
        }
    }

    // Handle the 'add_email' action
    if (isset($_POST['action']) && $_POST['action'] == 'add_email') {
        // Sanitize the input email
        $new_email = mysqli_real_escape_string($connect, $_POST['new_email']);

        // Check if the new email is the same as the current user's email
        if (strtolower($new_email) === strtolower($current_user_email)){
            echo "<script language='JavaScript'>
                alert('You cannot add your own email to the switch list.');
                window.location.href = document.referrer;  // Go to the previous page
                setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
                </script>";
                exit();
        }

        // Validate the email format
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            // Check if the email exists in the user table
            $user_check_query = "SELECT User_EmailAddress FROM user WHERE User_EmailAddress = '$new_email'";
            $user_check_result = mysqli_query($connect, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                // Email exists in the user table, now check if it is already in the switch list
                $check_query = "SELECT * FROM user_account_switch WHERE User_ID = $user_id AND Switch_Email = '$new_email'";
                $check_result = mysqli_query($connect, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    // Email already exists in the switch list
                    echo "<script language='JavaScript'>
                    alert('This email is already added to your account switch list.');
                    window.location.href = document.referrer;  // Go to the previous page
                    setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
                    </script>";

                    exit();
                } else {
                    // Insert the new email into the user_account_switch table
                    $insert_query = "INSERT INTO user_account_switch (Switch_Email, User_ID) VALUES ('$new_email', $user_id)";
                    if (mysqli_query($connect, $insert_query)) {
                        echo "<script language='JavaScript'>
                        alert('Email added successfully!');
                        window.location.href = document.referrer;  // Go to the previous page
                        setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
                        </script>";
                        exit();
                    } 
                    else {
                        echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
                    }
                }
            } else {
                // Email does not exist in the user table
                echo "<script language='JavaScript'>
                alert('Email is not valid!');
                window.location.href = document.referrer;  // Go to the previous page
                setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
                </script>";
                exit();
            }
        } else {
            echo "<script language='JavaScript'>
            alert('Invalid email format!');
            window.location.href = document.referrer;  // Go to the previous page
            setTimeout(function() { window.location.reload(); }, 200);  // Reload the page after a short delay
            </script>";
        }
    }
}
?>
