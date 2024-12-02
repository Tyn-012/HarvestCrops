<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $_SESSION['user-id'] = $user_id;
} else {
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.min.js" rel="script"></script>
    <title>HarvestCrops - Admin Page Update</title>
</head>
<body class="admin_update_bg">
    <section class="mt-5 pt-5">
        <form class="rounded" action="components/account_updates.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 mb-4 rounded-4">
                    <div class="row p-4 m-4 d-flex justify-content-start align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none text-dark mb-5"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center mb-5">Update User Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><hr class="rounded bg-dark p-1"></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Account Name</label>
                        <div class="col-md-4">
                            <input type="text" name="firstname" class="form-control mb-2"
                                placeholder="First Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="middlename" class="form-control mb-2"
                                placeholder="Middle Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="lastname" class="form-control mb-2"
                                placeholder="Last Name" required autofocus>
                        </div>
                        <div class="col-md-12">
                            <label class="pt-3 mb-2 fw-bold">Birth Date</label>
                        </div>
                        <div class="col-md-3">
                            <select name="birth-month" class="form-control" id="Month" required onchange="updateDays()">
                                <option value="" disabled selected>Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="birth-day" class="form-control" id="Day" required>
                                <option value="" disabled selected>Day</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="birth-year" class="form-control" id="Year" required onchange="updateDays()">
                                <option value="" disabled selected>Year</option>
                            </select>

                            <script>
                            // JavaScript to dynamically populate the year options
                            window.onload = function() {
                                const yearSelect = document.getElementById("Year");
                                const startYear = 1980;
                                const endYear = 2024;
                                
                                // Loop to add options from 1980 to 2024
                                for (let year = startYear; year <= endYear; year++) {
                                    const option = document.createElement("option");
                                    option.value = year;
                                    option.textContent = year;
                                    yearSelect.appendChild(option);
                                }
                            };
                            </script>
                        </div>

                        <script>
                            // Function to update the number of days based on month and year
                            function updateDays() {
                                const month = document.getElementById("Month").value;
                                const year = document.getElementById("Year").value;
                                const daySelect = document.getElementById("Day");
                                
                                // Clear previous day options
                                daySelect.innerHTML = '<option value="" disabled selected>Day</option>';
                                
                                if (!month || !year) return;  // If either month or year is not selected, do nothing
                                
                                // Determine the number of days in the selected month/year
                                let daysInMonth = getDaysInMonth(month, year);
                                
                                // Add day options dynamically based on the number of days
                                for (let i = 1; i <= daysInMonth; i++) {
                                    const option = document.createElement("option");
                                    option.value = i;
                                    option.text = i;
                                    daySelect.appendChild(option);
                                }
                            }

                            // Function to get the number of days in a given month and year
                            function getDaysInMonth(month, year) {
                                // January, March, May, July, August, October, December have 31 days
                                if ([1, 3, 5, 7, 8, 10, 12].includes(parseInt(month))) {
                                    return 31;
                                }
                                // April, June, September, November have 30 days
                                if ([4, 6, 9, 11].includes(parseInt(month))) {
                                    return 30;
                                }
                                // February - check for leap year
                                if (parseInt(month) === 2) {
                                    return isLeapYear(year) ? 29 : 28;
                                }
                                return 0; // Invalid month
                            }

                            // Function to check if a year is a leap year
                            function isLeapYear(year) {
                                return (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0));
                            }

                            // Initialize the day options on page load (in case the month/year is pre-selected)
                            updateDays();
                        </script>

                        
                        <div class="col-md-3">
                            <select name="userGender" class="form-control" id="gender" required>
                                <option value="Gender" disabled selected>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-12">
                            <label class="pt-5 mb-2 fw-bold">Account Information</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="EmailAdd" class="mt-3 form-control mb-2"
                            placeholder="Email Address" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="MobileNum" class="mt-3 form-control mb-2"
                            placeholder="Mobile Number" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="Password" class="mt-3 form-control mb-2"
                            placeholder="Password" required autofocus>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 acc_updates_ds align-items-center pt-4">
                            <button class="btn btn-lg bg-secondary rounded button-ds" type="submit"
                                name="submit">Update
                                Account</button>
                        </div>
                            
                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>
</html>
