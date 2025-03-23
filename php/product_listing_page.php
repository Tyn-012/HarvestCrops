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
    <title>HarvestCrops - Product Listing Page</title>
</head>
<body class="bg-F0E5AF body-font">
<nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section" >
                <div class="row d-flex justify-content-center align-items-center p-1" >
                    <div class="col-md-4 mt-2">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-center">                       
                        <a class="anc-page px-3" href="farmer_account_page.php">My Account</a>
                        <a class="anc-page px-3 c-cfe1b9" href="seller_store_page.php">Shop</a>
                        <a class="anc-page px-3" href="customer_support_page_vendor.php">Customer Support</a>
                        <a class="anc-page px-3" href="order_page.php">Orders</a>
                        <?php include 'components/logout_component.php'?>
                        <a href="#" class="fa-solid fa-user icon-ds-profile px-2 py-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <form action="components/add_product.php" method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center m-2 p-2 pt-5">
                        <h2>Add a Product</h2>
                    </div>
                    <div class="col"><div class="bg-1E5915 p-2 rounded mb-4 me-3"></div></div>
                    <div class="container p-4">
                        <div class="section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="col-md-12 d-flex align-items-center border-bottom">
                                            <input type="file" id="imageInput" name="image" accept="image/*" required>
                                        </div>
                                        <div class="col-md-12 border">
                                        <img class="card-img" id="imagePreview" alt="Image Preview" width="622px" height="500px">
                                        </div>
                                        <script>
                                            const imageInput = document.getElementById('imageInput');
                                            const imagePreview = document.getElementById('imagePreview');
                                    
                                            imageInput.addEventListener('change', function() {
                                                const file = this.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                    
                                                    reader.onload = function(e) {
                                                        imagePreview.src = e.target.result;
                                                        imagePreview.style.display = 'block';
                                                    }
                                    
                                                    reader.readAsDataURL(file);
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="container">
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center align-items-center pt-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <span class="d-flex justify-content-center shadow">
                                        <span class="account-add-tab">
                                        </span>
                                    </span>
                                    <div class="container bg-cfe1b9 shadow">
                                        <div class="section">
                                            <div class="row">
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
                                                                <option value="Fruits">Fruits</option>
                                                                <option value="Vegetables">Vegetables</option>
                                                                <option value="Grains">Grains</option>
                                                                <option value="Rootcrops">Rootcrops</option>
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
                                                    <button class="btn btn-md bg-1e5915 c-e9ffff rounded" type="submit"
                                                        name="submit">Add Product</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2 bg-1E5915"></div>
    <footer class="nav bg-84B68F">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center">
                        <li class="nav-item nav-a"><a href="farmer_account_page.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                        <li class="nav-item nav-a"><a href="../src/FAQS_page.html" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                        </ul>
                        <hr>
                        <span class="d-flex justify-content-center fw-bold"> &copy; 2024 AspireProgrez - All Rights Reserved</span> <!-- EDIT -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>