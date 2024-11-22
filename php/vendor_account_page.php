<?php
include 'components/user_details.php'
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
    <title>HarvestCrops</title>
</head>
<body>
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
                <a href="#" class="fa-regular fa-envelope icon-ds p-1 m-1"></a>
                <a href="#" class="fa-solid fa-globe icon-ds p-1 m-1"></a>
                <a href="#" class="fa-regular fa-bell icon-ds p-1 m-1"></a>
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
                        <a class="anc-page px-3" href="vendor_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="store_page.php">Shop</a>
                        <a class="anc-page px-3" href="../src/customer_support_page.html">Customer Support</a>
                        <a class="anc-page px-3" href="cart_page.php">Cart</a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-dark mb-4"></div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section d-flex justify-content-center align-items-center">
                                    <img src="../images/farm.jpg" class="border rounded-circle" height="150px" width="150px" alt=""><br>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <h4><?php echo $name; ?></h4>
                            </div>
                            <div class="p-1 bg-dark mb-4"></div>
                            <div class="col-md-12">
                                <a href="#" class="d-flex align-items-center justify-content-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                                    <span class="fs-5 d-none d-sm-inline">My Account</span>
                                </a>
                                <a href="#" class="d-flex align-items-center justify-content-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                                    <span class="fs-5 d-none d-sm-inline">My Purchase</span>
                                </a>
                                <a href="#" class="d-flex align-items-center justify-content-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                                    <span class="fs-5 d-none d-sm-inline">Notifications</span>
                                </a>
                                <a href="#" class="d-flex align-items-center justify-content-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                                    <span class="fs-5 d-none d-sm-inline">Following</span>
                                </a>
                                <a href="#" class="d-flex align-items-center justify-content-center pb-3 mb-md-0 me-md-auto text-decoration-none">
                                    <span class="fs-5 d-none d-sm-inline">Settings</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="container border">
                    <div class="section">
                        <div class="row">
                            <div class="col-md-12 p-2 m-2">
                                <p>Profile<br>
                                Manage your profile information
                                </p>
                                <div class="bg-dark p-1 mb-4 me-3"></div>
                            </div>
                            <div class="col-md-6 p-2 m-2 mx-4">
                                <h4>Account Modification & Updates</h4>
                                <a class="btn btn-md bg-dark text-light my-4 py-2" href="../src/account_details_update.html">Modify Personal Account Details</a>
                                <a class="btn btn-md bg-dark text-light my-4 py-2" href="../src/vendor_info_update.html">Modify Vendor Information</a>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <!--
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <img src="../images/plots.jpg" class="border rounded-circle" height="150px" width="150px" alt="">
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <a class="btn btn-md bg-dark text-light py-2">Edit</a>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning"></div>
    <footer class="nav bg-success">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                            <li class="nav-item"><a href="vendor_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="customer_support_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
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