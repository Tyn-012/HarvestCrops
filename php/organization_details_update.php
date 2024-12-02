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
    <title>HarvestCrops - Orgranization Update</title>
</head>
<body class="update_farmer_bg">
    <section class="mt-5 pt-5">
        <form class="rounded" action="components/organization_info_update.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 mb-4">
                    <div class="row p-5 m-4 d-flex align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none text-dark mb-5"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center">Update Organization Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><hr class="rounded bg-dark p-1"></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Organization Account Information</label>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="organization_name" class="form-control mb-2"
                                placeholder="Organization Name" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="contact_number" class="form-control mb-2"
                                placeholder="Contact Number" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="email_address" class="form-control mb-2"
                                placeholder="Email Address" required autofocus>
                        </div>
                        <hr>
                        <div class="col-md-12 d-flex justify-content-end align-items-center pt-4">
                            <button class="btn btn-lg bg-secondary rounded farmer_up_button-ds" type="submit"
                                name="submit">Update
                                Organization Account</button>
                        </div>

                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>

</html>