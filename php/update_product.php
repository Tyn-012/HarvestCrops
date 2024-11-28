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
                <a href="seller_store_page.php" class="text-decoration-none text-dark m-2"><i class="fa-solid fa-backward"></i> back</a>
                <div class="col-md-12 d-flex justify-content-center mt-4 bg-dark">
                    <h4 class="text-light m-2">Product Update</h4>
                </div>
            </div>
        </div>
    </div>
    <form action="components/update_product_listing.php" method="post">
        <div class="container">
            <div class="section">
                <div class="row rounded d-flex justify-content-center bg-warning">
                    <div class="col-md-12 p-4">
                        <div class="col-md-12 mb-4">
                            <label class="fw-bold">Product Name</label>
                            <input type="text" name="product-name" class="form-control mb-2"
                                placeholder="Name" required autofocus>
                            <label class="fw-bold">Product Description</label>
                            <input type="text" name="product-desc" class="form-control mb-2"
                                placeholder="Product Description" required autofocus>
                            <label class="fw-bold">Quantity</label>
                            <input type="text" name="product-quantity" class="form-control mb-2"
                                placeholder="Product Quantity" required autofocus>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Product Price</label>
                                <input type="text" name="product-price" class="form-control mb-2"
                                    placeholder="Price" required autofocus>
                            </div>
                            <div class="col-md-6 mb-4">  
                                <label class="fw-bold">Shelf Life</label>
                                <input type="text" name="shelf-life" class="form-control mb-2"
                                    placeholder="Time" required autofocus>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Shelf Life Unit</label>
                                <select class="form-control mb-2" name="shelf-life-unit" required>
                                    <option value="shelf_life_Unit" disabled selected>Unit</option>
                                    <option value="days">Days</option>
                                    <option value="weeks">Weeks</option>
                                    <option value="months">Months</option>
                                </select>
                                <input type="checkbox" name="is-organic" value="organic" class="me-2"><label class="fw-bold">Organic</label>
                                <input type="checkbox" name="bulk-available" value="bulk" class="me-2"><label class="fw-bold">Bulk Available</label> 
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold">Product Type</label>
                                <select class="form-control mb-2" name="product-type" required>
                                    <option value="product_type" disabled selected>Type</option>
                                    <option value="fruits">Fruits</option>
                                    <option value="vegetables">Vegetables</option>
                                    <option value="grains">Grains</option>
                                    <option value="rootcrops">Rootcrops</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-4">
                        <div class="mb-3">
                            <label for="dateInput" class="form-label">Choose a date:</label>
                            <input type="date" class="form-control" name="harvest-date" id="dateInput" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4 d-flex justify-content-center align-items-center">
                        <button class="btn btn-md bg-dark text-light rounded" type="submit"
                            name="submit">Update Product</button>
                    </div>
                </div>
            </div>
        </div>       
    </form>
</body>
</html>