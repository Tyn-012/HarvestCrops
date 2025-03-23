<?php
include 'components/connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: ../src/sign_in.html'); // Redirect to login page if not logged in
    exit();
}

// Assume the seller's ID is stored in a session or passed in some other way
$seller_id = $_SESSION['user_id'];  // Replace with the actual seller's ID

// Fetch product details along with category information for the seller
$product_data = [];

// Fetch product details with name, category ID, and seller ID
$cntprod_qry = "SELECT Product_ID, Product_Name, Category_ID FROM product WHERE User_ID = '$seller_id'"; 
$cntprod_rslt = mysqli_query($connect, $cntprod_qry);

if ($cntprod_rslt && mysqli_num_rows($cntprod_rslt) > 0) {
    while ($row = mysqli_fetch_assoc($cntprod_rslt)) {
        $product_data[$row['Product_ID']] = [
            'Product_Name' => $row['Product_Name'],
            'Category_ID' => $row['Category_ID']
        ]; 
    }
}

// Function to get sales grouped by all time (filter by seller's products)
function getSalesGroupedByAllTime() {
    global $connect, $product_data;

    // Get product IDs of the seller's products
    $product_ids = implode(",", array_keys($product_data));
    
    $cntprod_sales_qry = "
        SELECT 
            SUM(od.total) AS total_sales, 
            DATE_FORMAT(od.created_at, '%Y-%m') AS month_year
        FROM order_details od
        JOIN order_item oi ON oi.order_id = od.order_ID
        WHERE oi.product_id IN ($product_ids)  -- Only consider the seller's products
        GROUP BY month_year
    "; 

    $cntprod_sales_rslt = mysqli_query($connect, $cntprod_sales_qry);
    $sales_data = [];

    if ($cntprod_sales_rslt && mysqli_num_rows($cntprod_sales_rslt) > 0) {
        while ($row = mysqli_fetch_assoc($cntprod_sales_rslt)) {
            // Format the date to "Month Year" (e.g., January 2025)
            $month_year = $row['month_year'];
            $date = DateTime::createFromFormat('Y-m', $month_year);
            $formatted_month_year = $date->format('F Y');  // Format as "Month Year"
            
            // Store the formatted month-year as the key
            $sales_data[$formatted_month_year] = (float)$row['total_sales'];
        }
    }
    return $sales_data;
}

// Function to get item quantities grouped by product (total across all time)
function getItemsGroupedByProduct() {
    global $connect, $product_data;

    $cntprod_qty_qry = "
        SELECT 
            oi.product_id, 
            SUM(oi.quantity) AS total_quantity
        FROM order_item oi
        JOIN order_details od ON oi.order_id = od.order_ID
        WHERE oi.product_id IN (" . implode(",", array_keys($product_data)) . ")  -- Only consider the seller's products
        GROUP BY oi.product_id
    "; 

    $cntprod_qty_rslt = mysqli_query($connect, $cntprod_qty_qry);
    $items_data = [];

    if ($cntprod_qty_rslt && mysqli_num_rows($cntprod_qty_rslt) > 0) {
        while ($row = mysqli_fetch_assoc($cntprod_qty_rslt)) {
            $product_id = $row['product_id'];
            // Check if the product belongs to the current seller
            if (isset($product_data[$product_id])) {
                $product_name = $product_data[$product_id]['Product_Name'];
                $quantity = (int)$row['total_quantity'];

                // Aggregate quantities for each product
                if (!isset($items_data[$product_name])) {
                    $items_data[$product_name] = 0;
                }
                $items_data[$product_name] += $quantity;
            }
        }
    }

    return $items_data;
}

// Function to get item quantities grouped by category (total across all time)
function getItemsGroupedByCategory() {
    global $connect, $product_data;

    // Create an array to map category ID to category name
    $category_items_data = [];

    // Loop through product data to group by category
    foreach ($product_data as $product_id => $product_info) {
        $category_id = $product_info['Category_ID'];

        // Fetch category name from the category table
        $category_name = getCategoryNameById($category_id);

        // Now fetch the total quantity of items sold for each category
        $cntprod_qty_category_qry = "
            SELECT 
                SUM(oi.quantity) AS total_quantity
            FROM order_item oi
            JOIN order_details od ON oi.order_id = od.order_ID
            WHERE oi.product_id = $product_id  -- Only consider the current product
        "; 

        $cntprod_qty_category_rslt = mysqli_query($connect, $cntprod_qty_category_qry);

        if ($cntprod_qty_category_rslt && mysqli_num_rows($cntprod_qty_category_rslt) > 0) {
            $row = mysqli_fetch_assoc($cntprod_qty_category_rslt);
            $quantity = (int)$row['total_quantity'];

            // Aggregate quantities for each category
            if (!isset($category_items_data[$category_name])) {
                $category_items_data[$category_name] = 0;
            }
            $category_items_data[$category_name] += $quantity;
        }
    }

    return $category_items_data;
}

// Function to fetch category name by ID
function getCategoryNameById($category_id) {
    global $connect;
    $query = "SELECT Category_Name FROM category WHERE Category_ID = '$category_id'";
    $result = mysqli_query($connect, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Category_Name'];
    }
    return null;  // Return null if no category found
}

// Prepare data for JavaScript
$itemsAllTimeData = getItemsGroupedByProduct();
$categoryItemsAllTimeData = getItemsGroupedByCategory();

