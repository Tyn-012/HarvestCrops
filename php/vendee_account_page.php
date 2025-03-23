<!--CONSIDERED AS THE BUYER / RENAMED (Vendee)-->
<?php
include 'components/connect.php';


if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$name = $_SESSION['name'];
$_SESSION['user_type'] = "Vendor";
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
    <title>HarvestCrops - Vendee Account Page</title>
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
                        <a class="anc-page px-3 c-cfe1b9" href="vendee_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="store_page.php">Shop</a>
                        <a class="anc-page px-3" href="customer_support_page_vendee.php">Customer Support</a>
                        <a class="anc-page px-3" href="cart_page.php">Cart</a>
                        <?php include 'components/logout_component.php'?>

                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div class="container mt-4 p-4">
        <div class="row">
            <div class="col">
                <div class="section">
                    <div class="row py-5 d-flex justify-content-center align-items-center">
                        <div class="col-md-4 mb-5">
                            <div class="col-md-12 pb-2">
                                <div class="section d-flex justify-content-center align-items-center">
                                    <img src="../images/temp_icon.jpg" class="bg-cfe1b9 rounded-circle shadow" height="150px" width="150px" alt=""><br>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center mt-2 ">
                                <h4><?php echo $name; ?></h4>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 pad-top-acc"></div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <p class="rounded p-2">Vendee</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-5">
                            <div class="col-md-12">
                                <h2 class="d-flex justify-content-center align-items-center c-2E4F21 mb-5">
                                    Manage your profile information
                                </h2>
                                <div class="bg-1E5915 p-1 rounded mb-4 me-3"></div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="c-2E4F21">Account Modification & Updates</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a class="btn btn-md bg-1e5915 c-e9ffff my-4 py-1" href="account_info_update.php">Modify Personal Account Details</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-md bg-1e5915 c-e9ffff my-4 py-1" href="vendee_details_update.php">Modify Vendee Information</a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-1E5915 p-1 rounded mb-4 me-3 mt-4"></div>
                            <div class="col-md-6">
                                <h4 class="c-2E4F21">Schedules & Events</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="user_notice.php" class="btn btn-md bg-1e5915 c-e9ffff my-4">
                                        Organizational Events and Updates
                                        </a>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-1E5915"></div>
    <footer class="nav bg-84B68F">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center">
                        <li class="nav-item nav-a"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item nav-a"><a href="../src/FAQS_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        </ul>
                        <hr>
                        <span class="d-flex justify-content-center fw-bold"> &copy; 2024 AspireProgrez - All Rights Reserved</span> <!-- EDIT -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>