<?php
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}
$name = $_SESSION['name'];
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
    <title>HarvestCrops - Organization Page</title>
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
                        <a class="anc-page px-3" href="notices_page.php">Notices</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="section">
                    <div class="row py-5">
                        <div class="col-md-4 mb-5">
                            <div class="col-md-12">
                                <div class="section d-flex justify-content-center align-items-center">
                                    <img src="../images/farm.jpg" class="border rounded-circle" height="150px" width="150px" alt=""><br>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center mt-2">
                                <h4><?php echo $name; ?></h4>
                            </div>
                        </div>
                        <div class="col-md-8 mb-5">
                            <div class="col-md-12">
                                <p>Profile<br>
                                Manage your profile information
                                </p>
                                <div class="bg-dark p-1 mb-4 me-3"></div>
                            </div>
                            <div class="col-md-6">
                                <h4>Account Modification & Updates</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-md bg-dark text-light my-4 py-2" href="account_info_update.php">Modify Personal Account Details</a>
                                    </div>
                                    <div class="col-md-12">
                                        <a class="btn btn-md bg-dark text-light my-4 py-2" href="organization_details_update.php">Modify Organization Information</a>
                                    </div>
                                    <div class="col-md-12">
                                        <a class="btn btn-md bg-dark text-light my-4 py-2" href="notice_creation_page.php">Create Notice</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning "></div>
    <footer class="nav bg-success">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                            <li class="nav-item"><a href="vendor_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="customer_support_page.php" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-4 d-flex justify-content-center align-items-center">
                        <span> &copy; Copyrights. All rights reserved to Leila Aliyah J. Manalo | John Lloyd B. Dela Cruz | Vince Wackie Espera
                            | Jezreel Anne C. Jaynos</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>