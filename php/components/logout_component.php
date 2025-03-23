<?php
include 'connect.php';
session_start();

$user_id = $_SESSION['user_id'];  // Get the current logged-in user's ID

// Query to fetch all users except the current user
$query = "SELECT Switch_ID, Switch_Email FROM user_account_switch WHERE User_ID = $user_id";
$result = mysqli_query($connect, $query);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . mysqli_error($connect));
}
?>
<form action="components/logout.php" method="post" class="px-2">
    <!-- Initial Logout Button (appears first) -->
    <button id="logout-btn" class="admin_btn" type="button" onclick="toggleNav()">Logout</button>

    <!-- Navigation Bar for account switching and logout options (Initially hidden) -->
    <div id="nav-bar" class="nav-bar shadow" style="display: none;">         
        <div class="row">
            <div class="col-md-10 d-flex mt-1 align-items-center">
                <!-- Display the active user's email -->
                <?php
                    $user_active = "SELECT User_EmailAddress FROM user WHERE User_ID = $user_id";
                    $active_result = mysqli_query($connect, $user_active);

                    if ($active_result) {
                        $active = mysqli_fetch_assoc($active_result);
                        $active_email = htmlspecialchars($active['User_EmailAddress']);
                        echo "<div class='container'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-12'>";
                                    echo "<h5 class='c-2E4F21'>" . $active_email . "</h5>";
                                echo "</div>";
                                echo "<div class='col-md-12 px-3'>";
                                    echo "<div class=". 'text-success rounded' . ">Active</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    } else {
                        echo "No active user found.";
                    }
                ?>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <!-- Dropdown to choose an account to switch to -->
            <div class="col-md-12">
                <select name="account" class="admin_dropdown mb-2" onchange="toggleSwitchButton()">
                    <option value="" disabled selected>Your Accounts</option>
                    <?php
                        // Loop through the users to populate the dropdown list
                        while ($account = mysqli_fetch_assoc($result)) {
                            $emails = htmlspecialchars($account['Switch_Email']);
                            $userId = $account['Switch_ID'];
                            echo "<option value=\"$userId\">$emails</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn-add-email" onclick="toggleAddEmailForm()">Add New Email</button>
                <span>|</span>
                <button type="button" class="btn-remove-email" onclick="toggleRemoveEmailForm()">Remove Email</button>
            </div>

            <!-- The form for adding a new email (Initially hidden) -->
            <div id="add-email-form" style="display: none;">
                <input type="text" name="new_email" class="mb-2 rounded new-email-input" placeholder="Add New Email" width="50px" autofocus oninput="toggleAddButton()">
                <button class="btn btn-sm bg-1e5915 c-e9ffff" type="submit" name="action" value="add_email" id="add-email-btn" disabled><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <!-- The form for removing an email (Initially hidden) -->
            <div id="remove-email-form" style="display: none;">
                <select name="remove_email" class="admin_dropdown" onchange="toggleRemoveButton()">
                    <option value="" disabled selected>Delete Email</option>
                    <?php
                        // Loop through the users to populate the remove email dropdown
                        mysqli_data_seek($result, 0); // Reset result pointer to fetch again
                        while ($account = mysqli_fetch_assoc($result)) {
                            $emails = htmlspecialchars($account['Switch_Email']);
                            $userId = $account['Switch_ID'];
                            echo "<option value=\"$userId\">$emails</option>";
                        }
                    ?>
                </select>
                <button class="btn btn-sm bg-danger c-e9ffff" type="submit" name="action" value="remove_email" id="remove-email-btn" disabled><i class="fa fa-minus" aria-hidden="true"></i></button>
            </div>

            <div class="col-md-12 mt-4">
                <!-- Button to switch accounts, initially disabled -->
                <button class="btn btn-md bg-1e5915 c-e9ffff" type="submit" name="action" value="switch" id="switch-btn" disabled>Switch Account</button>
                <!-- Logout Button -->
                <button class="btn btn-md bg-1e5915 c-e9ffff mx-2" type="submit" name="action" value="logout">Logout</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Toggle the visibility of the navigation bar
    function toggleNav() {
        var navBar = document.getElementById('nav-bar');
        var logoutBtn = document.getElementById('logout-btn');
        
        if (navBar.style.display === 'none') {
            navBar.style.display = 'block';
            logoutBtn.style.color = "#cfe1b9";
        } else {
            navBar.style.display = 'none';
            logoutBtn.style.color = "black";
        }
    }

    // Function to enable/disable the switch button based on dropdown selection
    function toggleSwitchButton() {
        var dropdown = document.querySelector("select[name='account']");
        var switchBtn = document.getElementById("switch-btn");

        if (dropdown.value) {
            switchBtn.disabled = false;  // Enable the switch button if a valid option is selected
        } else {
            switchBtn.disabled = true;  // Disable the switch button if no option is selected
        }
    }

    // Function to toggle the visibility of the "Add New Email" form
    function toggleAddEmailForm() {
        var addEmailForm = document.getElementById('add-email-form');
        
        if (addEmailForm.style.display === 'none' || addEmailForm.style.display === '') {
            addEmailForm.style.display = 'block';  // Show the form
        } else {
            addEmailForm.style.display = 'none';  // Hide the form
        }
    }

    // Function to toggle the visibility of the "Remove Email" form
    function toggleRemoveEmailForm() {
        var removeEmailForm = document.getElementById('remove-email-form');
        
        if (removeEmailForm.style.display === 'none' || removeEmailForm.style.display === '') {
            removeEmailForm.style.display = 'block';  // Show the form
        } else {
            removeEmailForm.style.display = 'none';  // Hide the form
        }
    }

    // Function to enable the "Add Email" button only when text is entered in the input
    function toggleAddButton() {
        var input = document.querySelector("input[name='new_email']");
        var addBtn = document.getElementById("add-email-btn");

        if (input.value.trim()) {
            addBtn.disabled = false;  // Enable the button if the input is not empty
        } else {
            addBtn.disabled = true;  // Disable the button if the input is empty
        }
    }

    // Function to enable the "Remove Email" button only when an email is selected
    function toggleRemoveButton() {
        var dropdown = document.querySelector("select[name='remove_email']");
        var removeBtn = document.getElementById("remove-email-btn");

        if (dropdown.value) {
            removeBtn.disabled = false;  // Enable the button if an email is selected
        } else {
            removeBtn.disabled = true;  // Disable the button if no email is selected
        }
    }
</script>
