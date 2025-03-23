<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $_SESSION['product_id'] = $product_id;
} else;

$getproduct_info_qry = "SELECT * FROM product WHERE Product_ID = ?";
$stmt = $connect->prepare($getproduct_info_qry);
$stmt->bind_param('s', $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $category_id = $row['Category_ID'];
    $inventory_id = $row['Inventory_ID'];
    $prod_name = $row['Product_Name'];
    $prod_desc = $row['Product_Desc'];
    $prod_price = $row['product_price'];
    $shelf_life = $row['shelf_life'];
    $shelf_life_unit = $row['shelf_life_unit'];
    $is_organic = $row['is_organic'];
    $bulk_available = $row['bulk_available'];

}

$getinventory_info_qry = "SELECT * FROM inventory WHERE Inventory_ID = ?";
$stmt = $connect->prepare($getinventory_info_qry);
$stmt->bind_param('s', $inventory_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $harvestDate = $row['harvest_date'];
    $quantity = $row['quantity'];
}

$getcategory_qry = "SELECT * FROM sub_category WHERE Category_ID = ?";
$stmt = $connect->prepare($getcategory_qry);
$stmt->bind_param('s', $category_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $prod_type = $row['SubCategory_Name'];
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
    <title>HarvestCrops - Product Update</title>
</head>
<body class="product_update_bg">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start align-items-center">
                </div>
                <a href="seller_store_page.php" class="text-decoration-none c-397F35 mt-4"><i class="fa-solid fa-backward"></i> back</a>
                <div class="col-md-12 d-flex justify-content-center mt-4 bg-1E5915 rounded shadow">
                    <h4 class="text-light m-2">Product Update</h4>
                </div>
            </div>
        </div>
    </div>
    <form action="components/update_product_listing.php" method="post">
        <div class="container">
            <div class="section">
                <div class="row rounded d-flex justify-content-center bg-cfe1b9 shadow">
                    <div class="col-md-12 p-4">
                        <div class="col-md-12 mb-4">
                            <label class="fw-bold">Product Name</label>
                            <input type="text" value="<?php echo $prod_name; ?>" name="product-name" class="form-control mb-2"
                                placeholder="Name" required autofocus>
                            <label class="fw-bold">Product Description</label>
                            <input type="text" value="<?php echo $prod_desc; ?>" name="product-desc" class="form-control mb-2"
                                placeholder="Product Description" required autofocus>
                            <label class="fw-bold">Quantity</label>
                            <input type="text" value="<?php echo $quantity; ?>" name="product-quantity" class="form-control mb-2"
                                placeholder="Product Quantity" required autofocus>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Product Price</label>
                                <input type="text" value="<?php echo $prod_price; ?>" name="product-price" class="form-control mb-2"
                                    placeholder="Price" required autofocus>
                            </div>
                            <div class="col-md-6 mb-4">  
                                <label class="fw-bold">Shelf Life</label>
                                <input type="text" value="<?php echo $shelf_life; ?>" name="shelf-life" class="form-control mb-2"
                                    placeholder="Time" required autofocus>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Shelf Life Unit</label>
                                <select class="form-control mb-2" name="shelf-life-unit" required>
                                    <option value="shelf_life_Unit" disabled selected>Unit</option>
                                    <option value="days" <?php echo ($shelf_life_unit == 'days') ? 'selected' : ''; ?>>Days</option>
                                    <option value="weeks" <?php echo ($shelf_life_unit == 'weeks') ? 'selected' : ''; ?>>Weeks</option>
                                    <option value="months" <?php echo ($shelf_life_unit == 'months') ? 'selected' : ''; ?>>Months</option>
                                </select>
                                <input type="checkbox" name="is-organic" value="organic" class="me-2" <?php echo ($is_organic == 1) ? 'checked' : ''; ?>><label class="fw-bold">Organic</label>
                                <input type="checkbox" name="bulk-available" value="bulk" class="me-2" <?php echo ($bulk_available == 1) ? 'checked' : ''; ?>><label class="fw-bold">Bulk Available</label>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Product Type</label>
                                <select class="form-control mb-2" name="product-type" required>
                                    <option value="product_type" disabled selected>Type</option>
                                    <option value="Fruits" <?php echo ($prod_type == 'Fruits') ? 'selected' : ''; ?>>Fruits</option>
                                    <option value="Vegetables" <?php echo ($prod_type == 'Vegetables') ? 'selected' : ''; ?>>Vegetables</option>
                                    <option value="Grains" <?php echo ($prod_type == 'Grains') ? 'selected' : ''; ?>>Grains</option>
                                    <option value="Rootcrops" <?php echo ($prod_type == 'Rootcrops') ? 'selected' : ''; ?>>Rootcrops</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="dateInput" class="form-label">Choose a date:</label>
                                    <input type="date" class="form-control" name="harvest-date" id="dateInput" value="<?php echo $harvestDate; ?>" required>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-12 mb-2 mt-2 d-flex justify-content-center align-items-center">
                        <button class="btn btn-md bg-1e5915 c-e9ffff rounded" type="submit"
                            name="submit">Update Product</button>
                    </div>
                </div>
            </div>
        </div>       
    </form>
</body>
</html>