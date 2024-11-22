<?php
session_start();
include 'components/connect.php';
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
                        <p>Harvest Your Potential: Connect, Trade, and Thrive in Our Agricultural Marketplace!</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="section mx-5 mb-3">
            <div class="col-md-12 d-flex justify-content-end">
                <h4>ADMIN</h4>
            </div>
        </div>
    </div>
    <div class="p-2 bg-warning"></div>
    <nav class="p-3 bg-success">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <img src="../images/plots.jpg" class="border rounded-circle" width="60px" height="60px" alt="">
                        <p class="anc-page px-2 pt-2"><?php echo $_SESSION['name']; ?></p>
                    </div>
                    <div class="col-md-8 d-flex align-items-center justify-content-end">
                        <input class="p-1" id="search-input" type="text" placeholder="Search..">
                        <a href="#" id="icon-search" class="fa-solid fa-magnifying-glass p-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Manage Users</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <a href="#" class="text-decoration-none text-light fw-bolder">SETTINGS</a>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center align-items-center pb-5">
                        <form action="components/logout.php" method="post">
                            <button class="btn btn-sm text-md text-light bg-dark" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col py-5">
                <div class="container">
                    <div class="section">
                        <div class="row bg-warning mb-2 ps-2">
                            <div class="col-md-1 d-flex justify-content-center">
                                <p>ID</p>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center">
                                <p>Profile</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Mobile Number</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p>Type</p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center">
                                <p>Action</p>
                            </div>
                        </div>
                        
                        <?php
                        // SQL Query to join 'user' and 'user_type' tables
                        $getuser_info_qry = "
                            SELECT u.User_ID, u.User_FirstName, u.User_MiddleName, u.User_LastName, u.User_MobileNumber, ut.Type_Name 
                            FROM user u
                            JOIN user_type ut ON u.Type_ID = ut.Type_ID
                        ";

                        $stmt = $connect->prepare($getuser_info_qry);
                        $stmt->execute();
                        $user_info_result = $stmt->get_result();  

                        // Loop through users and display only Farmer or Vendor
                        while ($row = $user_info_result->fetch_assoc()) {
                            $user_id = $row['User_ID'];
                            $name = $row['User_FirstName'] . " " . $row['User_MiddleName'] . " " . $row['User_LastName'];
                            $mobile_number = $row['User_MobileNumber'];
                            $user_type = $row['Type_Name'];  // Now fetched directly from the JOIN

                            // Skip 'Admin' users
                            if ($user_type == "Admin") {
                                continue; // Skip this user
                            }
                            
                            // Only show 'Farmer' or 'Vendor'
                            if ($user_type == "Farmer" || $user_type == "Vendor") {

                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 border">
                                    <div class="col-md-1 d-flex justify-content-center">' . htmlspecialchars($user_id) . '</div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <img src="../images/farm.jpg" class="rounded-circle mx-2" alt="Specific Image" height="80px" width="80px">' . htmlspecialchars($name) . '
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">' . htmlspecialchars($mobile_number) . '</div>
                                    <div class="col-md-2 d-flex justify-content-center">' . htmlspecialchars($user_type) . '</div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <span class="mx-2">
                                            <a href="admin_account_update.php?user_id=' . htmlspecialchars($user_id) . '" class="btn btn-sm bg-dark text-light">Edit</a>
                                        </span>
                                        <span>
                                            <form action="components/account_status_update.php" method="post">
                                                <input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">
                                                <button name="activate" class="btn btn-sm bg-dark text-light mx-2">Activate</button>
                                                <button name="deactivate" class="btn btn-sm bg-dark text-light mx-2">Deactivate</button>
                                            </form>
                                        </span>
                                    </div>
                                </div>';
                                
                            }
                        }
                        ?>
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
                            <li class="nav-item"><a href="admin_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                            <li class="nav-item"><a href="../customer_support_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
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
