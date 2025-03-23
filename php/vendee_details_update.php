<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$getvendor_info_qry = "SELECT * FROM vendor_details WHERE User_ID = ?";
$stmt = $connect->prepare($getvendor_info_qry);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $business_name = $row['business_name'];
    $business_type = $row['business_type'];
    $tax_id = $row['tax_id'];
    $years_in_business = $row['years_in_business'];
    $product_types = $row['product_types'];
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
    <title>HarvestCrops - Vendee Account Update</title>
</head>
<body class="update_farmer_bg">
    <section class="mt-5 pt-5">
        <form class="rounded" action="components/vendee_info_update.php" method="post">
            <div class="container">
                <div class="section bg-cfe1b9 mb-4 shadow rounded-3">
                    <div class="row p-5 m-4 d-flex align-items-center">
                        <a href="javascript:history.back();" class="text-decoration-none c-397F35 mb-4"><i class="fa-solid fa-backward"></i> back</a>
                        <h1 class="h3 mb-3 d-flex justify-content-center c-2E4F21">Update Vendee Account</h1>
                        <div class="col-md-1"></div>
                        <div class="col-md-10"><div class="bg-1E5915 p-1 rounded mb-4 me-3"></div></div>
                        <div class="col-md-1"></div>
                        <label class="p-3 fw-bold">Vendee Account Information</label>
                        <div class="col-md-4 mb-4">
                            <input type="text" value="<?php echo $business_name;?>" name="business_name" class="form-control mb-2"
                                placeholder="Business Name" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" value="<?php echo $tax_id;?>" name="tax_id" class="form-control mb-2"
                                placeholder="Tax ID" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <select name="business_type" class="form-control" id="business_type" required>
                                <option value="Type" disabled selected>Business Type</option>
                                <option value="Retailer" <?php echo ($business_type == 'Retailer') ? 'selected' : ''; ?>>Retailer</option>
                                <option value="Wholesaler" <?php echo ($business_type == 'Wholesaler') ? 'selected' : ''; ?>>Wholesaler</option>
                                <option value="Distributor" <?php echo ($business_type == 'Distributor') ? 'selected' : ''; ?>>Distributor</option>
                                <option value="Other" <?php echo ($business_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" value="<?php echo $years_in_business;?>" name="yr_in_business" class="form-control mb-2"
                                placeholder="Years in Business" required autofocus>
                        </div>
                        <div class="col-md-4 mb-4">
                            <input type="text" value="<?php echo $product_types;?>" name="product_types" class="form-control mb-2"
                                placeholder="Product Type" required autofocus>
                        </div>
                        <hr>
                        <div class="col-md-12 d-flex justify-content-end align-items-center pt-4">
                            <button class="btn btn-lg bg-1e5915 c-e9ffff rounded farmer_up_button-ds" type="submit"
                                name="submit">Update
                                Vendee Account</button>
                        </div>

                    </div>
                </div>
            </div>
        </form> 
    </section>
</body>

</html>