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
$result = mysqli_query($connect, $query);

// Check if the query was successful
if (!$result) {
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
    <title>HarvestCrops - Notice Page</title>
</head>

<body class="bg-cfe1b9">
    <nav class="nav pt-5 mx-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-1">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (Circle).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-11">
                        <h4>HarvestCrops: Agri-Marketplace Connecting Farmers, Retailers, and Traders Seamlessly</h4>
                        <p>"Harvest Your Potential: Connect, Trade, and Thrive in Our Agricultural Marketplace!"</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="section mx-5 mb-3">
            <div class="col-md-12 d-flex justify-content-end">
                <form action="components/logout.php" method="post">
                    <button class="btn btn-sm text-md fw-bold m-1" type="submit">Logout</button>
                </form>
                <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
            </div>
        </div>
    </div>
    <nav class="p-3 bg-success">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <a class="anc-page px-3" href="organization_page.php">My Account</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mb-5 mt-2">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section">
                        <div class="row bg-warning mb-2 p-2 m-4 notice_display rounded-3">
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Organization Name</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Notice Schedule</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center">
                                <p>Notice Title</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center">
                                <p>Notice Content</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Action</p>
                            </div>
                        </div>
                        <?php
                        // Loop through fetched organization notice records
                            while ($row = mysqli_fetch_assoc($result)) {
                                $notice_id = $row['Notice_ID']; // Correct assignment of the Notice_ID
                                $org_name = $row['Organization_Name'];
                                $notice_sched = $row['Notice_Schedule'];
                                $notice_title = $row['Notice_Title'];
                                $notice_content = $row['Notice_Content'];
                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 border m-4 rounded-3 bg-ECF39E">
                                    <div class="col-md-2 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($org_name) . '</div>
                                    <div class="col-md-2 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($notice_sched) . '</div>
                                    <div class="col-md-3 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($notice_title) . '</div>
                                    <div class="col-md-3 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($notice_content) . '</div>
                                    <div class="col-md-2 d-flex justify-content-center pb-2"><hr>
                                        <form action="components/remove_notice.php" method="post">
                                            <input type="hidden" name="notice_id" value="' . $notice_id . '">
                                            <button name="cancel" class="btn btn-sm bg-dark text-light mx-4">Cancel</button>
                                        </form>
                                    </div>
                                </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
