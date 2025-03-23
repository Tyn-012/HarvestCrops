<?php
// Start the session to access session variables
session_start();

// Check if the user has switched accounts and stored the email in the session
if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];  // Retrieve the email from the session
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
        <title>HarvestCrops - Switch User Page</title>
    </head>
    <body class="switch_user_page_bg">
        <div class="container">
            <div class="section pt-5">
                <div class="row pt-5">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 d-flex justify-content-center">
                        <div class="col-md-12 d-flex justify-content-center rounded px-5 bg-cfe1b9 border p-4 shadow">
                            <form class="text-dark" action="components/switch_account.php" method="post">
                                <div class="section">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-9 d-flex justify-content-center">
                                            <span id="logo_sign_in">
                                                <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo-signin">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="h3 mb-3 font-weight-normal d-flex justify-content-center pb-3 text-decoration-underline c-2E4F21">Switch Account</h1>
                                <div>
                                    <!-- Email field is pre-filled with the email stored in the session -->
                                    <div class="container">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-3 d-flex px-1 align-items-center">
                                                    <img src="../images/temp_icon.jpg" class="bg-light rounded-circle shadow" height="75px" width="75px" alt=""><br>
                                                </div>
                                                <div class="col-md-9 d-flex px-1 align-items-center">
                                                    <?php echo '<h5 class="c-2E4F21">' . htmlspecialchars($user_email) . '</h5>'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <input type="email" name="email" id="inputEmail" class="form-control mb-4" placeholder="Enter email" required autofocus hidden value="<?php echo htmlspecialchars($user_email); ?>">
                                    
                                    <label for="inputPassword">Password</label>
                                    <input type="password" name="password" id="inputPassword" class="form-control mb-2" placeholder="Enter password" required>
                                    
                                    <a class="password-text-ds text-secondary font-size-md" href="../src/forgot_password.html" name="forgot_password">Forgot your password?</a> 
                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-md mt-4 mb-4 sign-button-ds text-light border-0 bg-397F35" type="submit" name="signin">Log in</button>
                                    </div>
                                    <a href="../src/create_account.html" class="d-flex justify-content-center c-397F35 pb-2">Create a new account</a> 
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </body>
</html>
