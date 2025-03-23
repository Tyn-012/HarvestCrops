<?php
// Start session if not already started
session_start();

include 'components/connect.php'; // Ensure correct database connection

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Fetch organization notice data from database
$query = "SELECT * FROM organization_notice";
$org_notice_data = mysqli_query($connect, $query);

// Check if the query was successful
if (!$org_notice_data) {
    die("Query failed: " . mysqli_error($connect));
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
    <title>HarvestCrops - Notice</title>
</head>

<body class="bg-F0E5AF body-font">
    <nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section" >
                <div class="row d-flex justify-content-center align-items-center p-1" >
                    <div class="col-md-4 mt-2">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">                       
                        <a class="anc-page px-3" href="javascript:history.back();">My Account</a>
                        <a class="anc-page px-3 c-cfe1b9" href="user_notice.php">Notices</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div class="container-fluid mb-5 mt-2">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section">
                        <h3 class="py-2 m-2 c-2E4F21">Events and Schedules</h3>
                        <?php
                        // Loop through fetched organization notice records
                        while ($row = mysqli_fetch_assoc($org_notice_data)) {
                            $notice_id = $row['Notice_ID']; // Correct assignment of the Notice_ID

                            // Format the date
                            $notice_schedule = strtotime($row['Notice_Schedule']);  // Convert the date string to timestamp
                            $formatted_date = date("F j, Y, g:i a", $notice_schedule); // Format the date

                        echo'
                        <div class="row">
                            <div class="col-md-2 p-4 my-3 bg-1E5915 text-light rounded-2 shadow">
                                <div class=" d-flex justify-content-center align-items-center">
                                    <p class="fs-5">' . htmlspecialchars($row['Notice_Title']) . '</p> 
                                </div>
                            </div>
                            <div class="col-md-10 p-3 my-3 bg-cfe1b9 rounded-2 shadow">
                                <div class="pt-2 text-decoration-underline">' . htmlspecialchars($row['Organization_Name']) . '</div>
                                <div class="pt-2 fst-italic">' . $formatted_date . '</div> <!-- Display formatted date here -->
                                <div class="pt-2">' . htmlspecialchars($row['Notice_Content']) . '</div>
                            </div>
                        </div>
                        <hr>
                        ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
