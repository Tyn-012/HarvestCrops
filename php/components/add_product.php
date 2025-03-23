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

            // Integrate content moderation API
            $params = array(
                'media' => new CurlFile($targetFilePath),
                'models' => 'nudity-2.1,weapon,gore-2.0,recreational_drug,medical,alcohol,offensive,gambling,tobacco',
                'api_user' => '1090394615',
                'api_secret' => 'mio2dpNHDNpMfvaZpqoVRTqjdaAwEt4W',
            );

            $ch = curl_init('https://api.sightengine.com/1.0/check.json');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $response = curl_exec($ch);
            curl_close($ch);

            $output = json_decode($response, true);

            // Check if the image is safe
            if (isset($output['weapon']['classes']['firearm']) && $output['weapon']['classes']['firearm'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Firearms | Weapons)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            } 
            else if (isset($output['nudity']['sexual_activity']) && $output['nudity']['sexual_activity'] > 0.5 OR
                       isset($output['nudity']['sexual_display']) && $output['nudity']['sexual_display'] > 0.5 OR
                       isset($output['nudity']['erotica']) && $output['nudity']['erotica'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Nudity | Erotica)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            } 
            else if (isset($output['gore']['prob']) && $output['gore']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Gore)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['recreational_drug']['prob']) && $output['recreational_drug']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Recreational Drugs)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['medical']['prob']) && $output['medical']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Medical Drugs)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['alcohol']['prob']) && $output['alcohol']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Alcohol)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['offensive']['prob']) && $output['offensive']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Offensive)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['gambling']['prob']) && $output['gambling']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Gambling)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }
            else if (isset($output['tobacco']['prob']) && $output['tobacco']['prob'] > 0.5) {
                echo "<script>alert('Image contains inappropriate content (Tobacco)');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                unlink($targetFilePath);
                exit();
            }

            // Collect product data from the form and validate it
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

            // Validate product name and description (ensure they are text)
            if (!preg_match("/^[A-Za-z\s]+$/", $productName)) {
                echo "<script>alert('Product name must contain only letters and spaces.');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                exit();
            }

            if (!preg_match("/^[A-Za-z\s]+$/", $productDesc)) {
                echo "<script>alert('Product description must contain only letters and spaces.');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                exit();
            }

            // Validate product price, shelf life, and quantity (ensure they are numbers)
            if (!is_numeric($productPrice)) {
                echo "<script>alert('Product price must be a valid number.');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                exit();
            }

            if (!is_numeric($shelfLife)) {
                echo "<script>alert('Shelf life must be a valid number.');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                exit();
            }

            if (!is_numeric($quantity)) {
                echo "<script>alert('Product quantity must be a valid number.');</script>";
                echo "<script language = 'JavaScript'>window.location = \"../seller_store_page.php\";</script>";
                exit();
            }

            // Handle category description
            if ($product_type == 'Fruits') {
                $category_description = "Apples, Watermelon, Banana etc.";
            } else if ($product_type == 'Vegetables') {
                $category_description = "Cabbage, Lettuce etc.";
            } else if ($product_type == 'Grains') {
                $category_description = "Rice, Wheat etc.";
            } else if ($product_type == 'Rootcrops') {
                $category_description = "Potatoes, Carrots, Sweet Potatoes etc.";
            }

            // Insert category, subcategory, and inventory
            $category_query = "INSERT INTO category (Category_Name, Category_Desc) VALUES ('$product_type', '$category_description')";
            if (mysqli_query($connect, $category_query)) {
                $categoryID = mysqli_insert_id($connect);
            } else {
                echo "Error inserting category: " . mysqli_error($connect);
                exit;
            }

            $subcategory_query = "INSERT INTO sub_category (Category_ID, SubCategory_Name) VALUES ('$categoryID', '$product_type')";
            if (mysqli_query($connect, $subcategory_query)) {
                $subcategoryID = mysqli_insert_id($connect);
            } else {
                echo "Error inserting subcategory: " . mysqli_error($connect);
                exit;
            }

            // Insert inventory and get the last inserted Inventory_ID
            $inventory_query = "INSERT INTO inventory (harvest_date, quantity) VALUES ('$harvestdate', '$quantity')";
            if (mysqli_query($connect, $inventory_query)) {
                $inventoryID = mysqli_insert_id($connect); // Get the last inserted Inventory_ID
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
                    echo "window.location = \"../seller_store_page.php\";";
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