// Get sales data for all time
$salesAllTimeData = getSalesGroupedByAllTime();
?>

<!DOCTYPE html>
<html>
<head>
    <title>HarvestCrops - Statistics Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.min.js" rel="script"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);

        // Function to draw Sales Charts (line and bar)
        function drawSales() {
            var salesAllTime = [
                ['Month', 'Sales'],
                <?php
                // Loop through sales data for all time
                foreach ($salesAllTimeData as $month_year => $sales) {
                    echo "['" . $month_year . "', " . $sales . "],";
                }
                ?>
            ];

            var showSales = google.visualization.arrayToDataTable(salesAllTime);

            // BarChart with 3D options and custom colors
            var SalesBar = new google.visualization.ChartWrapper({
                chartType: 'BarChart',
                containerId: 'sales_div_bar',
                dataTable: showSales,
                options: {
                    title: 'Total Sales Over Time (Bar Chart)',
                    width: 1210,
                    height: 500,
                    is3D: true,
                    colors: ['#FF5733', '#33FF57', '#3357FF', '#FF33A5', '#F3E5AB', '#C70039', '#900C3F', '#581845'],
                    chartArea: {left: 120, top: 40, width: '80%', height: '70%'},
                    hAxis: {
                        title: 'Sales Amount',
                        minValue: 0
                    },
                }
            });

            SalesBar.draw();
        }

        // Function to draw Item Pie Chart (products, total quantity)
        function drawItems() {
            var itemsAllTime = [
                ['Product', 'Quantity'],
                <?php
                // Loop through combined quantities of each product
                foreach ($itemsAllTimeData as $product_name => $total_quantity) {
                    echo "['" . $product_name . "', " . $total_quantity . "],";
                }
                ?>
            ];

            var showItems = google.visualization.arrayToDataTable(itemsAllTime);

            // PieChart with 3D effect and custom colors
            var ItemsPie = new google.visualization.ChartWrapper({
                chartType: 'PieChart',
                containerId: 'items_div_pie',
                dataTable: showItems,
                options: {
                    title: 'Products Sold (Pie Chart)',
                    width: 550,
                    height: 400,
                    is3D: true,
                    slices: {
                        0: {offset: 0.1},
                        1: {offset: 0.1},
                        2: {offset: 0.1},
                    },
                    colors: ['#FF5733', '#33FF57', '#3357FF', '#FF33A5', '#F3E5AB', '#C70039', '#900C3F', '#581845'],
                    chartArea: {left: 100, top: 60, width: '80%', height: '70%'}
                }
            });

            ItemsPie.draw();
        }

        // Function to draw Category Pie Chart (categories, total quantity)
        function drawCategories() {
            var categoriesAllTime = [
                ['Category', 'Quantity'],
                <?php
                // Loop through combined quantities of each category
                foreach ($categoryItemsAllTimeData as $category_name => $total_quantity) {
                    echo "['" . $category_name . "', " . $total_quantity . "],";
                }
                ?>
            ];

            var showCategories = google.visualization.arrayToDataTable(categoriesAllTime);

            // PieChart with 3D effect and custom colors for categories
            var CategoriesPie = new google.visualization.ChartWrapper({
                chartType: 'PieChart',
                containerId: 'categories_div_pie',
                dataTable: showCategories,
                options: {
                    title: 'Products by Category (Pie Chart)',
                    width: 550,
                    height: 400,
                    is3D: true,
                    slices: {
                        0: {offset: 0.1},
                        1: {offset: 0.1},
                        2: {offset: 0.1},
                    },
                    colors: ['#FF5733', '#33FF57', '#3357FF', '#FF33A5', '#F3E5AB', '#C70039', '#900C3F', '#581845'],
                    chartArea: {left: 100, top: 60, width: '80%', height: '70%'}
                }
            });

            CategoriesPie.draw();
        }

        // Function to update charts (including new categories chart)
        function updateChart() {
            drawSales();
            drawItems();
            drawCategories();  // Add this to update categories chart
        }

        function drawChart() {
            updateChart();
        }
    </script>
</head>
<body class="bg-F0E5AF body-font">
    <nav class="bg-84B68F d-flex justify-content-center">
        <div class="container">
            <div class="section" >
                <div class="row d-flex justify-content-center align-items-center p-1" >
                    <div class="col-md-12 mt-2">
                        <span id="logo_part">
                            <img src="../images/HarvestCrops - Logo Version 1 (No BG).png" alt="Logo" id="logo">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="p-2 bg-1E5915"></div>
    <div class="container">
        <div class="section">
            <div class="col-md-12 mt-4 p-3">
                <a href="javascript:history.back();" class="text-decoration-none c-397F35 mb-5"><i class="fa-solid fa-backward"></i> back</a>
            </div>
        </div>
    </div>
    <div class="container p-3 bg-84B68F mb-5 rounded-4 border shadow ">
        <div class="row">
            <div class="col-md-12">
                <div id="sales_div_bar"></div>
            </div>
            <div class="col-md-6">
                <div id="items_div_pie"></div>
            </div>
            <div class="col-md-6">
                <div id="categories_div_pie"></div>
            </div>
        </div>
    </div>
    <div class="p-2 bg-1E5915"></div>
    <footer class="nav bg-84B68F">
        <div class="container">
            <div class="section">
                <div class="row d-flex mb-4">
                    <div class="col-md-12 pt-2">
                        <ul class="nav justify-content-center">
                        <li class="nav-item nav-a"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
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
