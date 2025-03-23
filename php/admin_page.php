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
<body class="bg-F0E5AF">
    <nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section" >
                <div class="row d-flex justify-content-center align-items-center p-1" >
                    <div class="col-md-4 mt-2 ">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">
                        <div class="col-md-12 d-flex justify-content-end align-items-center">
                        <?php include 'components/logout_component.php'?>
                        </div>     
                        <p class="bg-1e5915 c-e9ffff rounded p-2 mt-2"> Admin</p>                  
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div class="container">
        <div class="section">
            <div class="row mt-3">
                <div class="col-md-12 d-flex align-items-center">
                    <img src="../images/temp_icon.jpg" class="bg-cfe1b9 rounded-circle shadow" width="60px" height="60px" alt="">
                    <p class="px-2 pt-2 admin_txt_ds"><?php echo $_SESSION['name']; ?></p>
                </div> 
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col py-5">
                <div class="container">
                    <div class="section desktop_display">
                        <div class="row text-light bg-1E5915 ps-2 pt-2 rounded d-flex align-items-center">
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

                        // Loop through users and display only vendor or Vendee
                        while ($row = $user_info_result->fetch_assoc()) {
                            $user_id = $row['User_ID'];
                            $name = $row['User_FirstName'] . " " . $row['User_MiddleName'] . " " . $row['User_LastName'];
                            $mobile_number = $row['User_MobileNumber'];
                            $user_type = $row['Type_Name'];  // Now fetched directly from the JOIN

                            // Skip 'Admin' users
                            if ($user_type == "Admin") {
                                continue; // Skip this user
                            }
                            
                            // Only show 'Vendor' or 'Vendee'
                            if ($user_type == "Farmer" || $user_type == "Vendor" || $user_type == "Organization") {

                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 bg-cfe1b9 rounded shadow">
                                    <div class="col-md-1 d-flex justify-content-center">' . htmlspecialchars($user_id) . '</div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <img src="../images/temp_icon.jpg" class="rounded-circle shadow m-2 me-2" alt="Specific Image" height="80px" width="80px">' . htmlspecialchars($name) . '
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">' . htmlspecialchars($mobile_number) . '</div>
                                    <div class="col-md-2 d-flex justify-content-center">' . htmlspecialchars($user_type) . '</div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <span class="mx-2">
                                            <a href="admin_account_update.php?user_id=' . htmlspecialchars($user_id) . '" class="btn btn-sm bg-1e5915 c-e9ffff">Edit</a>
                                        </span>
                                        <span>
                                            <form action="components/account_status_update.php" method="post">
                                                <input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">
                                                <button name="activate" class="btn btn-sm bg-1e5915 c-e9ffff mx-2">Activate</button>
                                                <button name="deactivate" class="btn btn-sm bg-1e5915 c-e9ffff mx-2">Deactivate</button>
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

                        // Loop through users and display only Vendor or Vendee
                        while ($row = $user_info_result->fetch_assoc()) {
                            $user_id = $row['User_ID'];
                            $name = $row['User_FirstName'] . " " . $row['User_MiddleName'] . " " . $row['User_LastName'];
                            $mobile_number = $row['User_MobileNumber'];
                            $user_type = $row['Type_Name'];  // Now fetched directly from the JOIN

                            // Skip 'Admin' users
                            if ($user_type == "Admin") {
                                continue; // Skip this user
                            }
                            
                            // Only show 'Vendor' or 'Vendee'
                            if ($user_type == "Farmer" || $user_type == "Vendor" || $user_type == "Organization") {

                                echo '
                                <div class="row d-flex align-items-center mb-2 ps-2 rounded-3 bg-cfe1b9 p-3 m-3">
                                    <div class="col-md-7 d-flex justify-content-center mb-3">' .   
                                        '<img src="../images/farm.jpg" class="rounded-circle mx-2 me-4" alt="Specific Image" height="80px" width="80px">' . 
                                        'ID: '. htmlspecialchars($user_id) . '<br>' .
                                        'Name: '. htmlspecialchars($name) . '<br>' .
                                        'Mobile Number: '. htmlspecialchars($mobile_number) . '<br>' .
                                        'Type: '. htmlspecialchars($user_type) . '<br>' .
                                    '</div>' .

                                    '<div class="col-md-5 d-flex admin_btn_scale_ds justify-content-center">
                                        <span class="mx-2">
                                            <a href="admin_account_update.php?user_id=' . htmlspecialchars($user_id) . '" class="btn btn-sm bg-1e5915 c-e9ffff">Edit</a>
                                        </span>
                                        <span>
                                            <form action="components/account_status_update.php" method="post">
                                                <input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">
                                                <button name="activate" class="btn btn-sm bg-1e5915 c-e9ffff mx-1">Activate</button>
                                                <button name="deactivate" class="btn btn-sm bg-1e5915 c-e9ffff mx-1">Deactivate</button>
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
