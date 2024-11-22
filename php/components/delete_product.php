<?php
session_start();
include 'connect.php';



if (isset($_POST['delete_product'])) {
    // Step 1: Get product information from the database
    $product_id = $_POST['product_id'];
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

    // Step 2: Delete associated images
    $image_query = "SELECT * FROM product_images WHERE Product_ID = ?";
    $stmt = $connect->prepare($image_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($image = $result->fetch_assoc()) {
        $image_ID = $image['image_ID'];
        $image_path = "../" . $image['image_url'];  // Assuming 'image_url' stores the file path of the image

        // Delete the image record from the database
        $delete_image_query = "DELETE FROM product_images WHERE image_ID = ?";
        $stmt = $connect->prepare($delete_image_query);
        $stmt->bind_param('i', $image_ID);
        if (!$stmt->execute()) {
            echo "Error deleting image from database: " . $stmt->error . "<br>";
            exit;
        }

        // Delete the image file from the server (assuming images are stored in the 'uploads/' directory)
        if (file_exists($image_path)) {
            unlink($image_path);  // Delete the image file from the server
        } else {
            echo "Image file not found: " . $image_path . "<br>";
        }
    }

    // Step 3: Delete the product record from the product table (this will cascade to delete images, inventory, etc. if foreign keys are set)
    $delete_product_query = "DELETE FROM product WHERE Product_ID = ?";
    $stmt = $connect->prepare($delete_product_query);
    $stmt->bind_param('i', $product_id);
    if (!$stmt->execute()) {
        echo "Error deleting product: " . $stmt->error . "<br>";
        exit;
    }

    // Step 4: Check if there are any products left for this subcategory before deleting the subcategory
    $check_products_in_subcategory_query = "SELECT COUNT(*) AS product_count FROM product WHERE SubCategory_ID = ?";
    $stmt = $connect->prepare($check_products_in_subcategory_query);
    $stmt->bind_param('i', $subcategory_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['product_count'] == 0) {
        // Only delete the subcategory if no other products are linked to it
        $subcategory_query = "DELETE FROM sub_category WHERE SubCategory_ID = ?";
        $stmt = $connect->prepare($subcategory_query);
        $stmt->bind_param('i', $subcategory_id);
        if (!$stmt->execute()) {
            echo "Error deleting subcategory: " . $stmt->error . "<br>";
            exit;
        }
    } else {
        echo "Subcategory has other products linked. It will not be deleted.<br>";
    }

    // Step 5: Delete the inventory record if it's not used by other products
    $inventory_query = "DELETE FROM inventory WHERE Inventory_ID = ?";
    $stmt = $connect->prepare($inventory_query);
    $stmt->bind_param('i', $inventory_id);
    if (!$stmt->execute()) {
        echo "Error deleting inventory: " . $stmt->error . "<br>";
        exit;
    }

    // Step 6: Delete the category record (only if it has no other products linked to it)
    $check_products_in_category_query = "SELECT COUNT(*) AS product_count FROM product WHERE Category_ID = ?";
    $stmt = $connect->prepare($check_products_in_category_query);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['product_count'] == 0) {
        // Only delete the category if no other products are linked to it
        $category_query = "DELETE FROM category WHERE Category_ID = ?";
        $stmt = $connect->prepare($category_query);
        $stmt->bind_param('i', $category_id);
        if (!$stmt->execute()) {
            echo "Error deleting category: " . $stmt->error . "<br>";
            exit;
        }
    } else {
        echo "Category has other products linked. It will not be deleted.<br>";
    }

    // Success message
    echo "Product and related records deleted successfully.<br>";
    echo "<script language = 'JavaScript'>";
    echo "window.location = \"../seller_store_page.php\";
    </script>";
}
?>
