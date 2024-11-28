<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['delete_product'])) {
    // Step 1: Get product information from the database
    $product_id = $_POST['product_id'];
    $getproduct_info_qry = "SELECT * FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($getproduct_info_qry);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $category_id = $row['Category_ID'];
        $subcategory_id = $row['SubCategory_ID']; 
        $inventory_id = $row['Inventory_ID'];
    }

    // Step 2: Delete from order_details and related order_status_history (if they exist)
    $delete_order_status_history_query = "DELETE FROM order_status_history WHERE order_ID IN (SELECT order_ID FROM order_item WHERE product_ID = ?)";
    $stmt = $connect->prepare($delete_order_status_history_query);
    $stmt->bind_param('i', $product_id);

    if ($stmt->execute()) {
        // Optionally, delete related records from order_status_history
        $delete_order_details_query = "DELETE FROM order_details WHERE order_ID IN (SELECT order_ID FROM order_item WHERE product_ID = ?)";
        $stmt = $connect->prepare($delete_order_details_query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
    } else {
        echo "Error deleting order details: " . $stmt->error . "<br>";
    }

    // Step 3: Delete the product (Cascading delete will automatically handle the related records)
    $delete_product_query = "DELETE FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($delete_product_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        // After deleting product, check if category, subcategory, and inventory need to be deleted
        // Check if no products are left in the subcategory
        $check_products_in_subcategory_query = "SELECT COUNT(*) AS product_count FROM product WHERE SubCategory_ID = ?";
        $stmt = $connect->prepare($check_products_in_subcategory_query);
        $stmt->bind_param('i', $subcategory_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['product_count'] == 0) {
            // No products left in this subcategory, so delete it
            $subcategory_query = "DELETE FROM sub_category WHERE SubCategory_ID = ?";
            $stmt = $connect->prepare($subcategory_query);
            $stmt->bind_param('i', $subcategory_id);
            $stmt->execute();
        }

        // Check if no products are left in the category
        $check_products_in_category_query = "SELECT COUNT(*) AS product_count FROM product WHERE Category_ID = ?";
        $stmt = $connect->prepare($check_products_in_category_query);
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['product_count'] == 0) {
            // No products left in this category, so delete it
            $category_query = "DELETE FROM category WHERE Category_ID = ?";
            $stmt = $connect->prepare($category_query);
            $stmt->bind_param('i', $category_id);
            $stmt->execute();
        }

        // Check if no products are left in the inventory
        $check_inventory_query = "SELECT COUNT(*) AS product_count FROM product WHERE Inventory_ID = ?";
        $stmt = $connect->prepare($check_inventory_query);
        $stmt->bind_param('i', $inventory_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['product_count'] == 0) {
            // No products left in this inventory, so delete it
            $inventory_query = "DELETE FROM inventory WHERE Inventory_ID = ?";
            $stmt = $connect->prepare($inventory_query);
            $stmt->bind_param('i', $inventory_id);
            $stmt->execute();
        }

        // Success message
        echo "Product and related records deleted successfully.<br>";
        echo "<script language='JavaScript'>";
        echo "window.location = \"../seller_store_page.php\";";
        echo "</script>";
    } else {
        echo "Error deleting product: " . $stmt->error . "<br>";
    }
}
?>
