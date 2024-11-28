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
    <title>HarvestCrops - Notice</title>
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
    <nav class="p-3 bg-397F35">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <a class="anc-page px-3" href="javascript:history.back();">My Account</a>
                        <a class="anc-page px-3" href="user_notice.php">Notices</a>
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
                        <h3 class="py-2 m-2 fw-bold">Events and Schedules</h3>
                        <?php
                        // Loop through fetched organization notice records
                        while ($row = mysqli_fetch_assoc($result)) {
                            $notice_id = $row['Notice_ID']; // Correct assignment of the Notice_ID
                        echo'
                        <div class="row">
                            <div class="col-md-2 p-4 my-3 bg-397F35 text-light rounded-2">
                                <div class=" d-flex justify-content-center align-items-center">
                                    <p class="fs-5">' . htmlspecialchars($row['Notice_Title']) . '</p> 
                                </div>
                            </div>
                            <div class="col-md-9 p-3 my-3 bg-F5BD22">
                                <div class="pt-2 text-decoration-underline">' . htmlspecialchars($row['Organization_Name']) . '</div>
                                <div class="pt-2 fst-italic">' . htmlspecialchars($row['Notice_Schedule']) . '</div>
                                <div class="pt-2">' . htmlspecialchars($row['Notice_Content']) . '</div>
                            </div>
                            <div class="col-md-1 p-3 my-3 bg-F5BD22">
                                
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
