<?php
session_start();
include 'connect.php';

$product_id = $_SESSION['product_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['submit'])) {
    // Collect product data from the form 
    $productName = trim($_POST['product-name']);
    $productDesc = trim($_POST['product-desc']);
    $productPrice = $_POST['product-price'];
    $shelfLife = $_POST['shelf-life'];
    $shelfLifeUnit = $_POST['shelf-life-unit'];
    $isOrganic = isset($_POST['is-organic']) ? 1 : 0;
    $bulkAvailable = isset($_POST['bulk-available']) ? 1 : 0;
    $product_type = $_POST['product-type'];
    $harvestdate = $_POST['harvest-date'];
    $quantity = $_POST['product-quantity'];

    // Validate product name and description (must be strings)
    if (!preg_match("/^[A-Za-z\s]+$/", $productName)) {
        echo "<script>alert('Error: Product name must be a valid string.');</script>";
        echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
        exit;
    }

    if ((!preg_match("/^[A-Za-z\s]+$/", $productDesc))) {
        echo "<script>alert('Error: Product description must be a valid string.');</script>";
        echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
        exit;
    }

    // Validate product price, shelf life, and quantity (must be numbers)
    if (!is_numeric($productPrice) || $productPrice <= 0) {
        echo "<script>alert('Error: Product price must be a valid number greater than 0.');</script>";
        echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
        exit;
    }

    if (!is_numeric($shelfLife) || $shelfLife <= 0) {
        echo "<script>alert('Error: Shelf life must be a valid number greater than 0.');</script>";
        echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
        exit;
    }

    if (!is_numeric($quantity) || $quantity < 0) {
        echo "<script>alert('Error: Product quantity must be a valid number.');</script>";
        echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
        exit;
    }

    // Determine category description based on product type
    if ($product_type == 'Fruits') {
        $category_description = "Apples, Watermelon, Banana etc.";
    } else if ($product_type == 'Vegetables') {
        $category_description = "Cabbage, Lettuce etc.";
    } else if ($product_type == 'Grains') {
        $category_description = "Rice, Wheat etc.";
    } else if ($product_type == 'Rootcrops') {
        $category_description = "Potatoes, Carrots, Sweet Potatoes etc.";
    }

    // Get product details from the database
    $getproduct_info_qry = "SELECT * FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($getproduct_info_qry);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . $connect->error . "');</script>";
        exit;
    }
    $stmt->bind_param('s', $product_id);
    if (!$stmt->execute()) {
        echo "<script>alert('Error executing query: " . $stmt->error . "');</script>";
        exit;
    }
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $category_id = $row['Category_ID'];
        $subcategory_id = $row['SubCategory_ID']; 
        $inventory_id = $row['Inventory_ID'];
    } else {
        echo "<script>alert('Error: Product not found.');</script>";
        exit;
    }

    // Update category
    $category_query = "UPDATE category SET Category_Name = ?, Category_Desc = ? WHERE Category_ID = ?";
    $category_stmt = $connect->prepare($category_query);
    if (!$category_stmt) {
        echo "<script>alert('Error preparing category update statement: " . $connect->error . "');</script>";
        exit;
    }
    $category_stmt->bind_param('ssi', $product_type, $category_description, $category_id);
    if (!$category_stmt->execute()) {
        echo "<script>alert('Error updating category: " . $category_stmt->error . "');</script>";
        exit;
    }

    // Update subcategory
    $subcategory_query = "UPDATE sub_category SET SubCategory_Name = ? WHERE SubCategory_ID = ?";
    $subcategory_stmt = $connect->prepare($subcategory_query);
    if (!$subcategory_stmt) {
        echo "<script>alert('Error preparing subcategory update statement: " . $connect->error . "');</script>";
        exit;
    }
    $subcategory_stmt->bind_param('si', $product_type, $subcategory_id);
    if (!$subcategory_stmt->execute()) {
        echo "<script>alert('Error updating subcategory: " . $subcategory_stmt->error . "');</script>";
        exit;
    }

    // Update inventory
    $inventory_query = "UPDATE inventory SET harvest_date = ?, quantity = ? WHERE Inventory_ID = ?";
    $inventory_stmt = $connect->prepare($inventory_query);
    if (!$inventory_stmt) {
        echo "<script>alert('Error preparing inventory update statement: " . $connect->error . "');</script>";
        exit;
    }
    $inventory_stmt->bind_param('sii', $harvestdate, $quantity, $inventory_id);
    if (!$inventory_stmt->execute()) {
        echo "<script>alert('Error updating inventory: " . $inventory_stmt->error . "');</script>";
        exit;
    }

    // Update product details
    $product_query = "UPDATE product 
    SET Product_Name = ?, Product_Desc = ?, product_price = ?, shelf_life = ?, shelf_life_unit = ?, is_organic = ?, bulk_available = ? 
    WHERE Product_ID = ?";

    $stmt = $connect->prepare($product_query);
    if (!$stmt) {
        echo "<script>alert('Error preparing product update statement: " . $connect->error . "');</script>";
        exit;
    }
    $stmt->bind_param("ssdssiii", 
        $productName, $productDesc, $productPrice, 
        $shelfLife, $shelfLifeUnit, $isOrganic, $bulkAvailable, 
        $product_id);  // Bind the Product_ID

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully.');</script>";
        echo "<script>window.location = \"../seller_store_page.php\";</script>";
    } else {
        echo "<script>alert('Error updating product: " . $stmt->error . "');</script>";
        exit;
    }
}
?>
