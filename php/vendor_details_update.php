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
    <title>HarvestCrops - Vendor Account Update</title>
</head>
<body class="update_farmer_bg">
    <section class="mt-5 pt-5">
        <form class="rounded" action="components/vendor_info_update.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 mb-4">
                    <div class="row p-5 m-4 d-flex align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none text-dark"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center mb-5">Update Vendor Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><hr class="rounded bg-dark p-1"></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Vendor Account Information</label>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="business_name" class="form-control mb-2"
                                placeholder="Business Name" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="tax_id" class="form-control mb-2"
                                placeholder="Tax ID" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <select name="business_type" class="form-control" id="business_type" required>
                                <option value="Type" disabled selected>Business Type</option>
                                <option value="Retailer">Retailer</option>
                                <option value="Wholesaler">Wholesaler</option>
                                <option value="Distributor">Distributor</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="yr_in_business" class="form-control mb-2"
                                placeholder="Years in Business" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" name="product_types" class="form-control mb-2"
                                placeholder="Product Type" required autofocus>
                        </div>
                        <hr>
                        <div class="col-md-12 d-flex justify-content-end align-items-center pt-4">
                            <button class="btn btn-lg bg-secondary rounded farmer_up_button-ds" type="submit"
                                name="submit">Update
                                Vendor Account</button>
                        </div>

                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>

</html>