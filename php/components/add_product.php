<?php
session_start();
include 'connect.php';
$userid = $_SESSION['user_id'];

if (!isset($_SESSION['name'])) {
    header('Location: ../../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directory to save uploaded images
    $targetDir = "../../images/product_uploads/";

    // Create the uploads directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Get the file details
    $fileName = basename($_FILES["image"]["name"]);
    $fileTmpPath = $_FILES["image"]["tmp_name"];  // Temporary path of the uploaded file
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if the file type is allowed
    if (in_array($fileType, $allowedTypes)) {
        // Generate a new unique name for the file
        $newFileName = uniqid('img_', true) . '.' . $fileType;

        // Set the new target file path with the new name
        $targetFilePath = $targetDir . $newFileName;

        // Move the uploaded file to the target directory with the new name
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            echo "The file has been uploaded successfully as " . htmlspecialchars($newFileName);

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

            // Insert category, subcategory, and inventory
            $category_query = "INSERT INTO category (Category_Name, Category_Desc) VALUES ('$product_type', '$category_description')";
            if (mysqli_query($connect, $category_query)) {
                $categoryID = mysqli_insert_id($connect);
                echo "Category added with ID: $categoryID<br>";
            } else {
                echo "Error inserting category: " . mysqli_error($connect);
                exit;
            }

            $subcategory_query = "INSERT INTO sub_category (Category_ID, SubCategory_Name) VALUES ('$categoryID', '$product_type')";
            if (mysqli_query($connect, $subcategory_query)) {
                $subcategoryID = mysqli_insert_id($connect);
                echo "SubCategory added with ID: $subcategoryID<br>";
            } else {
                echo "Error inserting subcategory: " . mysqli_error($connect);
                exit;
            }

            // Insert inventory and get the last inserted Inventory_ID
            $inventory_query = "INSERT INTO inventory (harvest_date, quantity) VALUES ('$harvestdate', '$quantity')";
            if (mysqli_query($connect, $inventory_query)) {
                $inventoryID = mysqli_insert_id($connect); // Get the last inserted Inventory_ID
                echo "Inventory added with ID: $inventoryID<br>";
            } else {
                echo "Error inserting inventory: " . mysqli_error($connect);
                exit;
            }

            // Insert product details into the `product` table
            $product_query = "INSERT INTO product (Category_ID, SubCategory_ID, Inventory_ID, Product_Name, Product_Desc,  product_price, shelf_life, shelf_life_unit, is_organic, bulk_available, User_ID)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($product_query);
            $stmt->bind_param("iiissdssiii", $categoryID, $subcategoryID, $inventoryID, $productName, $productDesc,  $productPrice, $shelfLife, $shelfLifeUnit, $isOrganic, $bulkAvailable, $userid);
            if ($stmt->execute()) {
                $productID = $stmt->insert_id; // Get the auto-incremented ID of the inserted product

                // Insert image details into the `product_images` table
                // Remove one '../' from the path (so it's relative to the web root)
                $imageRelativePath = substr($targetFilePath, 3); // Removes the leading '../' part

                $imageQuery = "INSERT INTO product_images (Product_ID, image_url) VALUES (?, ?)";
                $imageStmt = $connect->prepare($imageQuery);
                $imageStmt->bind_param("is", $productID, $imageRelativePath); // Save relative path to DB
                if ($imageStmt->execute()) {
                    echo "<script language = 'JavaScript'>
                    alert('Product Listed Successfully');";
                    echo "window.location = \"../farmer_account_page.php\";";
                    echo "</script>";
                } else {
                    echo "Error inserting image into database: " . $imageStmt->error;
                }

            } else {
                echo "Error inserting product into database: " . $stmt->error;
            }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

} else {
    echo "Invalid request.";
}
?>
