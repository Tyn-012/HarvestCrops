<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    // Step 1: Get product information from the database
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

    // Fetch the product image (optional for deletion)
    $getproduct_img_qry = "SELECT * FROM product_images WHERE Product_ID = ?";
    $stmt = $connect->prepare($getproduct_img_qry);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $image_path = '../'. $row['image_url'];
    }

    // Step 2: Delete related records from other tables

    // Delete from order_status_history
    $delete_order_status_history_query = "DELETE FROM order_status_history WHERE order_ID IN (SELECT order_ID FROM order_item WHERE product_ID = ?)";
    $stmt = $connect->prepare($delete_order_status_history_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        echo "Deleted from order_status_history.<br>";
    } else {
        echo "Error deleting from order_status_history: " . $stmt->error . "<br>";
    }

    $check_order_item_data_query = "SELECT * FROM order_item WHERE product_ID = ?";
    $stmt = $connect->prepare($check_order_item_data_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $order_id_from_order_item = $row["order_ID"];
    }

    // Delete from order_item
    $delete_order_item_query = "DELETE FROM order_item WHERE product_ID = ?";
    $stmt = $connect->prepare($delete_order_item_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        echo "Deleted from order_item.<br>";
    } else {
        echo "Error deleting from order_item: " . $stmt->error . "<br>";
    }

    // Delete from order_details
    $delete_order_details_query = "DELETE FROM order_details WHERE order_ID = ?";
    $stmt = $connect->prepare($delete_order_details_query);
    $stmt->bind_param('i', $order_id_from_order_item);
    if ($stmt->execute()) {
        echo "Deleted from order_details.<br>";
    } else {
        echo "Error deleting from order_details: " . $stmt->error . "<br>";
    }

    // Delete from shopping_cart
    $delete_shopping_cart_query = "DELETE FROM shopping_cart WHERE Product_ID = ?";
    $stmt = $connect->prepare($delete_shopping_cart_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        echo "Deleted from shopping_cart.<br>";
    } else {
        echo "Error deleting from shopping_cart: " . $stmt->error . "<br>";
    }

    // Delete from product_quantity_updates
    $delete_product_quantity_updates_query = "DELETE FROM product_quantity_updates WHERE Product_ID = ?";
    $stmt = $connect->prepare($delete_product_quantity_updates_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        echo "Deleted from product_quantity_updates.<br>";
    } else {
        echo "Error deleting from product_quantity_updates: " . $stmt->error . "<br>";
    }

    // Step 3: Delete the product
    $delete_product_query = "DELETE FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($delete_product_query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        echo "Product deleted.<br>";

        // Check if the file exists and delete it
        if (file_exists($image_path)) {
            if (unlink($image_path)) {
                echo "Image deleted successfully.<br>";
            } else {
                echo "Failed to delete the image. Please check file permissions.<br>";
            }
        } else {
            echo "File does not exist: $image_path.<br>";
        }

        // After deleting the product, check if category, subcategory, and inventory need to be deleted
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
        // Redirect to seller page after success
        echo "<script language='JavaScript'>";
        echo "window.location = \"../seller_store_page.php\";";
        echo "</script>";
    } else {
        echo "Error deleting product: " . $stmt->error . "<br>";
    }
}
?>
