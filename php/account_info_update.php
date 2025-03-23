<?php
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$getuser_info_qry = "SELECT * FROM user WHERE User_ID = ?";
$stmt = $connect->prepare($getuser_info_qry);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $user_firstN = $row['User_FirstName'];
    $user_MiddleN = $row['User_MiddleName'];
    $user_LastN = $row['User_LastName'];
    $dateofBirth = $row['User_BirthDate'];
    $gender = $row['User_Gender'];
    $mobile = $row['User_MobileNumber'];
    $dateTime = new DateTime($dateofBirth);

    $year = $dateTime->format('Y');   // 1981
    $month = $dateTime->format('m');  // 02
    $day = $dateTime->format('d');    // 02
    
}

$getuser_address_qry = "SELECT * FROM user_address WHERE User_ID = ?";
$stmt = $connect->prepare($getuser_address_qry);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {

    $address = $row['User_Address'];
    $island = $row['Island_Group'];
    $region = $row['Region'];
    $city = $row['City'];
    $barangay = $row['Barangay'];
    $zip = $row['zip_code'];
    
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
    <title>HarvestCrops - Account Update Page</title>
</head>
<body class="bg-cfe1b9 modify_account_details_body">
    <section>
        <form class="pt-4" action="components/account_details_update.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 rounded-4 mb-4 shadow">
                    <div class="row p-4 m-4 d-flex justify-content-start align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none c-397F35 mb-5"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center c-2E4F21">Update User Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><div class="bg-1E5915 p-1 rounded mb-4 me-3"></div></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Account Name</label>
                        <div class="col-md-4">
                            <input type="text" name="firstname" value="<?php echo $user_firstN; ?>" class="form-control mb-2"
                                placeholder="First Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="middlename" value="<?php echo $user_MiddleN; ?>" class="form-control mb-2"
                                placeholder="Middle Name" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="lastname" value="<?php echo $user_LastN; ?>" class="form-control mb-2"
                                placeholder="Last Name" required autofocus>
                        </div>
                        <div class="col-md-12">
                            <label class="pt-3 mb-2 fw-bold">Birth Date</label>
                        </div>
                        <div class="col-md-3">
                            <select name="birth-month" class="form-control" id="Month" required onchange="updateDays()">
                                <option value="" disabled>Month</option>
                                <option value="1" <?php echo ($month == 1) ? 'selected' : ''; ?>>January</option>
                                <option value="2" <?php echo ($month == 2) ? 'selected' : ''; ?>>February</option>
                                <option value="3" <?php echo ($month == 3) ? 'selected' : ''; ?>>March</option>
                                <option value="4" <?php echo ($month == 4) ? 'selected' : ''; ?>>April</option>
                                <option value="5" <?php echo ($month == 5) ? 'selected' : ''; ?>>May</option>
                                <option value="6" <?php echo ($month == 6) ? 'selected' : ''; ?>>June</option>
                                <option value="7" <?php echo ($month == 7) ? 'selected' : ''; ?>>July</option>
                                <option value="8" <?php echo ($month == 8) ? 'selected' : ''; ?>>August</option>
                                <option value="9" <?php echo ($month == 9) ? 'selected' : ''; ?>>September</option>
                                <option value="10" <?php echo ($month == 10) ? 'selected' : ''; ?>>October</option>
                                <option value="11" <?php echo ($month == 11) ? 'selected' : ''; ?>>November</option>
                                <option value="12" <?php echo ($month == 12) ? 'selected' : ''; ?>>December</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <select name="birth-day" class="form-control" id="Day" required>
                                <!-- Dynamically populate the days -->
                                <option value="" disabled <?php echo ($day == "") ? 'selected' : ''; ?>>Day</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="birth-year" class="form-control" id="Year" required onchange="updateDays()">
                                <option value="" disabled <?php echo ($year == "") ? 'selected' : ''; ?>>Year</option>
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

                                        // Check if the year matches the user's birth year, if so, select it
                                        if (year === <?php echo $year; ?>) {
                                            option.selected = true;
                                        }

                                        yearSelect.appendChild(option);
                                    }

                                    // Initialize the day options based on the selected month and year
                                    updateDays();
                                };

                                // Function to update the number of days based on the month and year
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

                                        // Check if the day matches the user's birth day, if so, select it
                                        if (i == <?php echo $day; ?>) {
                                            option.selected = true;
                                        }

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
                            </script>
                        </div>                                    
                        <div class="col-md-3">
                            <select name="userGender" class="form-control" id="gender" required>
                                <option value="Gender" disabled <?php echo ($gender == "") ? 'selected' : ''; ?>>Gender</option>
                                <option value="Male" <?php echo ($gender == "Male") ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($gender == "Female") ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($gender == "Other") ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="pt-5 mb-2 fw-bold">Address</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="HomeAdd" class="form-control mb-2" value = "<?php echo $address; ?>" placeholder="Home Address" required autofocus>
                        </div>
                        <div class="col-md-5 mt-2">
                            <input class="address-inp-ds form-control" value = "<?php echo $island; ?>"  name="IslandGroup" id="Island" placeholder="Island Group" required>
                        </div>
                        <div class="col-md-5 mt-2">
                            <input class="address-inp-ds form-control" value = "<?php echo $city; ?>"  name="City" id="City" placeholder="City" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ZIP" class="mt-3 form-control mb-2" value = "<?php echo $zip; ?>" 
                            placeholder="ZIP Code" required autofocus>
                        </div>
                        <div class="col-md-5">
                            <input class="address-inp-ds form-control" value = "<?php echo $region; ?>"  name="Region" id="Region" placeholder="Region" required>
                        </div>
                        <div class="col-md-5">
                            <input class="address-inp-ds form-control" value = "<?php echo $barangay; ?>"  name="Barangay" id="Barangay" placeholder="Barangay" required>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-12">
                            <label class="pt-5 mb-2 fw-bold">Account Information</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="MobileNum" class="mt-3 form-control mb-2"
                            placeholder="Mobile Number" value="<?php echo $mobile; ?>" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="Password" class="mt-3 form-control mb-2"
                            placeholder="Password" autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="Re-enterpass" class="mt-3 form-control mb-2"
                            placeholder="Re-enter Password" autofocus>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 acc_updates_ds align-items-center pt-4">
                            <button class="btn btn-lg rounded button-ds" type="submit"
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