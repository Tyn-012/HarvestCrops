<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
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
                <form action="components/logout.php" method="post" target="customer_support_page.php">
                    <button class="btn btn-sm text-md pt-2 fw-bold" type="submit">Logout</button>
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
                        <a class="anc-page px-3" href="customer_support_page.php">Customer Support</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <form action="components/customer_support.php" method="post" class="mb-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center m-2 p-2 pt-5">
                        <h2>Contact Us</h2>
                    </div>
                    <div class="p-2 bg-dark mb-4"></div>
                    <div class="container p-4">
                        <div class="section">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <span class="d-flex justify-content-center">
                                        <span class="customer-support">
                                        </span>
                                    </span>
                                    <div class="container custom-support-query-bg p-5">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center mb-4">     
                                                    <h3>Online Inquiry</h3>
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
                                                    <button class="btn btn-md bg-dark text-light rounded button-ds" type="submit"
                                                        name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="../src/FAQS_page.html"><p class="text-decoration-none text-dark d-flex justify-content-center">Frequently Asked Questions</p></a>
                                    </div>
                                </div>            
                                <div class="col-md-6 mx-auto">
                                    <div class="container p-5">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center mb-4">
                                                    <h3>Contact Details</h3>
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
                                                    <p><i class="fas fa-phone"></i> +63 969-4875-359</p>
                                                </div>
                                                <!-- Email Address -->
                                                <div class="col-md-6">
                                                    <h5>Email</h5>
                                                    <p><i class="fas fa-envelope"></i> <a href="mailto:contact@harvestcrops.com">contact@harvestcrops.com</a></p>
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
                                                        <a href="https://www.facebook.com" class="btn btn-primary btn-sm"><i class="fab fa-facebook"></i> Facebook</a>
                                                        <a href="https://x.com/?lang=en-my" class="btn btn-info btn-sm"><i class="fab fa-twitter"></i> Twitter</a>
                                                        <a href="https://www.youtube.com/" class="btn btn-danger btn-sm"><i class="fab fa-youtube"></i> YouTube</a>
                                                        <a href="https://www.linkedin.com/" class="btn btn-success btn-sm"><i class="fab fa-linkedin"></i> LinkedIn</a>
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
    <div class="p-2 bg-warning acc_add_tab-margin-top"></div>
    <footer class="nav bg-397F35">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                            <li class="nav-item"><a href="javascript:history.back();" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="../src/FAQS_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
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