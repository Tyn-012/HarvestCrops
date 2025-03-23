<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if($_SESSION['user_type']=="Farmer"){
    $user_type = "farmer_account_page.php";
}
else if($_SESSION['user_type']=="Vendor"){
    $user_type = "vendee_account_page.php";
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
    <title>HarvestCrops - Customer Support Page</title>
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
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3" href="seller_store_page.php">Shop</a>
                        <a class="anc-page px-3 c-cfe1b9" href="customer_support_page_vendor.php">Customer Support</a>
                        <a class="anc-page px-3" href="order_page.php">Orders</a>
                        <a class="anc-page px-3" href="inventory_page.php">Inventory</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <form action="components/customer_support.php" method="post" class="mb-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center m-2 p-2 pt-5">
                        <h2 class="c-2E4F21">Contact Us</h2>
                    </div>
                    <div class="p-2 bg-1E5915 mb-4 rounded"></div>
                    <div class="container p-4">
                        <div class="section">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <span class="d-flex justify-content-center">
                                        <span class="customer-support">
                                        </span>
                                    </span>
                                    <div class="container custom-support-query-bg p-5 shadow">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center mb-4">     
                                                    <h3 class="c-2E4F21">Online Inquiry</h3>
                                                </div>
                                                <hr>   
                                                <div class="col-md-12 mb-4">
                                                    <label class="fw-bold d-flex justify-content-center">Userame</label>
                                                    <input type="text" name="custom-username" class="form-control mb-2"
                                                        placeholder="Username" required autofocus>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <label class="fw-bold d-flex justify-content-center">Email</label>
                                                    <input type="text" name="custom-email" class="form-control mb-2"
                                                        placeholder="Email Address" required autofocus>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <label class="fw-bold d-flex justify-content-center">Mobile Number</label>
                                                    <input type="text" name="custom-number" class="form-control mb-2"
                                                        placeholder="Mobile Number" required autofocus>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <label class="fw-bold">Write your Questions: </label>
                                                    <textarea class="form-control" placeholder="input your text here..." rows="3" name="custom-question" required></textarea>
                                                </div>
                                                <div class="col-md-12 mb-4 d-flex justify-content-center align-items-center">
                                                    <button class="btn btn-md bg-1e5915 c-e9ffff button-ds" type="submit"
                                                        name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="text-decoration-none" href="../src/FAQS_page.html"><p class="c-2E4F21 d-flex justify-content-center">Frequently Asked Questions</p></a>
                                    </div>
                                </div>            
                                <div class="col-md-6 mx-auto">
                                    <div class="container p-5">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center mb-4">
                                                    <h3 class="c-2E4F21">Contact Details</h3>
                                                </div>
                                                <hr>
                                            </div>
                                            <!-- Contact Information Section -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>HarvestCrops</h4>
                                                    <p>Agri-Marketplace Connecting Farmers, Retailers, and Traders Seamlessly.</p>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <!-- Phone Number -->
                                                <div class="col-md-6">
                                                    <h5>Phone</h5>
                                                    <p><i class="fas fa-phone"></i> +63 969-177-9124</p>
                                                </div>
                                                <!-- Email Address -->
                                                <div class="col-md-6">
                                                    <h5>Email</h5>
                                                    <p><i class="fas fa-envelope"></i> <a class="text-decoration-none text-secondary" href="https://mail.google.com/mail/u/0/#inbox?compose=GTvVlcSBpRVrbtWMThkBVHVGflgWFthjLpGZzbtLTWcFLgdHhxHqlhDrmvBhcHdqdSrMHfxdcFzlZ" target="_blank">harvestcropsofficial@gmail.com</a></p>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <!-- Physical Address -->
                                                <div class="col-md-12">
                                                    <h5>Address</h5>
                                                    <p><i class="fas fa-map-marker-alt"></i> Tanza Cavite, Philippines</p>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <!-- Social Media -->
                                                <div class="col-md-12">
                                                    <h5>Follow Us</h5>
                                                    <p>
                                                        <a href="https://www.facebook.com/profile.php?id=61573435665561" class="btn-primary btn-sm mb-2 text-decoration-none me-2 text-secondary" target="_blank"><i class="fab fa-facebook text-secondary"></i> Facebook</a>
                                                        <a href="https://x.com/?lang=en-my" class="btn-info btn-sm mb-2 text-decoration-none text-secondary"><i class="fab fa-twitter text-secondary" target="_blank"></i> Twitter</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2 bg-1E5915"></div>
    <footer class="nav bg-84B68F">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center">
                        <li class="nav-item nav-a"><a href=<?php echo $user_type;?> class="nav-link px-2 text-body-secondary">Home</a></li>
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