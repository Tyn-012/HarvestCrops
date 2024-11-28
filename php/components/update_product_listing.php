<?php
session_start();
include 'connect.php';

$product_id = $_SESSION['product_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if(isset($_POST['submit'])) {
    // Collect product data from the form 
    $productName = $_POST['product-name'];
    $productDesc = $_POST['product-desc'];
    $productPrice = $_POST['product-price'];
    $shelfLife = $_POST['shelf-life'];
    $shelfLifeUnit = $_POST['shelf-life-unit'];
    $isOrganic = isset($_POST['is-organic']) ? 1 : 0;
    $bulkAvailable = isset($_POST['bulk-available']) ? 1 : 0;
    $product_type = $_POST['product-type'];
    $harvestdate = $_POST['harvest-date'];
    $quantity = $_POST['product-quantity'];

    if ($product_type == 'fruits') {
        $category_description = "Apples, Watermelon, Banana etc.";
    } else if ($product_type == 'vegetables') {
        $category_description = "Cabbage, Lettuce etc.";
    } else if ($product_type == 'grains') {
        $category_description = "Rice, Wheat etc.";
    } else if ($product_type == 'rootcrops') {
        $category_description = "Potatoes, Carrots, Sweet Potatoes etc.";
    }

    $getproduct_info_qry = "SELECT * FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($getproduct_info_qry);
    $stmt->bind_param('s', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $category_id = $row['Category_ID'];
        $subcategory_id = $row['SubCategory_ID']; 
        $inventory_id = $row['Inventory_ID'];
    }


    //NEEDS TO BE EDITTED
    // Insert category, subcategory, and inventory
    $category_query = "UPDATE category SET Category_Name = '$product_type', Category_Desc = '$category_description' WHERE Category_ID = $category_id";
    if (mysqli_query($connect, $category_query)) {
        echo "Category updated successfully.<br>";
    } else {
        echo "Error updating category: " . mysqli_error($connect);
        exit;
    }

    $subcategory_query = "UPDATE sub_category SET SubCategory_Name = '$product_type'  WHERE SubCategory_ID = $subcategory_id";
    if (mysqli_query($connect, $subcategory_query)) {
        echo "SubCategory updated successfully.<br>";
    } else {
        echo "Error updating subcategory: " . mysqli_error($connect);
        exit;
    }

    // Insert inventory and get the last inserted Inventory_ID
    $inventory_query = "UPDATE inventory SET harvest_date = '$harvestdate', quantity = '$quantity' WHERE Inventory_ID = $inventory_id";
    if (mysqli_query($connect, $inventory_query)) {
        echo "Inventory updated successfully.<br>";
    } else {
        echo "Error updating inventory: " . mysqli_error($connect);
        exit;
    }
    

    // Insert product details into the `product` table
    $product_query = "UPDATE product 
    SET Product_Name = ?, Product_Desc = ?, product_price = ?, shelf_life = ?, shelf_life_unit = ?, is_organic = ?, bulk_available = ? 
    WHERE Product_ID = ?";

    $stmt = $connect->prepare($product_query);

    // Bind the parameters correctly
    $stmt->bind_param("ssdssiii", 
    $productName, $productDesc, $productPrice, 
    $shelfLife, $shelfLifeUnit, $isOrganic, $bulkAvailable, 
    $product_id);  // Bind the Product_ID

    if ($stmt->execute()) {
        echo "<script language = 'JavaScript'>
        alert('Product updated successfully.');";
        echo "window.location = \"../seller_store_page.php\";
        </script>";
    } else {
        echo "Error updating product: " . $stmt->error . "<br>";
        exit;
    }


}
?>