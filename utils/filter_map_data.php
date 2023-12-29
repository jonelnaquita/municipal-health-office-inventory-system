<?php
// Include your database connection file
include('../db_connect.php');

// Get filter parameters from the AJAX request
$selectedDate = $_GET['date'];
$selectedProduct = $_GET['product'];

// Construct the SQL query based on the filter parameters
$sql = "SELECT h.latitude, h.longitude, h.brgy_name, SUM(ir.quantity) as request_count, ms.sub_category_name, ms.brand_name
        FROM heat_map h
        LEFT JOIN patient_list p ON h.brgy_name = p.address
        LEFT JOIN item_requested ir ON p.id = ir.patient_id
        LEFT JOIN product_list pl ON ir.product_id = pl.id
        LEFT JOIN manage_sub_category ms ON pl.sub_category_id = ms.id
        WHERE DATE(ir.availed_date) = '$selectedDate'";

if (!empty($selectedProduct)) {
    $sql .= " AND pl.id = '$selectedProduct'";
}

$sql .= " GROUP BY h.latitude, h.longitude, h.brgy_name";

// Execute the query
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}

$filteredData = $result->fetch_all(MYSQLI_ASSOC);

// Convert the data format to [lat, lng, intensity]
$formattedData = [];
foreach ($filteredData as $dataPoint) {
    $formattedData[] = [
        $dataPoint['latitude'],
        $dataPoint['longitude'],
        $dataPoint['request_count'], // Use request count as intensity
        $dataPoint['brgy_name'],     // Add brgy_name for the popup
    ];
}

// Return the filtered data as JSON
echo json_encode($formattedData);
?>
