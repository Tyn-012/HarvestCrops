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
    <title>HarvestCrops - Admin Page</title>
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
    <nav class="p-3 bg-397F35">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <img src="../images/plots.jpg" class="border rounded-circle" width="60px" height="60px" alt="">
                        <p class="anc-page px-2 pt-2 admin_txt_ds"><?php echo $_SESSION['name']; ?></p>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">
                        <form action="components/logout.php" method="post">
                            <button class="admin_btn btn-sm text-md " type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section desktop_display">
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
                            if ($user_type == "Farmer" || $user_type == "Vendor" || $user_type == "Organization") {

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
                    <div class="section med_mobile_display">                        
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
                            if ($user_type == "Farmer" || $user_type == "Vendor" || $user_type == "Organization") {

                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 rounded-3 bg-ECF39E p-3 m-3">
                                    <div class="col-md-7 d-flex justify-content-center mb-3">' .   
                                        '<img src="../images/farm.jpg" class="rounded-circle mx-2 me-4" alt="Specific Image" height="80px" width="80px">' . 
                                        'ID: '. htmlspecialchars($user_id) . '<br>' .
                                        'Name: '. htmlspecialchars($name) . '<br>' .
                                        'Mobile Number: '. htmlspecialchars($mobile_number) . '<br>' .
                                        'Type: '. htmlspecialchars($user_type) . '<br>' .
                                    '</div>' .

                                    '<div class="col-md-5 d-flex admin_btn_scale_ds justify-content-center">
                                        <span class="mx-2">
                                            <a href="admin_account_update.php?user_id=' . htmlspecialchars($user_id) . '" class="btn btn-sm bg-dark text-light">Edit</a>
                                        </span>
                                        <span>
                                            <form action="components/account_status_update.php" method="post">
                                                <input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">
                                                <button name="activate" class="btn btn-sm bg-dark text-light mx-1">Activate</button>
                                                <button name="deactivate" class="btn btn-sm bg-dark text-light mx-1">Deactivate</button>
                                            </form>
                                        </span>
                                    </div>' . 
                                '</div>' . '<hr>';                                                   
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
