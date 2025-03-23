<?php
// Start session if not already started
session_start();

include 'components/connect.php'; // Ensure correct database connection

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}


$user_id = $_SESSION['user_id'];

$getorg_info_qry = "SELECT * FROM organization_details WHERE Organization_ID = ?";
$stmt = $connect->prepare($getorg_info_qry);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $org_ID = $row['Organization_ID'];
}

// Fetch organization notice data from database
$query = "SELECT * FROM organization_notice WHERE Organization_ID = " . $user_id;
$org_notice_data = mysqli_query($connect, $query);

// Check if the query was successful
if (!$org_notice_data) {
    die("Query failed: " . mysqli_error($connect));
}

$row_count = mysqli_num_rows($org_notice_data);
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
                        <a class="anc-page px-3" href="organization_page.php">My Account</a>
                        <a class="anc-page px-3 c-cfe1b9" href="notices_page.php">Notices</a>
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
                        <!-- Display headers only if there are notices -->
                            <div id="notice_ds" class="row bg-1E5915 text-light mb-2 p-2 m-4 notice_display rounded-3">
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
                        if ($row_count == 0){
                            echo "
                            <div class=\"col-md-12 d-flex align-items-center px-5\">".
                            "No notices found.".
                            "</div>";
                        }
                        while ($row = mysqli_fetch_assoc($org_notice_data)) {
                            $notice_id = $row['Notice_ID']; // Correct assignment of the Notice_ID
                            $org_name = $row['Organization_Name'];
                            $notice_sched = $row['Notice_Schedule'];
                            $notice_title = $row['Notice_Title'];
                            $notice_content = $row['Notice_Content'];
                            echo '
                            <div class="row d-flex align-items-center mb-2 ps-2 shadow-lg m-4 rounded-3 bg-cfe1b9">
                                <div class="col-md-2 d-flex justify-content-start fw-bold px-4 py-3">' . htmlspecialchars($org_name) . '</div>
                                <div class="col-md-2 d-flex justify-content-start  px-4 py-3">' . htmlspecialchars($notice_sched) . '</div>
                                <div class="col-md-3 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($notice_title) . '</div>
                                <div class="col-md-3 d-flex justify-content-start px-4 py-3">' . htmlspecialchars($notice_content) . '</div>
                                <div class="col-md-2 d-flex justify-content-center pb-2"><hr>
                                    <form action="components/remove_notice.php" method="post">
                                        <input type="hidden" name="notice_id" value="' . $notice_id . '">
                                        <button name="cancel" class="btn btn-sm bg-1e5915 c-e9ffff mx-4">Cancel</button>
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
